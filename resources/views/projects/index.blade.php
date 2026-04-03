@extends('layouts.app')

@section('content')
<section class="section" style="padding-top:7rem;">
  <div class="container">
    <div style="margin-bottom:1.5rem;">
      <a href="{{ route('home') }}" style="color:var(--blue);font-size:0.85rem;font-weight:600;">&larr; Назад на главную</a>
    </div>

    <div class="section-header" style="margin-bottom:2rem;">
      <h1 class="section-title">Наши работы</h1>
      <p class="section-desc">Реализованные проекты с использованием алюминиевых и ПВХ профильных систем</p>
    </div>

    <div class="projects-grid">
      @forelse($projects as $project)
        <a href="{{ route('project.show', $project) }}" class="project-card reveal" style="text-decoration:none;">
          <div class="project-card-img">
            @if($project->image)
              <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg,#1a1a2e,#16213e);display:flex;align-items:center;justify-content:center;">
                <svg viewBox="0 0 48 48" width="48" height="48" style="color:#fff;opacity:0.15;"><path d="M6 40V14l18-10 18 10v26H6z" stroke="currentColor" fill="none" stroke-width="2"/><rect x="18" y="24" width="12" height="16" stroke="currentColor" fill="none" stroke-width="2"/></svg>
              </div>
            @endif
            <div class="project-card-overlay">
              <span style="font-size:0.82rem;font-weight:600;color:#fff;">Подробнее &rarr;</span>
            </div>
          </div>
          <div class="project-card-body">
            <h3 style="font-size:1.05rem;font-weight:700;color:var(--dark);margin-bottom:0.3rem;">{{ $project->title }}</h3>
            @if($project->description)
              <p style="font-size:0.83rem;color:var(--gray-400);line-height:1.45;">{{ Str::limit($project->description, 100) }}</p>
            @endif
            <div style="display:flex;gap:1rem;margin-top:0.6rem;font-size:0.78rem;color:var(--gray-400);">
              @if($project->location)<span>{{ $project->location }}</span>@endif
              @if($project->year)<span>{{ $project->year }}</span>@endif
            </div>
          </div>
        </a>
      @empty
        <div style="grid-column:1/-1;text-align:center;padding:4rem 2rem;">
          <p style="color:var(--gray-400);font-size:1rem;">Пока нет проектов</p>
        </div>
      @endforelse
    </div>

    @if($projects->hasPages())
      <div style="margin-top:2rem;display:flex;justify-content:center;">{{ $projects->links() }}</div>
    @endif
  </div>
</section>

@push('styles')
<style>
  .projects-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem; }
  .project-card { background:#fff;border-radius:14px;overflow:hidden;border:1px solid var(--border);transition:box-shadow 0.25s,transform 0.25s; }
  .project-card:hover { box-shadow:0 8px 30px rgba(0,0,0,0.08);transform:translateY(-3px); }
  .project-card-img { height:220px;overflow:hidden;position:relative; }
  .project-card-img img { width:100%;height:100%;object-fit:cover;transition:transform 0.3s; }
  .project-card:hover .project-card-img img { transform:scale(1.05); }
  .project-card-overlay { position:absolute;inset:0;background:rgba(0,0,0,0.4);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity 0.25s; }
  .project-card:hover .project-card-overlay { opacity:1; }
  .project-card-body { padding:1.25rem; }
</style>
@endpush
@endsection
