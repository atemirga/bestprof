@extends('layouts.app')

@section('content')
<section class="section" style="padding-top:7rem;">
  <div class="container">
    <div style="margin-bottom:1.5rem;">
      <a href="{{ route('home') }}#catalog" style="color:var(--blue);font-size:0.85rem;font-weight:600;">
        &larr; Назад на главную
      </a>
    </div>

    <div class="section-header" style="margin-bottom:2rem;">
      <h1 class="section-title">{{ isset($category) ? $category->name : 'Каталог продукции' }}</h1>
      @if(isset($category) && $category->description)
        <p class="section-desc">{{ $category->description }}</p>
      @endif
    </div>

    @if(isset($rootCategories))
      <div class="cat-strip" style="margin-bottom:2rem;border-radius:8px;border:1px solid var(--border);">
        <div class="container cat-strip-inner" style="padding:0;">
          <a class="cat-tab {{ !isset($category) ? 'active' : '' }}" href="{{ route('catalog') }}" style="text-decoration:none;">Все системы</a>
          @foreach($rootCategories as $cat)
            <a class="cat-tab {{ isset($category) && $category->id === $cat->id ? 'active' : '' }}" href="{{ route('catalog.category', $cat) }}" style="text-decoration:none;">{{ $cat->name }}</a>
            @foreach($cat->children as $child)
              <a class="cat-tab cat-tab-sub {{ isset($category) && $category->id === $child->id ? 'active' : '' }}" href="{{ route('catalog.category', $child) }}" style="text-decoration:none;">{{ $child->name }}</a>
            @endforeach
          @endforeach
        </div>
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
        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--gray-400);">
          <p>Товары не найдены</p>
        </div>
      @endforelse
    </div>

    @if($products->hasPages())
      <div style="margin-top:2rem;display:flex;justify-content:center;">
        {{ $products->links() }}
      </div>
    @endif
  </div>
</section>
@endsection
