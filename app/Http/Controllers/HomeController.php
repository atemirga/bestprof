<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'home')->with('blocks')->first();
        $blocks = $page ? $page->blocks->keyBy('key') : collect();

        $rootCategories = Category::roots()->active()
            ->with(['children' => fn($q) => $q->active()->orderBy('sort_order')
                ->with(['children' => fn($q2) => $q2->active()->orderBy('sort_order')])])
            ->orderBy('sort_order')
            ->get();

        $products = Product::where('is_active', true)
            ->with('category.parent')
            ->orderBy('sort_order')
            ->get();

        $settings = Setting::all()->pluck('value', 'key');

        $latestPosts = Post::published()->orderByDesc('published_at')->limit(3)->get();
        $featuredProjects = Project::published()->featured()->orderBy('sort_order')->limit(4)->get();
        if ($featuredProjects->isEmpty()) {
            $featuredProjects = Project::published()->orderBy('sort_order')->limit(4)->get();
        }

        return view('home', compact('page', 'blocks', 'rootCategories', 'products', 'settings', 'latestPosts', 'featuredProjects'));
    }

    public function catalog()
    {
        $rootCategories = Category::roots()->active()
            ->with(['children' => fn($q) => $q->active()->orderBy('sort_order')
                ->with(['children' => fn($q2) => $q2->active()->orderBy('sort_order')])])
            ->orderBy('sort_order')
            ->get();

        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->paginate(24);

        $settings = Setting::all()->pluck('value', 'key');

        return view('catalog', compact('rootCategories', 'products', 'settings'));
    }

    public function category(Category $category)
    {
        $category->load('parent.parent', 'children');

        $descendantIds = $category->getDescendantIds();
        $descendantIds[] = $category->id;

        $rootCategories = Category::roots()->active()
            ->with(['children' => fn($q) => $q->active()->orderBy('sort_order')
                ->with(['children' => fn($q2) => $q2->active()->orderBy('sort_order')])])
            ->orderBy('sort_order')
            ->get();

        $products = Product::whereIn('category_id', $descendantIds)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(24);

        $settings = Setting::all()->pluck('value', 'key');

        return view('catalog', compact('category', 'rootCategories', 'products', 'settings'));
    }

    public function product(Product $product)
    {
        $product->load('category.parent');
        $settings = Setting::all()->pluck('value', 'key');
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('product', compact('product', 'settings', 'related'));
    }

    public function news()
    {
        $posts = Post::published()->news()->orderByDesc('published_at')->paginate(12);
        return view('posts.index', ['posts' => $posts, 'type' => 'news', 'title' => 'Новости']);
    }

    public function blog()
    {
        $posts = Post::published()->blog()->orderByDesc('published_at')->paginate(12);
        return view('posts.index', ['posts' => $posts, 'type' => 'blog', 'title' => 'Блог']);
    }

    public function post(Post $post)
    {
        $recent = Post::published()
            ->where('type', $post->type)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('posts.show', compact('post', 'recent'));
    }

    public function projects()
    {
        $projects = Project::published()->orderBy('sort_order')->paginate(12);
        return view('projects.index', compact('projects'));
    }

    public function project(Project $project)
    {
        $other = Project::published()
            ->where('id', '!=', $project->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('projects.show', compact('project', 'other'));
    }
}
