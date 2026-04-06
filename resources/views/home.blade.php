@extends('layouts.app')

@push('seo')
@include('partials.jsonld.organization')
@endpush

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

    {{-- 3 main category buttons --}}
    @php
      $aluCat = $rootCategories->firstWhere('slug', 'alu');
      $pvhCat = $rootCategories->firstWhere('slug', 'pvh');
      $furnituraCat = null;
      if ($pvhCat) {
        $furnituraCat = $pvhCat->children->first(fn($c) => mb_strtolower($c->name) === 'фурнитура');
      }
      $pvhChildrenNoFurn = $pvhCat ? $pvhCat->children->filter(fn($c) => mb_strtolower($c->name) !== 'фурнитура') : collect();

      $buttons = [];
      if ($aluCat) $buttons[] = ['cat' => $aluCat, 'icon' => '<svg viewBox="0 0 40 40" fill="none"><rect x="6" y="3" width="12" height="34" rx="2" stroke="currentColor" stroke-width="1.8"/><rect x="22" y="3" width="12" height="34" rx="2" stroke="currentColor" stroke-width="1.8"/><line x1="12" y1="3" x2="12" y2="37" stroke="currentColor" stroke-width="0.8" opacity="0.4"/><line x1="28" y1="3" x2="28" y2="37" stroke="currentColor" stroke-width="0.8" opacity="0.4"/></svg>', 'desc' => 'Gold, AlProf и другие системы'];
      if ($pvhCat) $buttons[] = ['cat' => $pvhCat, 'icon' => '<svg viewBox="0 0 40 40" fill="none"><path d="M5 35V9l15-6 15 6v26" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M13 35V18m14 17V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M5 9l15 5 15-5" stroke="currentColor" stroke-width="1" opacity="0.4"/></svg>', 'desc' => 'Sapa, Funke, Seiger WDF, Grunder'];
      if ($furnituraCat) $buttons[] = ['cat' => $furnituraCat, 'icon' => '<svg viewBox="0 0 40 40" fill="none"><circle cx="20" cy="14" r="6" stroke="currentColor" stroke-width="1.8"/><path d="M20 20v14M14 28h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M10 8l4 4M30 8l-4 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" opacity="0.5"/></svg>', 'desc' => 'Ручки, петли, замки и другое'];
    @endphp

    <div class="catalog-buttons reveal" id="catalogButtons">
      @foreach($buttons as $btn)
        <button class="catalog-btn" data-cat-id="{{ $btn['cat']->id }}" data-cat-slug="{{ $btn['cat']->slug }}">
          <div class="catalog-btn-icon">{!! $btn['icon'] !!}</div>
          <div class="catalog-btn-text">
            <span class="catalog-btn-name">{{ $btn['cat']->name }}</span>
            <span class="catalog-btn-desc">{{ $btn['desc'] }}</span>
          </div>
          <svg class="catalog-btn-arrow" viewBox="0 0 16 16" width="16" height="16"><path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      @endforeach
    </div>

    {{-- Subcategory row (appears on click) --}}
    <div class="catalog-subcats" id="catalogSubcats" style="display:none;">
      <div class="catalog-subcats-inner" id="catalogSubcatsInner"></div>
    </div>

    {{-- Hidden data for JS --}}
    <script type="application/json" id="catalogTreeData">
    @php
      $treeData = [];
      if ($aluCat) {
        $treeData[$aluCat->id] = $aluCat->children->map(fn($c) => [
          'id' => $c->id,
          'name' => $c->name,
          'slug' => $c->slug,
          'children' => $c->children->map(fn($s) => ['id' => $s->id, 'name' => $s->name, 'slug' => $s->slug])->values()
        ])->values();
      }
      if ($pvhCat) {
        $treeData[$pvhCat->id] = $pvhChildrenNoFurn->map(fn($c) => [
          'id' => $c->id,
          'name' => $c->name,
          'slug' => $c->slug,
          'children' => $c->children->map(fn($s) => ['id' => $s->id, 'name' => $s->name, 'slug' => $s->slug])->values()
        ])->values();
      }
      if ($furnituraCat) {
        $treeData[$furnituraCat->id] = [];
      }
    @endphp
    {!! json_encode($treeData) !!}
    </script>

    {{-- Products grid --}}
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

    <div style="text-align:center;margin-top:2rem;" class="reveal">
      <a href="{{ route('catalog') }}" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.85rem 2rem;background:var(--blue);color:#fff;border-radius:8px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:background 0.2s;">
        Перейти в каталог
        <svg viewBox="0 0 14 14" width="14" height="14"><path d="M3 7h8m-3-3l3 3-3 3" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
      </a>
    </div>
  </div>
