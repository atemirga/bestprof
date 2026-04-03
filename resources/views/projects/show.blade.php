@extends('layouts.app')

@section('content')
{{-- Hero with main image --}}
<section style="padding-top:5.5rem;position:relative;overflow:hidden;">
  <div style="position:relative;height:420px;overflow:hidden;">
    @if($project->image)
      <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" style="width:100%;height:100%;object-fit:cover;">
    @else
      <div style="width:100%;height:100%;background:linear-gradient(135deg,#00074B,#0b1854);"></div>
    @endif
    <div style="position:absolute;inset:0;background:linear-gradient(0deg,rgba(0,7,75,0.8) 0%,rgba(0,7,75,0.2) 60%,transparent 100%);"></div>
    <div class="container" style="position:absolute;bottom:0;left:0;right:0;padding-bottom:2.5rem;color:#fff;">
      <a href="{{ route('projects') }}" style="display:inline-flex;align-items:center;gap:0.4rem;color:rgba(255,255,255,0.7);font-size:0.82rem;font-weight:600;text-decoration:none;margin-bottom:1rem;">
        <svg viewBox="0 0 14 14" width="12" height="12"><path d="M11 7H3m3-3L3 7l3 3" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
        Все проекты
      </a>
      <h1 style="font-size:2.5rem;font-weight:800;line-height:1.2;margin-bottom:1rem;">{{ $project->title }}</h1>
      <div style="display:flex;gap:1.5rem;flex-wrap:wrap;">
        @if($project->client)
          <div class="pj-info-chip">
            <svg viewBox="0 0 16 16" width="14" height="14" fill="none"><circle cx="8" cy="5" r="3" stroke="currentColor" stroke-width="1.3"/><path d="M2 14c0-3.3 2.7-5 6-5s6 1.7 6 5" stroke="currentColor" stroke-width="1.3"/></svg>
            <div><span style="font-size:0.7rem;opacity:0.6;display:block;">Заказчик</span>{{ $project->client }}</div>
          </div>
        @endif
        @if($project->location)
          <div class="pj-info-chip">
            <svg viewBox="0 0 16 16" width="14" height="14" fill="none"><path d="M8 1C5.8 1 4 2.8 4 5c0 3.5 4 9 4 9s4-5.5 4-9c0-2.2-1.8-4-4-4z" stroke="currentColor" stroke-width="1.3"/><circle cx="8" cy="5" r="1.2" stroke="currentColor" stroke-width="1"/></svg>
            <div><span style="font-size:0.7rem;opacity:0.6;display:block;">Локация</span>{{ $project->location }}</div>
          </div>
        @endif
        @if($project->year)
          <div class="pj-info-chip">
            <svg viewBox="0 0 16 16" width="14" height="14" fill="none"><rect x="2" y="3" width="12" height="11" rx="1.5" stroke="currentColor" stroke-width="1.3"/><path d="M2 6.5h12M5.5 1v3M10.5 1v3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
            <div><span style="font-size:0.7rem;opacity:0.6;display:block;">Год</span>{{ $project->year }}</div>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

{{-- Content --}}
<section class="section" style="padding-top:2.5rem;">
  <div class="container" style="max-width:900px;">
    @if($project->description)
      <p style="font-size:1.2rem;color:var(--gray-400);line-height:1.7;margin-bottom:2rem;font-weight:500;border-left:4px solid var(--blue);padding-left:1.25rem;">{{ $project->description }}</p>
    @endif

    @if($project->content)
      <div class="pj-content">
        {!! nl2br(e($project->content)) !!}
      </div>
    @endif
  </div>
</section>

