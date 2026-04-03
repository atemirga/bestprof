@extends('admin.layouts.app')

@section('title', 'Наши работы')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Наши работы</h4>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Добавить проект</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:70px;"></th>
                        <th>Название</th>
                        <th>Локация</th>
                        <th style="width:60px;">Год</th>
                        <th style="width:90px;">Статус</th>
                        <th style="width:120px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>
                                @if($project->image)
                                    <img src="{{ asset('storage/' . $project->image) }}" class="rounded" style="width:55px;height:40px;object-fit:cover;">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:55px;height:40px;"><i class="bi bi-building text-muted"></i></div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $project->title }}</div>
                                @if($project->client)<small class="text-muted">{{ $project->client }}</small>@endif
                            </td>
                            <td class="text-muted">{{ $project->location }}</td>
                            <td>{{ $project->year }}</td>
                            <td>
                                @if($project->is_published)
                                    <span class="badge bg-success-subtle text-success">Опубл.</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Черновик</span>
                                @endif
                                @if($project->is_featured)
                                    <span class="badge bg-info-subtle text-info">Featured</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Удалить проект?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Нет проектов</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($projects->hasPages())
        <div class="mt-3">{{ $projects->links() }}</div>
    @endif
@endsection
