@extends('admin.layouts.app')

@section('title', 'Страницы')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Все страницы</h4>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if(($pages ?? collect())->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Название</th>
                                <th>Slug</th>
                                <th>Блоков</th>
                                <th>Статус</th>
                                <th style="width: 100px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td class="fw-semibold">{{ $page->title }}</td>
                                    <td><code class="small">/{{ $page->slug }}</code></td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-layers me-1"></i>{{ $page->blocks_count ?? $page->blocks->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($page->is_active)
                                            <span class="badge bg-success-subtle text-success">Активна</span>
                                        @else
                                            <span class="badge bg-secondary">Скрыта</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-primary" title="Редактировать">
                                            <i class="bi bi-pencil"></i> Изменить
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-file-earmark-text fs-1 d-block mb-2"></i>
                    Страниц пока нет.
                </div>
            @endif
        </div>
    </div>
@endsection
