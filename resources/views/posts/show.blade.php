@extends('layouts.app')

@section('content')
<section class="section" style="padding-top:7rem;">
  <div class="container" style="max-width:800px;">
    <div style="margin-bottom:1.5rem;">
      <a href="{{ $post->type === 'news' ? route('news') : route('blog') }}" style="color:var(--blue);font-size:0.85rem;font-weight:600;">&larr; {{ $post->type === 'news' ? 'Все новости' : 'Все статьи' }}</a>
    </div>

    <article>
      <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem;">
        <span style="font-size:0.78rem;font-weight:600;padding:0.2rem 0.6rem;border-radius:20px;{{ $post->type === 'news' ? 'background:#e8f5e9;color:#2e7d32;' : 'background:#e3f2fd;color:#1565c0;' }}">{{ $post->type === 'news' ? 'Новость' : 'Блог' }}</span>
        @if($post->published_at)
          <span style="font-size:0.82rem;color:var(--gray-400);">{{ $post->published_at->format('d.m.Y') }}</span>
        @endif
      </div>

      <h1 style="font-size:2rem;font-weight:800;line-height:1.3;margin-bottom:1.5rem;color:var(--dark);">{{ $post->title }}</h1>

      @if($post->image)
        <div style="border-radius:14px;overflow:hidden;margin-bottom:2rem;">
          <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="width:100%;display:block;">
        </div>
      @endif

      @if($post->excerpt)
        <p style="font-size:1.1rem;color:var(--gray-400);line-height:1.6;margin-bottom:1.5rem;font-weight:500;">{{ $post->excerpt }}</p>
      @endif

      <div style="font-size:1rem;line-height:1.8;color:var(--dark);">
        {!! nl2br(e($post->content)) !!}
      </div>
    </article>

    @if($recent->count())
      <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid var(--border);">
        <h3 style="font-weight:700;margin-bottom:1.25rem;">{{ $post->type === 'news' ? 'Другие новости' : 'Другие статьи' }}</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem;">
          @foreach($recent as $r)
            <a href="{{ route('post.show', $r) }}" style="text-decoration:none;padding:1rem;background:#fff;border:1px solid var(--border);border-radius:10px;transition:border-color 0.2s;">
              <span style="font-size:0.78rem;color:var(--gray-400);">{{ $r->published_at?->format('d.m.Y') }}</span>
              <h4 style="font-size:0.92rem;font-weight:600;color:var(--dark);margin-top:0.3rem;line-height:1.35;">{{ $r->title }}</h4>
            </a>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>
@endsection
