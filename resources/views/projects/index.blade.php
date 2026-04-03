@extends('layouts.app')

@section('content')
{{-- Hero banner --}}
<section style="padding-top:5.5rem;background:linear-gradient(135deg,#00074B 0%,#0a1a5c 50%,#193EEA 100%);color:#fff;padding-bottom:3.5rem;">
  <div class="container">
    <div style="max-width:680px;margin:0 auto;text-align:center;">
      <div style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.1);padding:0.35rem 1rem;border-radius:50px;font-size:0.78rem;font-weight:600;margin-bottom:1.25rem;backdrop-filter:blur(8px);">
        <svg viewBox="0 0 16 16" width="14" height="14" fill="none"><path d="M3 13V5l5-3 5 3v8" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><rect x="5.5" y="8" width="5" height="5" stroke="currentColor" stroke-width="1.2"/></svg>
        Портфолио
      </div>
      <h1 style="font-size:2.5rem;font-weight:800;margin-bottom:0.75rem;line-height:1.2;">Наши работы</h1>
      <p style="font-size:1.05rem;opacity:0.7;line-height:1.6;">Реализованные проекты с использованием алюминиевых и ПВХ профильных систем по всему Казахстану</p>
    </div>

    {{-- Stats --}}
    <div style="display:flex;justify-content:center;gap:3rem;margin-top:2.5rem;">
      <div style="text-align:center;">
        <div style="font-size:2rem;font-weight:800;">{{ $projects->total() }}+</div>
        <div style="font-size:0.8rem;opacity:0.5;">Проектов</div>
      </div>
      <div style="text-align:center;">
        <div style="font-size:2rem;font-weight:800;">50 000+</div>
        <div style="font-size:0.8rem;opacity:0.5;">м² остекления</div>
      </div>
      <div style="text-align:center;">
        <div style="font-size:2rem;font-weight:800;">10+</div>
        <div style="font-size:0.8rem;opacity:0.5;">Городов</div>
      </div>
    </div>
  </div>
</section>

{{-- Projects grid - masonry collage style --}}
<section class="section" style="padding-top:3rem;">
  <div class="container">
    <div class="pj-grid">
      @foreach($projects as $i => $project)
        @php $isFeatured = $i === 0 || $i === 3; @endphp
        <a href="{{ route('project.show', $project) }}" class="pj-card {{ $isFeatured ? 'pj-card--wide' : '' }} reveal">
          <div class="pj-card-img">
            @if($project->image)
              <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
            @else
              <div class="pj-card-placeholder">
                <svg viewBox="0 0 64 64" width="64" height="64"><path d="M8 52V20l24-14 24 14v32H8z" stroke="currentColor" fill="none" stroke-width="2" opacity="0.15"/><rect x="24" y="34" width="16" height="18" stroke="currentColor" fill="none" stroke-width="2" opacity="0.15"/></svg>
              </div>
            @endif
            <div class="pj-card-overlay">
              <div class="pj-card-meta">
                @if($project->year)<span class="pj-tag">{{ $project->year }}</span>@endif
                @if($project->location)<span class="pj-tag"><svg viewBox="0 0 12 12" width="10" height="10" fill="none"><path d="M6 1C4.067 1 2.5 2.567 2.5 4.5 2.5 7.5 6 11 6 11s3.5-3.5 3.5-6.5C9.5 2.567 7.933 1 6 1z" stroke="currentColor" stroke-width="1.2"/><circle cx="6" cy="4.5" r="1" stroke="currentColor" stroke-width="1"/></svg> {{ $project->location }}</span>@endif
              </div>
              <h3 class="pj-card-title">{{ $project->title }}</h3>
              @if($project->description)
                <p class="pj-card-desc">{{ Str::limit($project->description, $isFeatured ? 140 : 80) }}</p>
              @endif
              @if($project->client)
                <div class="pj-card-client">{{ $project->client }}</div>
              @endif
              <span class="pj-card-link">Подробнее <svg viewBox="0 0 14 14" width="12" height="12"><path d="M3 7h8m-3-3l3 3-3 3" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg></span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    @if($projects->hasPages())
      <div style="margin-top:2.5rem;display:flex;justify-content:center;">{{ $projects->links() }}</div>
    @endif
  </div>