</section>

{{-- ═══════ PROJECTS (Наши работы) ═══════ --}}
@if($featuredProjects->count())
<section class="section" id="projects">
  <div class="container">
    <div class="section-header center reveal">
      <div class="section-label">Портфолио</div>
      <h2 class="section-title">Наши работы</h2>
      <p class="section-desc">Реализованные проекты с использованием алюминиевых и ПВХ профильных систем</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;" class="reveal">
      @foreach($featuredProjects as $proj)
        <a href="{{ route('project.show', $proj) }}" style="text-decoration:none;background:#fff;border-radius:14px;overflow:hidden;border:1px solid var(--border);transition:box-shadow 0.25s,transform 0.25s;" onmouseover="this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)';this.style.transform='translateY(-3px)';" onmouseout="this.style.boxShadow='';this.style.transform='';">
          <div style="height:200px;overflow:hidden;position:relative;">
            @if($proj->image)
              <img src="{{ asset('storage/' . $proj->image) }}" alt="{{ $proj->title }}" style="width:100%;height:100%;object-fit:cover;">
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg,#1a1a2e,#16213e);display:flex;align-items:center;justify-content:center;">
                <svg viewBox="0 0 48 48" width="48" height="48" style="color:#fff;opacity:0.15;"><path d="M6 40V14l18-10 18 10v26H6z" stroke="currentColor" fill="none" stroke-width="2"/></svg>
              </div>
            @endif
          </div>
          <div style="padding:1.1rem;">
            <h3 style="font-size:1rem;font-weight:700;color:var(--dark);margin-bottom:0.25rem;">{{ $proj->title }}</h3>
            @if($proj->description)
              <p style="font-size:0.82rem;color:var(--gray-400);line-height:1.4;margin:0;">{{ Str::limit($proj->description, 80) }}</p>
            @endif
            <div style="display:flex;gap:0.75rem;margin-top:0.5rem;font-size:0.75rem;color:var(--gray-300);">
              @if($proj->location)<span>{{ $proj->location }}</span>@endif
              @if($proj->year)<span>{{ $proj->year }}</span>@endif
            </div>
          </div>
        </a>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:1.75rem;" class="reveal">
      <a href="{{ route('projects') }}" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;border:2px solid var(--blue);color:var(--blue);border-radius:8px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.background='var(--blue)';this.style.color='#fff';" onmouseout="this.style.background='';this.style.color='var(--blue)';">
        Все проекты
        <svg viewBox="0 0 14 14" width="14" height="14"><path d="M3 7h8m-3-3l3 3-3 3" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
      </a>
    </div>
  </div>
</section>
@endif

