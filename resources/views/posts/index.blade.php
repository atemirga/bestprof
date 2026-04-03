@extends('layouts.app')

@section('content')
<section class="section" style="padding-top:7rem;">
  <div class="container">
    <div style="margin-bottom:1.5rem;">
      <a href="{{ route('home') }}" style="color:var(--blue);font-size:0.85rem;font-weight:600;">&larr; Назад на главную</a>
    </div>

    <div class="section-header" style="margin-bottom:1rem;">
      <h1 class="section-title">{{ $title }}</h1>
    </div>

    <div style="display:flex;gap:0.75rem;margin-bottom:2rem;">
      <a href="{{ route('news') }}" style="padding:0.5rem 1.25rem;border-radius:50px;font-weight:600;font-size:0.88rem;text-decoration:none;border:1.5px solid var(--border);{{ $type === 'news' ? 'background:var(--blue);color:#fff;border-color:var(--blue);' : 'background:#fff;color:var(--dark);' }}">Новости</a>
      <a href="{{ route('blog') }}" style="padding:0.5rem 1.25rem;border-radius:50px;font-weight:600;font-size:0.88rem;text-decoration:none;border:1.5px solid var(--border);{{ $type === 'blog' ? 'background:var(--blue);color:#fff;border-color:var(--blue);' : 'background:#fff;color:var(--dark);' }}">Блог</a>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:1.5rem;">
      @forelse($posts as $post)
        <a href="{{ route('post.show', $post) }}" class="post-card reveal" style="text-decoration:none;">
          <div class="post-card-img">
            @if($post->image)
              <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg,#f0f4ff,#e0e7ff);display:flex;align-items:center;justify-content:center;">
                <svg viewBox="0 0 48 48" width="48" height="48" style="color:var(--blue);opacity:0.3;"><rect x="6" y="6" width="36" height="36" rx="4" stroke="currentColor" fill="none" stroke-width="2"/><path d="M6 32l10-10 8 8 6-6 12 12" stroke="currentColor" fill="none" stroke-width="2"/></svg>
              </div>
            @endif
          </div>
          <div class="post-card-body">
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem;">
              <span style="font-size:0.75rem;font-weight:600;padding:0.2rem 0.6rem;border-radius:20px;{{ $post->type === 'news' ? 'background:#e8f5e9;color:#2e7d32;' : 'background:#e3f2fd;color:#1565c0;' }}">{{ $post->type === 'news' ? 'Новость' : 'Блог' }}</span>
              @if($post->published_at)
                <span style="font-size:0.78rem;color:var(--gray-400);">{{ $post->published_at->format('d.m.Y') }}</span>
              @endif
            </div>
            <h3 style="font-size:1.1rem;font-weight:700;color:var(--dark);margin-bottom:0.4rem;line-height:1.35;">{{ $post->title }}</h3>
            @if($post->excerpt)
              <p style="font-size:0.85rem;color:var(--gray-400);line-height:1.5;">{{ Str::limit($post->excerpt, 120) }}</p>
            @endif
          </div>
        </a>
      @empty
        <div style="grid-column:1/-1;text-align:center;padding:4rem 2rem;">
          <p style="color:var(--gray-400);font-size:1rem;">Пока нет публикаций</p>
        </div>
      @endforelse
    </div>

    @if($posts->hasPages())
      <div style="margin-top:2rem;display:flex;justify-content:center;">{{ $posts->links() }}</div>
    @endif
  </div>
</section>

@push('styles')
<style>
  .post-card { display:flex;flex-direction:column;background:#fff;border-radius:14px;overflow:hidden;border:1px solid var(--border);transition:box-shadow 0.25s,transform 0.25s; }
  .post-card:hover { box-shadow:0 8px 30px rgba(0,0,0,0.08);transform:translateY(-3px); }
  .post-card-img { height:200px;overflow:hidden; }
  .post-card-img img { width:100%;height:100%;object-fit:cover;transition:transform 0.3s; }
  .post-card:hover .post-card-img img { transform:scale(1.05); }
  .post-card-body { padding:1.25rem; }
</style>
@endpush
@endsection
