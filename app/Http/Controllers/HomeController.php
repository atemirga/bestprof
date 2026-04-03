<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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

        return view('home', compact('page', 'blocks', 'rootCategories', 'products', 'settings'));
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
}
