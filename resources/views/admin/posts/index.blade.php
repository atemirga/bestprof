@extends('admin.layouts.app')

@section('title', 'Новости и блог')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Новости и блог</h4>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Добавить</a>
    </div>

    <div class="card mb-3">
        <div class="card-body py-2">
            <form method="GET" class="d-flex gap-2 align-items-center">
                <select name="type" class="form-select form-select-sm" style="width:140px;" onchange="this.form.submit()">
                    <option value="">Все типы</option>
                    <option value="news" {{ request('type') === 'news' ? 'selected' : '' }}>Новости</option>
                    <option value="blog" {{ request('type') === 'blog' ? 'selected' : '' }}>Блог</option>
                </select>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Поиск..." value="{{ request('search') }}" style="max-width:250px;">
                <button class="btn btn-sm btn-outline-secondary">Найти</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;"></th>
                        <th>Заголовок</th>
                        <th style="width:80px;">Тип</th>
                        <th style="width:120px;">Дата</th>
                        <th style="width:90px;">Статус</th>
                        <th style="width:120px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="rounded" style="width:45px;height:35px;object-fit:cover;">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:45px;height:35px;"><i class="bi bi-image text-muted"></i></div>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $post->title }}</td>
                            <td><span class="badge {{ $post->type === 'news' ? 'bg-success' : 'bg-info' }}">{{ $post->type === 'news' ? 'Новость' : 'Блог' }}</span></td>
                            <td class="text-muted small">{{ $post->published_at?->format('d.m.Y') }}</td>
                            <td>
                                @if($post->is_published)
                                    <span class="badge bg-success-subtle text-success">Опубл.</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Черновик</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Удалить?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Нет публикаций</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($posts->hasPages())
        <div class="mt-3">{{ $posts->links() }}</div>
    @endif
@endsection
