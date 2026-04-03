@extends('layouts.app')

@section('content')
{{-- ═══════ HERO ═══════ --}}
<section class="hero">
  @include('partials.hero-svg')

  <div class="container">
    <div class="hero-grid">
      <div class="hero-content">
        @if(isset($blocks['hero']))
          @php $hero = $blocks['hero']; @endphp
          <div class="hero-tag"><span class="hero-tag-dot"></span> {{ $hero->data['tag'] ?? '' }}</div>
          <h1 class="hero-title">{!! $hero->title !!}</h1>
          <p class="hero-desc">{{ $hero->content }}</p>
          <div class="hero-actions">
            <a href="#contact" class="btn btn-primary">{{ $hero->data['btn_primary'] ?? 'Получить консультацию' }}</a>
            <a href="#catalog" class="btn btn-outline">{{ $hero->data['btn_secondary'] ?? 'Каталог продукции' }}</a>
          </div>
          @if(isset($hero->data['metrics']))
            <div class="hero-metrics">
              @foreach($hero->data['metrics'] as $m)
                <div class="hero-metric">
                  <div class="hero-metric-val">{{ $m['value'] }}</div>
                  <div class="hero-metric-label">{{ $m['label'] }}</div>
                </div>
              @endforeach
            </div>
          @endif
        @endif
      </div>
    </div>
  </div>
</section>

{{-- ═══════ ABOUT ═══════ --}}
<section class="section" id="about">
  <div class="container">
    @if(isset($blocks['about']))
      @php $about = $blocks['about']; @endphp
      <div class="about-grid reveal">
        <div>
          <div class="section-label">{{ $about->data['label'] ?? 'О компании' }}</div>
          <h2 class="section-title">{!! $about->title !!}</h2>
          <p class="section-desc">{{ $about->content }}</p>
          @if(isset($about->data['description2']))
            <p class="section-desc" style="margin-top:0.75rem;">{{ $about->data['description2'] }}</p>
          @endif
          @if(isset($about->data['stats']))
            <div class="about-stats">
              @foreach($about->data['stats'] as $stat)
                <div class="about-stat">
                  <div class="about-stat-val">{{ $stat['value'] }}</div>
                  <div class="about-stat-label">{{ $stat['label'] }}</div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <div class="about-image">
          <div class="about-image-inner">
            <div class="about-img-block"><svg viewBox="0 0 32 32"><rect x="2" y="2" width="12" height="28" rx="1" stroke="currentColor" fill="none" stroke-width="1.5"/><rect x="18" y="2" width="12" height="28" rx="1" stroke="currentColor" fill="none" stroke-width="1.5"/></svg></div>
            <div class="about-img-block"><svg viewBox="0 0 32 32"><path d="M4 4h24v24H4z" stroke="currentColor" fill="none" stroke-width="1.5"/><path d="M4 16h24M16 4v24" stroke="currentColor" fill="none" stroke-width="1"/></svg></div>
            <div class="about-img-block"><svg viewBox="0 0 32 32"><path d="M2 28L16 4l14 24H2z" stroke="currentColor" fill="none" stroke-width="1.5"/></svg></div>
            <div class="about-img-block"><svg viewBox="0 0 32 32"><circle cx="16" cy="16" r="12" stroke="currentColor" fill="none" stroke-width="1.5"/><path d="M16 4v24M4 16h24" stroke="currentColor" fill="none" stroke-width="1" opacity="0.5"/></svg></div>
          </div>
        </div>
      </div>
    @endif
  </div>
</section>