{{-- Gallery collage --}}
@if($project->gallery && count($project->gallery))
<section style="padding:2rem 0 3rem;">
  <div class="container">
    <h2 style="font-size:1.4rem;font-weight:700;margin-bottom:1.25rem;color:var(--dark);">
      <svg viewBox="0 0 20 20" width="20" height="20" fill="none" style="vertical-align:-3px;margin-right:0.4rem;"><rect x="1" y="1" width="8" height="8" rx="1.5" stroke="currentColor" stroke-width="1.5"/><rect x="11" y="1" width="8" height="5" rx="1.5" stroke="currentColor" stroke-width="1.5"/><rect x="1" y="11" width="8" height="8" rx="1.5" stroke="currentColor" stroke-width="1.5"/><rect x="11" y="8" width="8" height="11" rx="1.5" stroke="currentColor" stroke-width="1.5"/></svg>
      Фотогалерея
    </h2>

    {{-- Collage layout --}}
    <div class="gallery-collage">
      @foreach($project->gallery as $idx => $img)
        <div class="gallery-item gallery-item--{{ ($idx % 6) + 1 }}" onclick="openLightbox({{ $idx }})">
          <img src="{{ asset('storage/' . $img) }}" alt="Фото {{ $idx + 1 }}">
          <div class="gallery-item-zoom">
            <svg viewBox="0 0 20 20" width="20" height="20" fill="none"><circle cx="8.5" cy="8.5" r="5.5" stroke="#fff" stroke-width="1.8"/><path d="M13 13l4.5 4.5" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/><path d="M6.5 8.5h4M8.5 6.5v4" stroke="#fff" stroke-width="1.5" stroke-linecap="round"/></svg>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Carousel / lightbox --}}
    <div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
      <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
      <button class="lightbox-nav lightbox-prev" onclick="event.stopPropagation();navLightbox(-1)">
        <svg viewBox="0 0 24 24" width="28" height="28"><path d="M15 4l-8 8 8 8" stroke="#fff" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
      <div class="lightbox-img-wrap">
        <img id="lightboxImg" src="" alt="">
        <div class="lightbox-counter" id="lightboxCounter"></div>
      </div>
      <button class="lightbox-nav lightbox-next" onclick="event.stopPropagation();navLightbox(1)">
        <svg viewBox="0 0 24 24" width="28" height="28"><path d="M9 4l8 8-8 8" stroke="#fff" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </div>
  </div>
</section>
@endif

{{-- Other projects --}}
@if($other->count())
<section class="section section-gray" style="padding-top:2.5rem;">
  <div class="container">
    <h2 style="font-size:1.3rem;font-weight:700;margin-bottom:1.5rem;color:var(--dark);">Другие проекты</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;">
      @foreach($other as $o)
        <a href="{{ route('project.show', $o) }}" class="pj-other-card reveal">
          <div class="pj-other-img">
            @if($o->image)
              <img src="{{ asset('storage/' . $o->image) }}" alt="{{ $o->title }}">
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg,#1a1a2e,#16213e);"></div>
            @endif
          </div>
          <div class="pj-other-body">
            <h3>{{ $o->title }}</h3>
            <div style="display:flex;gap:0.75rem;font-size:0.78rem;color:var(--gray-400);">
              @if($o->location)<span>{{ $o->location }}</span>@endif
              @if($o->year)<span>{{ $o->year }}</span>@endif
            </div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

