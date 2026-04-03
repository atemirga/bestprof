<div class="d-flex align-items-center py-2 px-3 border-bottom" style="padding-left: {{ ($depth ?? 0) * 2 }}rem !important;">
    @if($depth > 0)
        <i class="bi bi-arrow-return-right text-muted me-2"></i>
    @endif

    <div class="flex-grow-1">
        <span class="fw-semibold">{{ $category->name }}</span>
        <span class="text-muted small ms-2">/{{ $category->slug }}</span>

        @unless($category->is_active)
            <span class="badge bg-secondary ms-1">неактивна</span>
        @endunless
    </div>

    <span class="badge bg-light text-dark me-3" title="Продуктов">
        <i class="bi bi-box-seam me-1"></i>{{ $category->products_count ?? $category->products->count() }}
    </span>

    <div class="btn-group btn-group-sm">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary" title="Редактировать">
            <i class="bi bi-pencil"></i>
        </a>
        <form action="{{ route('admin.categories.destroy', $category) }}"
              method="POST"
              onsubmit="return confirm('Удалить категорию «{{ $category->name }}»?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" title="Удалить" style="border-top-left-radius:0;border-bottom-left-radius:0;">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</div>

@if($category->children->count())
    @foreach($category->children->sortBy('sort_order') as $child)
        @include('admin.partials.category-tree-item', ['category' => $child, 'depth' => ($depth ?? 0) + 1])
    @endforeach
@endif
