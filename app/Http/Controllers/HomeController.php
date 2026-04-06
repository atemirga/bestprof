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

        $seo = [];

        return view('home', compact('page', 'blocks', 'rootCategories', 'products', 'settings', 'latestPosts', 'featuredProjects', 'seo'));
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

        $seo = [
            'title' => 'Каталог продукции',
            'description' => 'Каталог алюминиевых и ПВХ профильных систем BestProf — окна, двери, фасады',
        ];

        return view('catalog', compact('rootCategories', 'products', 'settings', 'seo'));
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

        $seo = [
            'title' => $category->meta_title ?: $category->name,
            'description' => $category->meta_description ?: $category->description,
            'keywords' => $category->meta_keywords,
            'image' => $category->image ? asset('storage/' . $category->image) : null,
        ];

        return view('catalog', compact('category', 'rootCategories', 'products', 'settings', 'seo'));
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

        $seo = [
            'title' => $product->meta_title ?: $product->name,
            'description' => $product->meta_description ?: mb_substr(strip_tags($product->description), 0, 160),
            'keywords' => $product->meta_keywords,
            'image' => $product->image ? asset('storage/' . $product->image) : null,
            'type' => 'product',
        ];

        return view('product', compact('product', 'settings', 'related', 'seo'));
    }

    public function news()
    {
        $posts = Post::published()->news()->orderByDesc('published_at')->paginate(12);
        $settings = Setting::all()->pluck('value', 'key');

        $seo = [
            'title' => 'Новости',
            'description' => 'Новости компании BestProf — последние события, обновления и новинки продукции',
        ];

        return view('posts.index', ['posts' => $posts, 'type' => 'news', 'title' => 'Новости', 'settings' => $settings, 'seo' => $seo]);
    }

    public function blog()
    {
        $posts = Post::published()->blog()->orderByDesc('published_at')->paginate(12);
        $settings = Setting::all()->pluck('value', 'key');

        $seo = [
            'title' => 'Блог',
            'description' => 'Блог BestProf — полезные статьи о профильных системах, окнах и фасадах',
        ];

        return view('posts.index', ['posts' => $posts, 'type' => 'blog', 'title' => 'Блог', 'settings' => $settings, 'seo' => $seo]);
    }

    public function post(Post $post)
    {
        $recent = Post::published()
            ->where('type', $post->type)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $settings = Setting::all()->pluck('value', 'key');

        $seo = [
            'title' => $post->meta_title ?: $post->title,
            'description' => $post->meta_description ?: mb_substr(strip_tags($post->excerpt ?: $post->content), 0, 160),
            'keywords' => $post->meta_keywords,
            'image' => $post->image ? asset('storage/' . $post->image) : null,
            'type' => 'article',
        ];

        return view('posts.show', compact('post', 'recent', 'settings', 'seo'));
    }

    public function projects()
    {
        $projects = Project::published()->orderBy('sort_order')->paginate(12);
        $settings = Setting::all()->pluck('value', 'key');

        $seo = [
            'title' => 'Наши работы',
            'description' => 'Реализованные проекты BestProf — алюминиевые и ПВХ конструкции для жилых и коммерческих объектов',
        ];

        return view('projects.index', compact('projects', 'settings', 'seo'));
    }

    public function project(Project $project)
    {
        $other = Project::published()
            ->where('id', '!=', $project->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        $settings = Setting::all()->pluck('value', 'key');

        $seo = [
            'title' => $project->meta_title ?: $project->title,
            'description' => $project->meta_description ?: mb_substr(strip_tags($project->description), 0, 160),
            'keywords' => $project->meta_keywords,
            'image' => $project->image ? asset('storage/' . $project->image) : null,
            'type' => 'article',
        ];

        return view('projects.show', compact('project', 'other', 'settings', 'seo'));
    }
}
