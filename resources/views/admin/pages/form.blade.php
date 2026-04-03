@extends('admin.layouts.app')

@section('title', 'Редактировать страницу: ' . ($page->title ?? ''))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Редактировать страницу</h4>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Назад
        </a>
    </div>

    <div class="row g-4">
        {{-- Page info --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header fw-semibold">Информация о странице</div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- Title --}}
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-semibold">Заголовок <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="title"
                                       name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $page->title) }}"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-6">
                                <label for="slug" class="form-label fw-semibold">Slug</label>
                                <input type="text"
                                       id="slug"
                                       name="slug"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug', $page->slug) }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Meta description --}}
                            <div class="col-12">
                                <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                                <textarea id="meta_description"
                                          name="meta_description"
                                          class="form-control @error('meta_description') is-invalid @enderror"
                                          rows="2">{{ old('meta_description', $page->meta_description) }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Meta keywords --}}
                            <div class="col-12">
                                <label for="meta_keywords" class="form-label fw-semibold">Meta Keywords</label>
                                <input type="text"
                                       id="meta_keywords"
                                       name="meta_keywords"
                                       class="form-control @error('meta_keywords') is-invalid @enderror"
                                       value="{{ old('meta_keywords', $page->meta_keywords) }}"
                                       placeholder="Через запятую">
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-3">

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i> Сохранить страницу
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Blocks list --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                    <span>Блоки страницы</span>
                    <span class="badge bg-primary">{{ $page->blocks->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($page->blocks->count())
                        <div class="list-group list-group-flush">
                            @foreach($page->blocks->sortBy('sort_order') as $block)
                                <a href="{{ route('admin.blocks.edit', $block) }}"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $block->title ?? $block->key }}</div>
                                        <small class="text-muted">
                                            {{ $block->type ?? 'content' }}
                                            @unless($block->is_active)
                                                <span class="badge bg-secondary ms-1">скрыт</span>
                                            @endunless
                                        </small>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-layers fs-3 d-block mb-1"></i>
                            <small>Блоков нет</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
