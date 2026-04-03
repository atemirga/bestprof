@extends('layouts.app')

@section('content')
{{-- Hero --}}
<section style="padding-top:5.5rem;background:linear-gradient(135deg,#00074B 0%,#050e3a 50%,#0b1854 100%);color:#fff;padding-bottom:3rem;">
  <div class="container">
    <div style="max-width:680px;margin:0 auto;text-align:center;">
      <div style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(255,255,255,0.1);padding:0.35rem 1rem;border-radius:50px;font-size:0.78rem;font-weight:600;margin-bottom:1.25rem;backdrop-filter:blur(8px);">
        <svg viewBox="0 0 16 16" width="14" height="14" fill="none"><rect x="2" y="2" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.3"/><path d="M5 5h6M5 8h4M5 11h5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
        Обновления
      </div>
      <h1 style="font-size:2.5rem;font-weight:800;margin-bottom:0.75rem;line-height:1.2;">{{ $title }}</h1>
      <p style="font-size:1.05rem;opacity:0.7;line-height:1.6;">Следите за новостями компании и полезными статьями о профильных системах</p>
    </div>

    {{-- Type tabs --}}
    <div style="display:flex;justify-content:center;gap:0.75rem;margin-top:2rem;">
      <a href="{{ route('news') }}" class="post-type-btn {{ $type === 'news' ? 'active' : '' }}">
        <svg viewBox="0 0 16 16" width="14" height="14" fill="none"><path d="M2 3h12v10H2V3z" stroke="currentColor" stroke-width="1.3"/><path d="M5 6h6M5 8.5h4" stroke="currentColor" stroke-width="1.1" stroke-linecap="round"/></svg>
        Новости
      </a>
      <a href="{{ route('blog') }}" class="post-type-btn {{ $type === 'blog' ? 'active' : '' }}">
        <svg viewBox="0 0 16 16" width="14" height="14" fill="none"><path d="M3 2h10a1 1 0 011 1v10a1 1 0 01-1 1H3a1 1 0 01-1-1V3a1 1 0 011-1z" stroke="currentColor" stroke-width="1.3"/><path d="M5 5h6M5 7.5h6M5 10h3" stroke="currentColor" stroke-width="1.1" stroke-linecap="round"/></svg>
        Блог
      </a>
    </div>
  </div>
</section>

{{-- Featured post (first one) --}}
@if($posts->onFirstPage() && $posts->count())
  @php $featured = $posts->first(); @endphp
  <section style="padding:2.5rem 0 0;">
    <div class="container">
      <a href="{{ route('post.show', $featured) }}" class="post-featured reveal">
        <div class="post-featured-img">
          @if($featured->image)
            <img src="{{ asset('storage/' . $featured->image) }}" alt="{{ $featured->title }}">
          @else
            <div style="width:100%;height:100%;background:linear-gradient(135deg,#f0f4ff,#dbe4ff);display:flex;align-items:center;justify-content:center;">
              <svg viewBox="0 0 64 64" width="64" height="64" style="color:var(--blue);opacity:0.15;"><rect x="8" y="8" width="48" height="48" rx="6" stroke="currentColor" fill="none" stroke-width="2.5"/><path d="M8 42l14-14 12 12 8-8 14 16" stroke="currentColor" fill="none" stroke-width="2.5"/></svg>
            </div>
          @endif
        </div>
        <div class="post-featured-body">
          <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.75rem;">
            <span class="post-badge post-badge--{{ $featured->type }}">{{ $featured->type === 'news' ? 'Новость' : 'Блог' }}</span>
            @if($featured->published_at)<span style="font-size:0.82rem;color:var(--gray-400);">{{ $featured->published_at->format('d.m.Y') }}</span>@endif
          </div>
          <h2 style="font-size:1.6rem;font-weight:800;color:var(--dark);line-height:1.3;margin-bottom:0.75rem;">{{ $featured->title }}</h2>
          @if($featured->excerpt)
            <p style="font-size:0.95rem;color:var(--gray-400);line-height:1.6;margin-bottom:1rem;">{{ $featured->excerpt }}</p>
          @endif
          <span style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.88rem;font-weight:600;color:var(--blue);">
            Читать далее
            <svg viewBox="0 0 14 14" width="14" height="14"><path d="M3 7h8m-3-3l3 3-3 3" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
          </span>
        </div>
      </a>
    </div>
  </section>
@endif