</section>

{{-- CTA --}}
<section style="background:var(--dark);color:#fff;padding:3rem 0;">
  <div class="container" style="text-align:center;">
    <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:0.5rem;">Хотите обсудить ваш проект?</h2>
    <p style="opacity:0.6;margin-bottom:1.5rem;">Наши инженеры помогут подобрать оптимальные профильные системы</p>
    <a href="{{ route('home') }}#contact" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.85rem 2rem;background:var(--blue);color:#fff;border-radius:8px;font-weight:600;text-decoration:none;">Оставить заявку <svg viewBox="0 0 14 14" width="14" height="14"><path d="M3 7h8m-3-3l3 3-3 3" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg></a>
  </div>
</section>

@push('styles')
<style>
  .pj-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    grid-auto-flow: dense;
  }
  .pj-card--wide { grid-column: span 2; }
  .pj-card {
    text-decoration: none;
    border-radius: 16px;
    overflow: hidden;
    display: block;
  }
  .pj-card-img {
    position: relative;
    height: 340px;
    overflow: hidden;
  }
  .pj-card--wide .pj-card-img { height: 400px; }
  .pj-card-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.5s;
  }
  .pj-card:hover .pj-card-img img { transform: scale(1.06); }
  .pj-card-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    display: flex; align-items: center; justify-content: center; color: #fff;
  }
  .pj-card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(0deg, rgba(0,7,75,0.85) 0%, rgba(0,7,75,0.3) 50%, transparent 100%);
    padding: 1.5rem;
    display: flex; flex-direction: column; justify-content: flex-end;
    color: #fff;
    transition: background 0.3s;
  }
  .pj-card:hover .pj-card-overlay {
    background: linear-gradient(0deg, rgba(0,7,75,0.92) 0%, rgba(0,7,75,0.4) 60%, rgba(0,7,75,0.1) 100%);
  }
  .pj-card-meta { display: flex; gap: 0.4rem; margin-bottom: 0.6rem; }
  .pj-tag {
    display: inline-flex; align-items: center; gap: 0.25rem;
    background: rgba(255,255,255,0.15); backdrop-filter: blur(6px);
    padding: 0.2rem 0.6rem; border-radius: 20px;
    font-size: 0.72rem; font-weight: 600;
  }
  .pj-card-title {
    font-size: 1.25rem; font-weight: 700; line-height: 1.3;
    margin-bottom: 0.35rem;
  }
  .pj-card--wide .pj-card-title { font-size: 1.5rem; }
  .pj-card-desc {
    font-size: 0.82rem; opacity: 0.7; line-height: 1.45; margin-bottom: 0.4rem;
  }
  .pj-card-client { font-size: 0.75rem; opacity: 0.5; margin-bottom: 0.5rem; }
  .pj-card-link {
    display: inline-flex; align-items: center; gap: 0.3rem;
    font-size: 0.82rem; font-weight: 600;
    opacity: 0; transform: translateY(8px);
    transition: opacity 0.3s, transform 0.3s;
  }
  .pj-card:hover .pj-card-link { opacity: 1; transform: translateY(0); }
  @media (max-width: 900px) {
    .pj-grid { grid-template-columns: repeat(2, 1fr); }
    .pj-card--wide { grid-column: span 2; }
  }
  @media (max-width: 600px) {
    .pj-grid { grid-template-columns: 1fr; }
    .pj-card--wide { grid-column: span 1; }
    .pj-card-img, .pj-card--wide .pj-card-img { height: 260px; }
  }
</style>
@endpush
@endsection
