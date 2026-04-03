@extends('admin.layouts.app')

@section('title', 'Дашборд')

@section('content')
    {{-- Stats cards --}}
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:rgba(25,62,234,.1);color:#193EEA;font-size:1.4rem;">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Продукция</div>
                        <div class="fs-4 fw-bold">{{ $productsCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:rgba(16,185,129,.1);color:#10b981;font-size:1.4rem;">
                        <i class="bi bi-folder-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Категории</div>
                        <div class="fs-4 fw-bold">{{ $categoriesCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:rgba(245,158,11,.1);color:#f59e0b;font-size:1.4rem;">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Страницы</div>
                        <div class="fs-4 fw-bold">{{ $pagesCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:rgba(139,92,246,.1);color:#8b5cf6;font-size:1.4rem;">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Настройки</div>
                        <div class="fs-4 fw-bold">{{ $settingsCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-3">Быстрые действия</h5>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Добавить продукт
                </a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i> Добавить категорию
                </a>
                <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-images me-1"></i> Медиа-библиотека
                </a>
                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-gear me-1"></i> Настройки сайта
                </a>
            </div>
        </div>
    </div>
@endsection