{{-- ═══════ NEWS & BLOG ═══════ --}}
@if($latestPosts->count())
<section class="section section-gray" id="news">
  <div class="container">
    <div class="section-header center reveal">
      <div class="section-label">Обновления</div>
      <h2 class="section-title">Новости и блог</h2>
      <p class="section-desc">Последние новости компании и полезные статьи</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:1.25rem;" class="reveal">
      @foreach($latestPosts as $p)
        <a href="{{ route('post.show', $p) }}" style="text-decoration:none;display:flex;flex-direction:column;background:#fff;border-radius:14px;overflow:hidden;border:1px solid var(--border);transition:box-shadow 0.25s,transform 0.25s;" onmouseover="this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)';this.style.transform='translateY(-3px)';" onmouseout="this.style.boxShadow='';this.style.transform='';">
          <div style="height:190px;overflow:hidden;">
            @if($p->image)
              <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->title }}" style="width:100%;height:100%;object-fit:cover;">
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg,#f0f4ff,#e0e7ff);display:flex;align-items:center;justify-content:center;">
                <svg viewBox="0 0 48 48" width="40" height="40" style="color:var(--blue);opacity:0.2;"><rect x="6" y="6" width="36" height="36" rx="4" stroke="currentColor" fill="none" stroke-width="2"/><path d="M6 32l10-10 8 8 6-6 12 12" stroke="currentColor" fill="none" stroke-width="2"/></svg>
              </div>
            @endif
          </div>
          <div style="padding:1.25rem;flex:1;">
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem;">
              <span style="font-size:0.72rem;font-weight:600;padding:0.15rem 0.5rem;border-radius:20px;{{ $p->type === 'news' ? 'background:#e8f5e9;color:#2e7d32;' : 'background:#e3f2fd;color:#1565c0;' }}">{{ $p->type === 'news' ? 'Новость' : 'Блог' }}</span>
              @if($p->published_at)<span style="font-size:0.78rem;color:var(--gray-400);">{{ $p->published_at->format('d.m.Y') }}</span>@endif
            </div>
            <h3 style="font-size:1.05rem;font-weight:700;color:var(--dark);line-height:1.35;margin-bottom:0.35rem;">{{ $p->title }}</h3>
            @if($p->excerpt)
              <p style="font-size:0.83rem;color:var(--gray-400);line-height:1.45;margin:0;">{{ Str::limit($p->excerpt, 110) }}</p>
            @endif
          </div>
        </a>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:1.75rem;" class="reveal">
      <a href="{{ route('news') }}" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;border:2px solid var(--blue);color:var(--blue);border-radius:8px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.2s;margin-right:0.5rem;" onmouseover="this.style.background='var(--blue)';this.style.color='#fff';" onmouseout="this.style.background='';this.style.color='var(--blue)';">Все новости</a>
      <a href="{{ route('blog') }}" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.75rem;border:2px solid var(--border);color:var(--dark);border-radius:8px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--blue)';this.style.color='var(--blue)';" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--dark)';">Блог</a>
    </div>
  </div>
</section>
@endif

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

@push('styles')
<style>
  .catalog-buttons {
    display: flex;
    justify-content: center;
    gap: 1.25rem;
    margin-bottom: 2rem;
  }
  .catalog-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.75rem;
    background: #fff;
    border: 2px solid var(--border);
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.25s;
    min-width: 240px;
    text-align: left;
  }
  .catalog-btn:hover {
    border-color: var(--blue);
    box-shadow: 0 6px 24px rgba(25, 62, 234, 0.1);
    transform: translateY(-2px);
  }
  .catalog-btn.active {
    border-color: var(--blue);
    background: linear-gradient(135deg, #f0f4ff 0%, #e8edff 100%);
    box-shadow: 0 4px 20px rgba(25, 62, 234, 0.12);
  }
  .catalog-btn-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: var(--dark);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
  }
  .catalog-btn-icon svg {
    width: 26px;
    height: 26px;
  }
  .catalog-btn.active .catalog-btn-icon {
    background: var(--blue);
  }
  .catalog-btn-text {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    flex: 1;
  }
  .catalog-btn-name {
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--dark);
  }
  .catalog-btn-desc {
    font-size: 0.78rem;
    color: var(--gray-400);
    line-height: 1.3;
  }
  .catalog-btn-arrow {
    color: var(--gray-300);
    transition: transform 0.25s, color 0.25s;
    flex-shrink: 0;
  }
  .catalog-btn.active .catalog-btn-arrow {
    transform: rotate(90deg);
    color: var(--blue);
  }

  .catalog-subcats {
    margin-bottom: 2rem;
    overflow: hidden;
    transition: max-height 0.35s ease;
  }
  .catalog-subcats-inner {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    padding: 1rem 0;
  }
  .subcat-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.6rem 1.25rem;
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 50px;
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--dark);
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
  }
  .subcat-chip:hover {
    border-color: var(--blue);
    color: var(--blue);
    background: #f5f7ff;
  }
  .subcat-chip.active {
    background: var(--blue);
    border-color: var(--blue);
    color: #fff;
  }
  .subcat-chip-count {
    font-size: 0.72rem;
    background: rgba(0,0,0,0.06);
    padding: 0.1rem 0.45rem;
    border-radius: 20px;
    font-weight: 500;
  }
  .subcat-chip.active .subcat-chip-count {
    background: rgba(255,255,255,0.2);
  }

  /* Sub-subcategory row */
  .catalog-sub-subcats {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    padding: 0.75rem 0 0 0;
  }
  .sub-subcat-chip {
    display: inline-block;
    padding: 0.4rem 1rem;
    background: transparent;
    border: 1px solid var(--border);
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--gray-400);
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
  }
  .sub-subcat-chip:hover {
    border-color: var(--blue);
    color: var(--blue);
  }
  .sub-subcat-chip.active {
    background: var(--dark);
    border-color: var(--dark);
    color: #fff;
  }

  @media (max-width: 768px) {
    .catalog-buttons {
      flex-direction: column;
      align-items: center;
    }
    .catalog-btn {
      min-width: 100%;
    }
  }
