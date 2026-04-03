@extends('layouts.app')

@section('content')
{{-- Hero --}}
<section style="padding-top:5.5rem;background:linear-gradient(135deg,#00074B 0%,#050e3a 60%,#0b1854 100%);color:#fff;padding-bottom:2.5rem;">
  <div class="container" style="max-width:800px;">
    <a href="{{ $post->type === 'news' ? route('news') : route('blog') }}" style="display:inline-flex;align-items:center;gap:0.4rem;color:rgba(255,255,255,0.6) !important;font-size:0.82rem;font-weight:600;text-decoration:none;margin-bottom:1.5rem;">
      <svg viewBox="0 0 14 14" width="12" height="12"><path d="M11 7H3m3-3L3 7l3 3" stroke="#fff" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
      {{ $post->type === 'news' ? 'Все новости' : 'Все статьи' }}
    </a>

    <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1rem;">
      <span style="font-size:0.75rem;font-weight:700;padding:0.2rem 0.7rem;border-radius:20px;{{ $post->type === 'news' ? 'background:rgba(76,175,80,0.2);color:#81c784;' : 'background:rgba(66,165,245,0.2);color:#64b5f6;' }}">{{ $post->type === 'news' ? 'Новость' : 'Блог' }}</span>
      @if($post->published_at)
        <span style="font-size:0.82rem;opacity:0.5;">
          <svg viewBox="0 0 14 14" width="12" height="12" fill="none" style="vertical-align:-1px;margin-right:0.2rem;"><rect x="1.5" y="2" width="11" height="10" rx="1.5" stroke="currentColor" stroke-width="1.2"/><path d="M1.5 5h11M4.5 0.5v2M9.5 0.5v2" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
          {{ $post->published_at->format('d F Y') }}
        </span>
      @endif
    </div>

    <h1 style="font-size:2.4rem;font-weight:800;line-height:1.25;color:#fff !important;">{{ $post->title }}</h1>

    @if($post->excerpt)
      <p style="font-size:1.1rem;color:rgba(255,255,255,0.65);line-height:1.6;margin-top:1rem;">{{ $post->excerpt }}</p>
    @endif
  </div>
</section>

{{-- Image --}}
@if($post->image)
<section style="margin-top:-1rem;position:relative;z-index:1;">
  <div class="container" style="max-width:900px;">
    <div style="border-radius:18px;overflow:hidden;box-shadow:0 16px 48px rgba(0,0,0,0.15);">
      <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" style="width:100%;display:block;">
    </div>
  </div>
</section>
@endif

{{-- Content --}}
<section class="section" style="padding-top:{{ $post->image ? '2.5rem' : '0' }};">
  <div class="container" style="max-width:780px;">
    <article class="post-article">
      {!! nl2br(e($post->content)) !!}
    </article>

    {{-- Share --}}
    <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid #e0e4ec;display:flex;align-items:center;gap:1rem;">
      <span style="font-size:0.85rem;color:#8a8fa3;font-weight:600;">Поделиться:</span>
      <div style="display:flex;gap:0.5rem;">
        <a href="#" class="share-btn" title="WhatsApp" style="background:#25D366;">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        </a>
        <a href="#" class="share-btn" title="Telegram" style="background:#0088cc;">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="#fff"><path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0h-.056zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

{{-- Related posts --}}
@if($recent->count())
<section class="section section-gray" style="padding-top:2.5rem;">
  <div class="container">
    <h2 style="font-size:1.3rem;font-weight:700;margin-bottom:1.5rem;color:#1a1a2e;">
      {{ $post->type === 'news' ? 'Другие новости' : 'Другие статьи' }}
    </h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.25rem;">
      @foreach($recent as $r)
        <a href="{{ route('post.show', $r) }}" class="related-post reveal" style="color:#1a1a2e !important;">
          <div class="related-post-img">
            @if($r->image)
              <img src="{{ asset('storage/' . $r->image) }}" alt="{{ $r->title }}">
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg,#e8edff,#d0d9f5);display:flex;align-items:center;justify-content:center;">
                <svg viewBox="0 0 40 40" width="32" height="32" style="color:var(--blue);opacity:0.15;"><rect x="4" y="4" width="32" height="32" rx="4" stroke="currentColor" fill="none" stroke-width="2"/></svg>
              </div>
            @endif
          </div>
          <div class="related-post-body">
            <div style="display:flex;align-items:center;gap:0.4rem;margin-bottom:0.4rem;">
              <span style="font-size:0.68rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:20px;{{ $r->type === 'news' ? 'background:#e8f5e9;color:#2e7d32;' : 'background:#e3f2fd;color:#1565c0;' }}">{{ $r->type === 'news' ? 'Новость' : 'Блог' }}</span>
              <span style="font-size:0.75rem;color:var(--gray-400);">{{ $r->published_at?->format('d.m.Y') }}</span>
            </div>
            <h3 style="font-size:0.95rem;font-weight:700;color:#1a1a2e !important;line-height:1.35;">{{ $r->title }}</h3>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

@push('styles')
<style>
  .post-article {
    font-size:1.08rem;line-height:2;color:#1a1a2e;
  }

  .share-btn {
    width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;
    transition:transform 0.2s,opacity 0.2s;
  }
  .share-btn:hover { transform:scale(1.1);opacity:0.85; }

  .related-post {
    text-decoration:none;display:flex;gap:1rem;
    background:#fff;border-radius:12px;padding:0.75rem;
    border:1px solid var(--border);transition:box-shadow 0.2s;
  }
  .related-post:hover { box-shadow:0 4px 16px rgba(0,0,0,0.06); }
  .related-post-img { width:100px;min-width:100px;height:80px;border-radius:8px;overflow:hidden; }
  .related-post-img img { width:100%;height:100%;object-fit:cover; }
  .related-post-body { display:flex;flex-direction:column;justify-content:center; }
</style>
@endpush
@endsection
