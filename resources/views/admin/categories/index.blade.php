@extends('admin.layouts.app')

@section('title', 'Категории')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Все категории</h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Добавить категорию
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($categories->count())
                @foreach($categories as $category)
                    @include('admin.partials.category-tree-item', ['category' => $category, 'depth' => 0])
                @endforeach
            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-folder2-open fs-1 d-block mb-2"></i>
                    Категорий пока нет.
                    <a href="{{ route('admin.categories.create') }}">Создать первую</a>
                </div>
            @endif
        </div>
    </div>
@endsection