</style>
@endpush

@push('scripts')
<script>
(function() {
  var treeData = JSON.parse(document.getElementById('catalogTreeData').textContent);
  var buttons = document.querySelectorAll('.catalog-btn');
  var subcatsWrap = document.getElementById('catalogSubcats');
  var subcatsInner = document.getElementById('catalogSubcatsInner');
  var cards = document.querySelectorAll('.product-card');
  var activeMainId = null;
  var activeSubId = null;

  function filterProducts(filterIds) {
    cards.forEach(function(card) {
      if (!filterIds) { card.style.display = ''; return; }
      var ids = (card.dataset.catIds || '').split(',');
      var show = filterIds.some(function(fid) { return ids.includes(String(fid)); });
      card.style.display = show ? '' : 'none';
    });
  }

  function collectDescendantIds(catId) {
    var ids = [catId];
    var children = treeData[catId];
    if (children) {
      children.forEach(function(ch) {
        ids.push(ch.id);
        if (ch.children) ch.children.forEach(function(s) { ids.push(s.id); });
      });
    }
    return ids;
  }

  function renderSubcats(mainId) {
    var children = treeData[mainId];
    subcatsInner.innerHTML = '';
    if (!children || children.length === 0) {
      subcatsWrap.style.display = 'none';
      return;
    }

    // "Все" chip
    var allChip = document.createElement('span');
    allChip.className = 'subcat-chip active';
    allChip.textContent = 'Все';
    allChip.addEventListener('click', function() {
      activeSubId = null;
      document.querySelectorAll('.subcat-chip').forEach(function(c) { c.classList.remove('active'); });
      allChip.classList.add('active');
      filterProducts(collectDescendantIds(mainId));
      removeSubs();
    });
    subcatsInner.appendChild(allChip);

    children.forEach(function(ch) {
      var chip = document.createElement('span');
      chip.className = 'subcat-chip';
      chip.textContent = ch.name;
      chip.dataset.catId = ch.id;
      chip.addEventListener('click', function() {
        activeSubId = ch.id;
        document.querySelectorAll('.subcat-chip').forEach(function(c) { c.classList.remove('active'); });
        chip.classList.add('active');

        var subIds = [ch.id];
        if (ch.children) ch.children.forEach(function(s) { subIds.push(s.id); });
        filterProducts(subIds);

        // render sub-subcategories
        removeSubs();
        if (ch.children && ch.children.length > 0) {
          renderSubSubs(ch);
        }
      });
      subcatsInner.appendChild(chip);
    });

    subcatsWrap.style.display = '';
  }

  function removeSubs() {
    var existing = document.getElementById('catalogSubSubcats');
    if (existing) existing.remove();
  }

  function renderSubSubs(parentCh) {
    removeSubs();
    var row = document.createElement('div');
    row.className = 'catalog-sub-subcats';
    row.id = 'catalogSubSubcats';

    parentCh.children.forEach(function(sub) {
      var chip = document.createElement('span');
      chip.className = 'sub-subcat-chip';
      chip.textContent = sub.name;
      chip.addEventListener('click', function() {
        document.querySelectorAll('.sub-subcat-chip').forEach(function(c) { c.classList.remove('active'); });
        chip.classList.add('active');
        filterProducts([sub.id]);
      });
      row.appendChild(chip);
    });

    subcatsInner.parentNode.insertBefore(row, subcatsInner.nextSibling);
  }

  buttons.forEach(function(btn) {
    btn.addEventListener('click', function() {
      var catId = parseInt(btn.dataset.catId);

      if (activeMainId === catId) {
        // deselect
        btn.classList.remove('active');
        subcatsWrap.style.display = 'none';
        removeSubs();
        activeMainId = null;
        activeSubId = null;
        filterProducts(null);
        return;
      }

      buttons.forEach(function(b) { b.classList.remove('active'); });
      btn.classList.add('active');
      activeMainId = catId;
      activeSubId = null;

      filterProducts(collectDescendantIds(catId));
      renderSubcats(catId);
    });
  });
})();

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
