@extends('layouts.app')

@push('seo')
@include('partials.jsonld.product')
@include('partials.jsonld.breadcrumbs', ['breadcrumbs' => [
    ['name' => 'Главная', 'url' => route('home')],
    ['name' => 'Каталог', 'url' => route('catalog')],
    ['name' => $product->category->name ?? '', 'url' => $product->category ? route('catalog.category', $product->category->slug) : '#'],
    ['name' => $product->name, 'url' => route('product.show', $product->slug)],
]])
@endpush

@section('content')
<section class="section" style="padding-top:7rem;">
  <div class="container">
    <div style="margin-bottom:1.5rem;">
      <a href="{{ route('home') }}#catalog" style="color:var(--blue);font-size:0.85rem;font-weight:600;">
        &larr; Назад к каталогу
      </a>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start;">
      <div class="product-card-img" style="height:350px;border-radius:var(--radius);@if($product->card_bg) background:{{ $product->card_bg }}; @else background:linear-gradient(135deg,var(--gray-100),var(--gray-200)); @endif">
        @if($product->image)
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:contain;">
        @else
          <svg viewBox="0 0 48 48" style="width:80px;height:80px;opacity:0.15;"><rect x="8" y="4" width="32" height="40" rx="2" stroke="currentColor" fill="none" stroke-width="1.5"/></svg>
        @endif
        @if($product->badge)
          <div class="product-card-badge" @if($product->badge_color) style="background:{{ $product->badge_color }};" @endif>{{ $product->badge }}</div>
        @endif
      </div>
      <div>
        @if($product->type_label)
          <div style="font-size:0.75rem;font-weight:600;color:{{ $product->badge_color ?? 'var(--blue)' }};text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.3rem;">{{ $product->type_label }}</div>
        @endif
        <h1 style="font-size:1.8rem;margin-bottom:0.5rem;">{{ $product->name }}</h1>
        @if($product->sku)<p style="color:var(--gray-400);font-size:0.82rem;margin-bottom:1rem;">Артикул: {{ $product->sku }}</p>@endif
        <p style="font-size:0.95rem;line-height:1.7;margin-bottom:1rem;">{{ $product->description }}</p>
        @if($product->full_description)<div style="margin-bottom:1rem;">{!! nl2br(e($product->full_description)) !!}</div>@endif
        @if($product->price > 0)
          <div style="font-size:1.4rem;font-weight:800;color:var(--navy);margin-bottom:1rem;">{{ number_format($product->price, 0, ',', ' ') }} тг</div>
        @else
          <div style="font-size:1rem;font-weight:600;color:var(--gray-500);margin-bottom:1rem;">{{ $product->price_display }}</div>
        @endif
        @if($product->specs)
          <div style="display:flex;flex-wrap:wrap;gap:0.4rem;margin-bottom:1.5rem;">
            @foreach($product->specs as $spec)
              <span class="spec-chip">{{ $spec }}</span>
            @endforeach
          </div>
        @endif
        <a href="#contact" class="btn btn-primary" style="display:inline-block;padding:0.7rem 1.5rem;background:var(--blue);color:#fff;border-radius:8px;font-weight:600;">Запросить цену</a>
      </div>
    </div>

    @if($related->count())
      <div style="margin-top:3rem;">
        <h3 style="margin-bottom:1rem;">Похожие продукты</h3>
        <div class="products-grid">
          @foreach($related as $r)
            <div class="product-card">
              <div class="product-card-img" @if($r->card_bg) style="background:{{ $r->card_bg }};" @endif>
                <div class="product-card-badge" @if($r->badge_color) style="background:{{ $r->badge_color }};" @endif>{{ $r->badge }}</div>
                <svg viewBox="0 0 48 48"><rect x="8" y="4" width="32" height="40" rx="2" stroke="currentColor" fill="none" stroke-width="1.5"/></svg>
              </div>
              <div class="product-card-body">
                <div class="product-card-name">{{ $r->name }}</div>
                <div class="product-card-desc">{{ $r->description }}</div>
              </div>
              <div class="product-card-footer">
                <a href="{{ route('product.show', $r) }}" class="product-card-link">Подробнее</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>
@endsection
