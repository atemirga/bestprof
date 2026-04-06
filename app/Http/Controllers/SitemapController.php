<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = Product::where('is_active', true)->orderByDesc('updated_at')->get();
        $categories = Category::where('is_active', true)->orderByDesc('updated_at')->get();
        $posts = Post::where('is_published', true)->orderByDesc('updated_at')->get();
        $projects = Project::where('is_published', true)->orderByDesc('updated_at')->get();

        $content = view('sitemap', compact('products', 'categories', 'posts', 'projects'))->render();

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