{{-- ═══════ FEATURES ═══════ --}}
@if(isset($blocks['features']) && isset($blocks['features']->data['items']))
<div class="features-strip">
  <div class="container" style="padding:0;">
    <div class="features-row">
      @php
        $icons = [
          '<svg viewBox="0 0 20 20" fill="none"><path d="M10 2l2.5 5 5.5.8-4 3.9.9 5.3-4.9-2.6-4.9 2.6.9-5.3-4-3.9 5.5-.8L10 2z" fill="white"/></svg>',
          '<svg viewBox="0 0 20 20" fill="none"><path d="M4 4h12v12H4V4z" stroke="white" stroke-width="1.5"/><path d="M4 10h12M10 4v12" stroke="white" stroke-width="1"/></svg>',
          '<svg viewBox="0 0 20 20" fill="none"><path d="M3 10l5 5L17 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
          '<svg viewBox="0 0 20 20" fill="none"><path d="M10 2v8l4 4" stroke="white" stroke-width="1.5" stroke-linecap="round"/><circle cx="10" cy="10" r="8" stroke="white" stroke-width="1.5"/></svg>',
        ];
      @endphp
      @foreach($blocks['features']->data['items'] as $i => $f)
        <div class="feature-cell">
          <div class="feature-cell-icon">{!! $icons[$i % count($icons)] !!}</div>
          <h4>{{ $f['title'] }}</h4>
          <p>{{ $f['desc'] }}</p>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endif

{{-- ═══════ CATALOG ═══════ --}}
<section class="section section-gray" id="catalog">
  <div class="container">
    @if(isset($blocks['catalog']))
      <div class="section-header center reveal">
        <div class="section-label">{{ $blocks['catalog']->data['label'] ?? 'Каталог' }}</div>
        <h2 class="section-title">{{ $blocks['catalog']->title }}</h2>
        <p class="section-desc">{{ $blocks['catalog']->content }}</p>
      </div>
    @endif

    <div class="cat-strip" style="margin-bottom:2rem;border-radius:8px;border:1px solid var(--border);">
      <div class="container cat-strip-inner" style="padding:0;" id="catalogTabs">
        <span class="cat-tab active" data-filter="">Все системы</span>
        @foreach($rootCategories as $cat)
          <span class="cat-tab" data-filter="{{ $cat->id }}">{{ $cat->name }}</span>
          @foreach($cat->children as $child)
            <span class="cat-tab cat-tab-sub" data-filter="{{ $child->id }}">{{ $child->name }}</span>
          @endforeach
        @endforeach
      </div>
    </div>

    <div class="products-grid" id="productsGrid">
      @foreach($products as $product)
        @php
          $catIds = [];
          if ($product->category) {
            $catIds[] = $product->category_id;
            if ($product->category->parent_id) $catIds[] = $product->category->parent_id;
            if ($product->category->parent && $product->category->parent->parent_id) $catIds[] = $product->category->parent->parent_id;
          }
        @endphp
        <div class="product-card reveal" data-cat-ids="{{ implode(',', $catIds) }}">
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
      @endforeach
    </div>
  </div>
</section>

{{-- ═══════ SERVICES ═══════ --}}
@if(isset($blocks['services']))
  @php $svc = $blocks['services']; @endphp
<section class="section" id="services">
  <div class="container">
    <div class="section-header center reveal">
      <div class="section-label">{{ $svc->data['label'] ?? 'Услуги' }}</div>
      <h2 class="section-title">{{ $svc->title }}</h2>
      <p class="section-desc">{{ $svc->content }}</p>
    </div>
    @if(isset($svc->data['items']))
    @php
      $svcIcons = [
        '<svg viewBox="0 0 22 22" fill="none"><path d="M3 19V7l8-5 8 5v12H3zm6-8v8m4-8v8" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M11 2v3m0 12v3m-9-9h3m12 0h3m-2.5-6.5l-2 2m-9 9l-2 2m13 0l-2-2m-9-9l-2-2" stroke="white" stroke-width="1.5" stroke-linecap="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M4 17V5a2 2 0 012-2h10a2 2 0 012 2v12M2 17h18M7 9h8M7 13h5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M5 3h12a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zm4 6l2 2 4-4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M14 2l5 5-12 12H2v-5L14 2z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        '<svg viewBox="0 0 22 22" fill="none"><path d="M17 8l-5 5-3-3-4 4" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 8h3v3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
      ];
    @endphp
    <div class="services-grid">
      @foreach($svc->data['items'] as $i => $item)
        <div class="service-card reveal">
          <div class="service-icon">{!! $svcIcons[$i % count($svcIcons)] !!}</div>
          <h3>{{ $item['title'] }}</h3>
          <p>{{ $item['desc'] }}</p>
        </div>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endif

