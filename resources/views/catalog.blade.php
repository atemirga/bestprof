@extends('layouts.app')

@section('content')
<section class="section" style="padding-top:7rem;">
  <div class="container">
    <div style="margin-bottom:1.5rem;">
      <a href="{{ route('home') }}" style="color:var(--blue);font-size:0.85rem;font-weight:600;">
        &larr; Назад на главную
      </a>
    </div>

    <div class="section-header" style="margin-bottom:2rem;">
      <h1 class="section-title">{{ isset($category) ? $category->name : 'Каталог продукции' }}</h1>
      @if(isset($category) && $category->description)
        <p class="section-desc">{{ $category->description }}</p>
      @endif
    </div>

    <div style="display:flex;gap:2rem;align-items:flex-start;">
      {{-- Tree sidebar --}}
      <div class="catalog-tree">
        <div class="catalog-tree-title">Категории</div>
        <ul class="tree-root">
          @foreach($rootCategories as $root)
            @php
              $isRootActive = isset($category) && ($category->id === $root->id || optional($category->parent)->id === $root->id || optional(optional($category->parent)->parent)->id === $root->id);
              $isRootExact = isset($category) && $category->id === $root->id;
            @endphp
            <li class="tree-item {{ $isRootActive ? 'open' : '' }}">
              <div class="tree-node {{ $isRootExact ? 'active' : '' }}">
                @if($root->children->count())
                  <button class="tree-toggle" data-target="children-{{ $root->id }}">
                    <svg viewBox="0 0 12 12" width="12" height="12"><path d="M4 2l4 4-4 4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                  </button>
                @endif
                <a href="{{ route('catalog.category', $root) }}">{{ $root->name }}</a>
                <span class="tree-count">{{ $root->products_count ?? '' }}</span>
              </div>

              @if($root->children->count())
                <ul class="tree-children" id="children-{{ $root->id }}" @if($isRootActive) style="display:block;" @endif>
                  @foreach($root->children as $child)
                    @php
                      $isChildActive = isset($category) && ($category->id === $child->id || optional($category->parent)->id === $child->id);
                      $isChildExact = isset($category) && $category->id === $child->id;
                    @endphp
                    <li class="tree-item {{ $isChildActive ? 'open' : '' }}">
                      <div class="tree-node {{ $isChildExact ? 'active' : '' }}">
                        @if($child->children->count())
                          <button class="tree-toggle" data-target="children-{{ $child->id }}">
                            <svg viewBox="0 0 12 12" width="12" height="12"><path d="M4 2l4 4-4 4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                          </button>
                        @endif
                        <a href="{{ route('catalog.category', $child) }}">{{ $child->name }}</a>
                      </div>

                      @if($child->children->count())
                        <ul class="tree-children" id="children-{{ $child->id }}" @if($isChildActive) style="display:block;" @endif>
                          @foreach($child->children as $sub)
                            @php $isSubExact = isset($category) && $category->id === $sub->id; @endphp
                            <li class="tree-item">
                              <div class="tree-node {{ $isSubExact ? 'active' : '' }}">
                                <a href="{{ route('catalog.category', $sub) }}">{{ $sub->name }}</a>
                              </div>
                            </li>
                          @endforeach
                        </ul>
                      @endif
                    </li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ul>
      </div>

      {{-- Products grid --}}
      <div style="flex:1;min-width:0;">
        @if(isset($category))
          <div style="margin-bottom:1rem;">
            @php
              $breadcrumbs = collect();
              $bc = $category;
              while ($bc) { $breadcrumbs->prepend($bc); $bc = $bc->parent; }
            @endphp
            <div style="display:flex;align-items:center;gap:0.4rem;font-size:0.82rem;color:var(--gray-400);flex-wrap:wrap;">
              <a href="{{ route('catalog') }}" style="color:var(--blue);text-decoration:none;">Все категории</a>
              @foreach($breadcrumbs as $bc)
                <span style="color:var(--gray-300);">/</span>
                @if($loop->last)
                  <span style="color:var(--dark);">{{ $bc->name }}</span>
                @else
                  <a href="{{ route('catalog.category', $bc) }}" style="color:var(--blue);text-decoration:none;">{{ $bc->name }}</a>
                @endif
              @endforeach
            </div>
          </div>
        @endif

        @if(isset($category) && $category->children->count() && $products->isEmpty())
          <div class="subcategory-cards">
            @foreach($category->children as $sub)
              <a href="{{ route('catalog.category', $sub) }}" class="subcategory-card reveal">
                <div class="subcategory-card-name">{{ $sub->name }}</div>
                @if($sub->description)
                  <div class="subcategory-card-desc">{{ Str::limit($sub->description, 80) }}</div>
                @endif
                <span class="subcategory-card-link">Перейти &rarr;</span>
              </a>
            @endforeach
          </div>
        @endif

        <div class="products-grid">
          @forelse($products as $product)
            <div class="product-card reveal">
              <div class="product-card-img" @if($product->card_bg) style="background: {{ $product->card_bg }};" @endif>
                <div class="product-card-badge" @if($product->badge_color) style="background: {{ $product->badge_color }};" @endif>{{ $product->badge }}</div>
                @if($product->image)
                  <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                  <svg viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" stroke="currentColor" fill="none" stroke-width="1.5"/><line x1="24" y1="4" x2="24" y2="44" stroke="currentColor" stroke-width="1" opacity="0.5"/></svg>
                @endif
              </div>
              <div class="product-card-body">
                @if($product->type_label)
                  <div class="product-card-type" @if($product->badge_color && $product->badge_color !== '#00074B') style="color: {{ $product->badge_color }};" @endif>{{ $product->type_label }}</div>
                @endif
                <div class="product-card-name">{{ $product->name }}</div>
                <div class="product-card-desc">{{ $product->description }}</div>
                @if($product->price > 0)
                  <div class="product-card-price">{{ number_format($product->price, 0, ',', ' ') }} тг</div>
                @endif
                @if($product->specs)
                  <div class="product-card-specs">
                    @foreach($product->specs as $spec)
                      <span class="spec-chip">{{ $spec }}</span>
                    @endforeach
                  </div>
                @endif
              </div>
              <div class="product-card-footer">
                <a href="{{ route('product.show', $product) }}" class="product-card-link">Подробнее <svg viewBox="0 0 14 14"><path d="M3 7h8m-3-3l3 3-3 3" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg></a>
                @if($product->hardware)<span class="product-card-hardware">{{ $product->hardware }}</span>@endif
              </div>
            </div>
          @empty
            @if(!isset($category) || !$category->children->count())
              <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--gray-400);">
                <p>Товары не найдены</p>
              </div>
            @endif
          @endforelse
        </div>

        @if($products->hasPages())
          <div style="margin-top:2rem;display:flex;justify-content:center;">
            {{ $products->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
  .catalog-tree {
    width: 260px;
    min-width: 260px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.25rem;
    position: sticky;
    top: 100px;
  }
  .catalog-tree-title {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--dark);
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--border);
  }
  .tree-root, .tree-children {
    list-style: none;
    margin: 0;
    padding: 0;
  }
  .tree-children {
    display: none;
    padding-left: 1rem;
    margin-top: 0.15rem;
  }
  .tree-item.open > .tree-children {
    display: block;
  }
  .tree-node {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.45rem 0.6rem;
    border-radius: 6px;
    transition: background 0.15s;
  }
  .tree-node:hover {
    background: var(--blue-bg, #f0f4ff);
  }
  .tree-node.active {
    background: var(--blue);
  }
  .tree-node.active a {
    color: #fff;
    font-weight: 600;
  }
  .tree-node a {
    color: var(--dark);
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 500;
    flex: 1;
  }
  .tree-toggle {
    background: none;
    border: none;
    padding: 2px;
    cursor: pointer;
    color: var(--gray-400);
    display: flex;
    align-items: center;
    transition: transform 0.2s;
  }
  .tree-item.open > .tree-node > .tree-toggle {
    transform: rotate(90deg);
  }
  .tree-count {
    font-size: 0.75rem;
    color: var(--gray-400);
  }

  .subcategory-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
  }
  .subcategory-card {
    display: flex;
    flex-direction: column;
    padding: 1.25rem;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 10px;
    text-decoration: none;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .subcategory-card:hover {
    border-color: var(--blue);
    box-shadow: 0 4px 16px rgba(25, 62, 234, 0.08);
  }
  .subcategory-card-name {
    font-weight: 700;
    font-size: 1rem;
    color: var(--dark);
    margin-bottom: 0.4rem;
  }
  .subcategory-card-desc {
    font-size: 0.82rem;
    color: var(--gray-400);
    margin-bottom: 0.75rem;
    flex: 1;
  }
  .subcategory-card-link {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--blue);
  }

  @media (max-width: 768px) {
    .catalog-tree {
      display: none;
    }
  }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.tree-toggle').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      var item = btn.closest('.tree-item');
      item.classList.toggle('open');
    });
  });
});
</script>
@endpush
@endsection
