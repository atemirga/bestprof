@extends('admin.layouts.app')

@section('title', isset($project) ? 'Редактировать проект' : 'Новый проект')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">{{ isset($project) ? 'Редактировать проект' : 'Новый проект' }}</h4>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Назад</a>
    </div>

    <form action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($project)) @method('PUT') @endif

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="title" class="form-label fw-semibold">Название <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $project->title ?? '') }}" required>
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="slug" class="form-label fw-semibold">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $project->slug ?? '') }}" placeholder="auto">
                                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="client" class="form-label fw-semibold">Заказчик</label>
                                <input type="text" id="client" name="client" class="form-control" value="{{ old('client', $project->client ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="location" class="form-label fw-semibold">Локация</label>
                                <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $project->location ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="year" class="form-label fw-semibold">Год</label>
                                <input type="text" id="year" name="year" class="form-control" value="{{ old('year', $project->year ?? '') }}" placeholder="{{ date('Y') }}">
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Краткое описание</label>
                                <textarea id="description" name="description" class="form-control" rows="2">{{ old('description', $project->description ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="content" class="form-label fw-semibold">Полное описание</label>
                                <textarea id="content" name="content" class="form-control" rows="8">{{ old('content', $project->content ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Публикация</div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" {{ old('is_published', $project->is_published ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_published">Опубликовано</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_featured">На главной</label>
                        </div>
                        <div>
                            <label for="sort_order" class="form-label fw-semibold">Порядок</label>
                            <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $project->sort_order ?? 0) }}">
                        </div>
                    </div>
                </div>
                @include('admin.partials.seo-fields', ['model' => $project ?? null])
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Главное фото</div>
                    <div class="card-body">
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if(isset($project) && $project->image)
                            <div class="mt-2"><img src="{{ asset('storage/' . $project->image) }}" class="img-fluid rounded"></div>
                        @endif
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Галерея</div>
                    <div class="card-body">
                        <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                        <div class="form-text">Можно выбрать несколько фото</div>
                        @if(isset($project) && $project->gallery && count($project->gallery))
                            <div class="mt-2 d-flex flex-wrap gap-1">
                                @foreach($project->gallery as $img)
                                    <img src="{{ asset('storage/' . $img) }}" class="rounded" style="width:60px;height:45px;object-fit:cover;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-lg me-1"></i> {{ isset($project) ? 'Сохранить' : 'Создать' }}</button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary btn-lg">Отмена</a>
        </div>
    </form>
@endsection
