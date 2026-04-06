@extends('admin.layouts.app')

@section('title', isset($post) ? 'Редактировать публикацию' : 'Новая публикация')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">{{ isset($post) ? 'Редактировать публикацию' : 'Новая публикация' }}</h4>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Назад</a>
    </div>

    <form action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($post)) @method('PUT') @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="title" class="form-label fw-semibold">Заголовок <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title ?? '') }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="slug" class="form-label fw-semibold">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug ?? '') }}" placeholder="auto">
                                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="excerpt" class="form-label fw-semibold">Краткое описание</label>
                                <textarea id="excerpt" name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="2">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                                @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="content" class="form-label fw-semibold">Контент</label>
                                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="12">{{ old('content', $post->content ?? '') }}</textarea>
                                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Публикация</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="type" class="form-label fw-semibold">Тип</label>
                            <select id="type" name="type" class="form-select">
                                <option value="news" {{ old('type', $post->type ?? 'news') === 'news' ? 'selected' : '' }}>Новость</option>
                                <option value="blog" {{ old('type', $post->type ?? '') === 'blog' ? 'selected' : '' }}>Блог</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="published_at" class="form-label fw-semibold">Дата публикации</label>
                            <input type="date" id="published_at" name="published_at" class="form-control" value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d') : date('Y-m-d')) }}">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_published">Опубликовано</label>
                        </div>
                        <div>
                            <label for="sort_order" class="form-label fw-semibold">Порядок</label>
                            <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $post->sort_order ?? 0) }}">
                        </div>
                    </div>
                </div>
                @include('admin.partials.seo-fields', ['model' => $post ?? null])
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Изображение</div>
                    <div class="card-body">
                        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if(isset($post) && $post->image)
                            <div class="mt-2"><img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg me-1"></i> {{ isset($post) ? 'Сохранить' : 'Создать' }}</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary btn-lg">Отмена</a>
        </div>
    </form>
@endsection