{{-- ═══════ PARTNERS ═══════ --}}
@if(isset($blocks['partners']))
  @php $part = $blocks['partners']; @endphp
<section class="section section-gray" id="partners">
  <div class="container">
    <div class="section-header center reveal">
      <div class="section-label">{{ $part->data['label'] ?? '' }}</div>
      <h2 class="section-title">{{ $part->title }}</h2>
      <p class="section-desc">{{ $part->content }}</p>
    </div>
    @if(isset($part->data['items']))
    <div class="partners-grid reveal">
      @foreach($part->data['items'] as $p)
        <span class="partner-item">{{ $p }}</span>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endif

{{-- ═══════ CONTACT ═══════ --}}
<section class="cta-section" id="contact">
  <div class="container">
    <div class="cta-grid">
      <div class="reveal">
        @if(isset($blocks['contact']))
          @php $ct = $blocks['contact']; @endphp
          <div class="section-label" style="color:rgba(255,255,255,0.4);">{{ $ct->data['label'] ?? '' }}</div>
          <h2>{{ $ct->title }}</h2>
          <p class="section-desc">{{ $ct->content }}</p>
        @endif
        <div class="cta-info-row">
          <div class="cta-info-item"><h5>Телефон</h5><a href="tel:{{ preg_replace('/[^\d+]/', '', $settings['phone'] ?? '') }}">{{ $settings['phone'] ?? '' }}</a></div>
          <div class="cta-info-item"><h5>Email</h5><a href="mailto:{{ $settings['email'] ?? '' }}">{{ $settings['email'] ?? '' }}</a></div>
          <div class="cta-info-item"><h5>Адрес</h5><p>{{ $settings['address'] ?? '' }}</p></div>
        </div>
      </div>
      <div class="cta-form-card reveal">
        <h3>{{ $blocks['contact']->data['form_title'] ?? 'Заявка' }}</h3>
        <div class="form-row">
          <div class="form-group"><label>Имя</label><input type="text" class="form-input" placeholder="Ваше имя"></div>
          <div class="form-group"><label>Телефон</label><input type="tel" class="form-input" placeholder="+7 (___) ___-__-__"></div>
        </div>
        <div class="form-group"><label>Email</label><input type="email" class="form-input" placeholder="email@company.kz"></div>
        <div class="form-group"><label>Описание проекта</label><textarea class="form-input" placeholder="Опишите ваш проект..."></textarea></div>
        <button class="form-submit">{{ $blocks['contact']->data['form_button'] ?? 'Отправить' }}</button>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
// Catalog tabs filter
document.querySelectorAll('.cat-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    const filter = tab.dataset.filter;
    document.querySelectorAll('.product-card').forEach(card => {
      if (!filter) { card.style.display = ''; return; }
      const ids = (card.dataset.catIds || '').split(',');
      card.style.display = ids.includes(filter) ? '' : 'none';
    });
  });
});
// Phone mask
document.querySelector('input[type="tel"]')?.addEventListener('input', e => {
  let v = e.target.value.replace(/\D/g, '');
  if (v.startsWith('7') || v.startsWith('8')) v = v.substring(1);
  if (v.length > 0) {
    let f = '+7';
    if (v.length > 0) f += ' (' + v.substring(0, 3);
    if (v.length >= 3) f += ') ' + v.substring(3, 6);
    if (v.length >= 6) f += '-' + v.substring(6, 8);
    if (v.length >= 8) f += '-' + v.substring(8, 10);
    e.target.value = f;
  }
});
</script>
@endpush