@push('styles')
<style>
  .pj-info-chip {
    display: flex; align-items: center; gap: 0.5rem;
    background: rgba(255,255,255,0.1); backdrop-filter: blur(8px);
    padding: 0.5rem 1rem; border-radius: 10px;
    font-size: 0.85rem; font-weight: 600;
  }
  .pj-content {
    font-size: 1.05rem; line-height: 1.9; color: var(--dark);
  }

  /* Gallery collage */
  .gallery-collage {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-auto-rows: 180px;
    gap: 0.75rem;
  }
  .gallery-item {
    border-radius: 12px; overflow: hidden; cursor: pointer;
    position: relative;
  }
  .gallery-item img { width:100%;height:100%;object-fit:cover;transition:transform 0.4s; }
  .gallery-item:hover img { transform:scale(1.08); }
  .gallery-item-zoom {
    position:absolute;inset:0;background:rgba(0,7,75,0.4);display:flex;align-items:center;justify-content:center;
    opacity:0;transition:opacity 0.25s;
  }
  .gallery-item:hover .gallery-item-zoom { opacity:1; }
  .gallery-item--1 { grid-column:span 2;grid-row:span 2; }
  .gallery-item--2 { grid-column:span 1; }
  .gallery-item--3 { grid-column:span 1; }
  .gallery-item--4 { grid-column:span 1;grid-row:span 2; }
  .gallery-item--5 { grid-column:span 2; }
  .gallery-item--6 { grid-column:span 1; }

  /* Lightbox */
  .lightbox {
    display:none;position:fixed;inset:0;background:rgba(0,0,0,0.92);z-index:9999;
    align-items:center;justify-content:center;
  }
  .lightbox.active { display:flex; }
  .lightbox-close {
    position:absolute;top:1rem;right:1.5rem;background:none;border:none;
    color:#fff;font-size:2.5rem;cursor:pointer;z-index:10;line-height:1;
  }
  .lightbox-nav {
    background:rgba(255,255,255,0.1);border:none;color:#fff;
    width:50px;height:50px;border-radius:50%;display:flex;align-items:center;justify-content:center;
    cursor:pointer;transition:background 0.2s;flex-shrink:0;
  }
  .lightbox-nav:hover { background:rgba(255,255,255,0.2); }
  .lightbox-img-wrap { flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:1rem; }
  .lightbox-img-wrap img { max-width:90vw;max-height:80vh;border-radius:8px;object-fit:contain; }
  .lightbox-counter { color:rgba(255,255,255,0.5);font-size:0.85rem;margin-top:0.75rem;font-weight:600; }

  .pj-other-card {
    text-decoration:none;background:#fff;border-radius:14px;overflow:hidden;
    border:1px solid var(--border);transition:box-shadow 0.25s,transform 0.25s;
  }
  .pj-other-card:hover { box-shadow:0 8px 30px rgba(0,0,0,0.08);transform:translateY(-3px); }
  .pj-other-img { height:180px;overflow:hidden; }
  .pj-other-img img { width:100%;height:100%;object-fit:cover;transition:transform 0.3s; }
  .pj-other-card:hover .pj-other-img img { transform:scale(1.05); }
  .pj-other-body { padding:1rem; }
  .pj-other-body h3 { font-size:1rem;font-weight:700;color:var(--dark);margin-bottom:0.25rem; }

  @media(max-width:768px) {
    .gallery-collage { grid-template-columns:repeat(2,1fr);grid-auto-rows:150px; }
    .gallery-item--1,.gallery-item--4,.gallery-item--5 { grid-column:span 1;grid-row:span 1; }
  }
</style>
@endpush

@if($project->gallery && count($project->gallery))
@push('scripts')
<script>
var galleryImages = @json($project->gallery ? array_map(fn($p) => asset('storage/' . $p), $project->gallery) : []);
var currentIdx = 0;

function openLightbox(idx) {
  currentIdx = idx;
  document.getElementById('lightboxImg').src = galleryImages[idx];
  document.getElementById('lightboxCounter').textContent = (idx + 1) + ' / ' + galleryImages.length;
  document.getElementById('lightbox').classList.add('active');
  document.body.style.overflow = 'hidden';
}
function closeLightbox(e) {
  if (e && e.target !== e.currentTarget) return;
  document.getElementById('lightbox').classList.remove('active');
  document.body.style.overflow = '';
}
function navLightbox(dir) {
  currentIdx = (currentIdx + dir + galleryImages.length) % galleryImages.length;
  document.getElementById('lightboxImg').src = galleryImages[currentIdx];
  document.getElementById('lightboxCounter').textContent = (currentIdx + 1) + ' / ' + galleryImages.length;
}
document.addEventListener('keydown', function(e) {
  if (!document.getElementById('lightbox').classList.contains('active')) return;
  if (e.key === 'Escape') closeLightbox();
  if (e.key === 'ArrowRight') navLightbox(1);
  if (e.key === 'ArrowLeft') navLightbox(-1);
});
</script>
@endpush
@endif
@endsection
