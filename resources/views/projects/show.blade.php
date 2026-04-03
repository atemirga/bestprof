@extends('layouts.app')

@section('content')
<section class="section" style="padding-top:7rem;">
  <div class="container" style="max-width:900px;">
    <div style="margin-bottom:1.5rem;">
      <a href="{{ route('projects') }}" style="color:var(--blue);font-size:0.85rem;font-weight:600;">&larr; Все проекты</a>
    </div>

    <h1 style="font-size:2rem;font-weight:800;line-height:1.3;margin-bottom:1rem;color:var(--dark);">{{ $project->title }}</h1>

    <div style="display:flex;gap:1.5rem;margin-bottom:1.5rem;flex-wrap:wrap;">
      @if($project->client)
        <div><span style="font-size:0.78rem;color:var(--gray-400);display:block;">Заказчик</span><span style="font-weight:600;color:var(--dark);">{{ $project->client }}</span></div>
      @endif
      @if($project->location)
        <div><span style="font-size:0.78rem;color:var(--gray-400);display:block;">Локация</span><span style="font-weight:600;color:var(--dark);">{{ $project->location }}</span></div>
      @endif
      @if($project->year)
        <div><span style="font-size:0.78rem;color:var(--gray-400);display:block;">Год</span><span style="font-weight:600;color:var(--dark);">{{ $project->year }}</span></div>
      @endif
    </div>

    @if($project->image)
      <div style="border-radius:14px;overflow:hidden;margin-bottom:2rem;">
        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" style="width:100%;display:block;">
      </div>
    @endif

    @if($project->description)
      <p style="font-size:1.1rem;color:var(--gray-400);line-height:1.6;margin-bottom:1.5rem;font-weight:500;">{{ $project->description }}</p>
    @endif

    @if($project->content)
      <div style="font-size:1rem;line-height:1.8;color:var(--dark);margin-bottom:2rem;">
        {!! nl2br(e($project->content)) !!}
      </div>
    @endif

    @if($project->gallery && count($project->gallery))
      <div style="margin-top:2rem;">
        <h3 style="font-weight:700;margin-bottom:1rem;">Галерея</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:0.75rem;">
          @foreach($project->gallery as $img)
            <div style="border-radius:10px;overflow:hidden;aspect-ratio:4/3;">
              <img src="{{ asset('storage/' . $img) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
            </div>
          @endforeach
        </div>
      </div>
    @endif

    @if($other->count())
      <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid var(--border);">
        <h3 style="font-weight:700;margin-bottom:1.25rem;">Другие проекты</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1rem;">
          @foreach($other as $o)
            <a href="{{ route('project.show', $o) }}" style="text-decoration:none;border:1px solid var(--border);border-radius:10px;overflow:hidden;transition:border-color 0.2s;">
              @if($o->image)
                <div style="height:130px;overflow:hidden;"><img src="{{ asset('storage/' . $o->image) }}" style="width:100%;height:100%;object-fit:cover;"></div>
              @endif
              <div style="padding:0.75rem;">
                <h4 style="font-size:0.88rem;font-weight:600;color:var(--dark);">{{ $o->title }}</h4>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>
@endsection
