<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlockController extends Controller
{
    public function edit(Block $block): View
    {
        $block->load('page');

        return view('admin.blocks.form', compact('block'));
    }

    public function update(Request $request, Block $block): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'data' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data = collect($validated)->except(['image', 'data'])->toArray();
        $data['is_active'] = $request->boolean('is_active');

        // Parse JSON data field
        if ($request->filled('data')) {
            $decoded = json_decode($request->input('data'), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['data'] = $decoded;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($block->image) {
                Storage::disk('public')->delete($block->image);
            }
            $path = $request->file('image')->store('blocks', 'public');
            $data['image'] = $path;
        }

        $block->update($data);

        return redirect()->route('admin.pages.edit', $block->page_id)
            ->with('success', 'Block updated successfully.');
    }
}