{{-- Posts grid --}}
<section class="section" style="padding-top:2rem;">
  <div class="container">
    <div class="posts-grid">
      @forelse($posts as $i => $post)
        @if(!($posts->onFirstPage() && $i === 0))
        <a href="{{ route('post.show', $post) }}" class="post-card reveal">
          <div class="post-card-img">
            @if($post->image)
              <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg,#f0f4ff,#dbe4ff);display:flex;align-items:center;justify-content:center;">
                <svg viewBox="0 0 48 48" width="40" height="40" style="color:var(--blue);opacity:0.15;"><rect x="6" y="6" width="36" height="36" rx="4" stroke="currentColor" fill="none" stroke-width="2"/></svg>
              </div>
            @endif
          </div>
          <div class="post-card-body">
            <div style="display:flex;align-items:center;gap:0.4rem;margin-bottom:0.5rem;">
              <span class="post-badge post-badge--{{ $post->type }}">{{ $post->type === 'news' ? 'Новость' : 'Блог' }}</span>
              @if($post->published_at)<span style="font-size:0.75rem;color:var(--gray-400);">{{ $post->published_at->format('d.m.Y') }}</span>@endif
            </div>
            <h3 class="post-card-title">{{ $post->title }}</h3>
            @if($post->excerpt)
              <p class="post-card-excerpt">{{ Str::limit($post->excerpt, 100) }}</p>
            @endif
            <span class="post-card-read">Читать <svg viewBox="0 0 12 12" width="10" height="10"><path d="M2 6h8m-3-3l3 3-3 3" stroke="currentColor" stroke-width="1.3" fill="none" stroke-linecap="round"/></svg></span>
          </div>
        </a>
        @endif
      @empty
        <div style="grid-column:1/-1;text-align:center;padding:4rem 2rem;">
          <svg viewBox="0 0 48 48" width="48" height="48" style="color:var(--gray-300);margin-bottom:1rem;"><rect x="6" y="6" width="36" height="36" rx="4" stroke="currentColor" fill="none" stroke-width="2"/><path d="M14 18h20M14 24h14M14 30h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
          <p style="color:var(--gray-400);font-size:1.05rem;font-weight:500;">Пока нет публикаций</p>
        </div>
      @endforelse
    </div>

    @if($posts->hasPages())
      <div style="margin-top:2.5rem;display:flex;justify-content:center;">{{ $posts->links() }}</div>
    @endif
  </div>
</section>

@push('styles')
<style>
  .post-type-btn {
    display:inline-flex;align-items:center;gap:0.4rem;
    padding:0.6rem 1.5rem;border-radius:50px;font-weight:600;font-size:0.88rem;
    text-decoration:none;color:rgba(255,255,255,0.7);
    border:1.5px solid rgba(255,255,255,0.15);
    transition:all 0.2s;
  }
  .post-type-btn:hover { color:#fff;border-color:rgba(255,255,255,0.3); }
  .post-type-btn.active { background:#fff;color:var(--dark);border-color:#fff; }

  .post-badge {
    font-size:0.72rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:20px;
    text-transform:uppercase;letter-spacing:0.3px;
  }
  .post-badge--news { background:#e8f5e9;color:#2e7d32; }
  .post-badge--blog { background:#e3f2fd;color:#1565c0; }

  /* Featured */
  .post-featured {
    display:grid;grid-template-columns:1fr 1fr;gap:2rem;
    text-decoration:none;background:#fff;border-radius:18px;overflow:hidden;
    border:1px solid var(--border);transition:box-shadow 0.3s;
  }
  .post-featured:hover { box-shadow:0 12px 40px rgba(0,0,0,0.08); }
  .post-featured-img { height:320px;overflow:hidden; }
  .post-featured-img img { width:100%;height:100%;object-fit:cover;transition:transform 0.4s; }
  .post-featured:hover .post-featured-img img { transform:scale(1.04); }
  .post-featured-body { padding:2rem 2rem 2rem 0;display:flex;flex-direction:column;justify-content:center; }

  /* Grid */
  .posts-grid {
    display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1.5rem;
  }
  .post-card {
    text-decoration:none;background:#fff;border-radius:14px;overflow:hidden;
    border:1px solid var(--border);display:flex;flex-direction:column;
    transition:box-shadow 0.25s,transform 0.25s;
  }
  .post-card:hover { box-shadow:0 8px 30px rgba(0,0,0,0.08);transform:translateY(-3px); }
  .post-card-img { height:200px;overflow:hidden; }
  .post-card-img img { width:100%;height:100%;object-fit:cover;transition:transform 0.3s; }
  .post-card:hover .post-card-img img { transform:scale(1.05); }
  .post-card-body { padding:1.25rem;flex:1;display:flex;flex-direction:column; }
  .post-card-title { font-size:1.05rem;font-weight:700;color:var(--dark);line-height:1.35;margin-bottom:0.4rem; }
  .post-card-excerpt { font-size:0.83rem;color:var(--gray-400);line-height:1.5;flex:1;margin-bottom:0.5rem; }
  .post-card-read { font-size:0.82rem;font-weight:600;color:var(--blue);display:inline-flex;align-items:center;gap:0.3rem; }

  @media(max-width:768px) {
    .post-featured { grid-template-columns:1fr; }
    .post-featured-img { height:220px; }
    .post-featured-body { padding:1.25rem; }
    .posts-grid { grid-template-columns:1fr; }
  }
</style>
@endpush
@endsection
