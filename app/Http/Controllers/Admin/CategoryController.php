<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::roots()
            ->with('children.children')
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $allCategories = $this->getCategoryTree();

        return view('admin.categories.form', [
            'allCategories' => $allCategories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'badge_color' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        $allCategories = $this->getCategoryTree($category->id);

        return view('admin.categories.form', [
            'category' => $category,
            'allCategories' => $allCategories,
        ]);
    }

    private function getCategoryTree(?int $excludeId = null)
    {
        $query = Category::orderBy('sort_order');
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        $categories = $query->get();

        // Add depth for display
        $roots = $categories->whereNull('parent_id');
        $result = collect();
        foreach ($roots as $root) {
            $root->depth = 0;
            $result->push($root);
            $this->addChildren($result, $categories, $root->id, 1);
        }
        return $result;
    }

    private function addChildren(&$result, $categories, $parentId, $depth)
    {
        foreach ($categories->where('parent_id', $parentId) as $child) {
            $child->depth = $depth;
            $result->push($child);
            $this->addChildren($result, $categories, $child->id, $depth + 1);
        }
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $category->id],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'badge_color' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
