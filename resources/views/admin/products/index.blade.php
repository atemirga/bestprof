@extends('admin.layouts.app')

@section('title', 'Продукция')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Все продукты</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Добавить продукт
        </a>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="category_id" class="form-label fw-semibold">Категория</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option value="">Все категории</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ str_repeat('— ', $cat->depth ?? 0) }}{{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="search" class="form-label fw-semibold">Поиск</label>
                    <input type="text"
                           id="search"
                           name="search"
                           class="form-control"
                           value="{{ request('search') }}"
                           placeholder="Название или артикул...">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Найти
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Сбросить</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Products table --}}
    <div class="card">
        <div class="card-body p-0">
            @if($products->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 60px;"></th>
                                <th>Название</th>
                                <th>Категория</th>
                                <th>Артикул</th>
                                <th>Цена</th>
                                <th>Наличие</th>
                                <th>Статус</th>
                                <th style="width: 120px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="rounded"
                                                 style="width: 44px; height: 44px; object-fit: cover;">
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                 style="width: 44px; height: 44px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $product->name }}</div>
                                        @if($product->is_featured)
                                            <span class="badge bg-warning text-dark" style="font-size: .7rem;">Featured</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $product->category->name ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <code class="small">{{ $product->sku ?? '—' }}</code>
                                    </td>
                                    <td>
                                        {{ $product->price_display ?? ($product->price ? number_format($product->price, 0, ',', ' ') . ' ₽' : '—') }}
                                    </td>
                                    <td>
                                        @php
                                            $availBadge = match($product->availability) {
                                                'in_stock' => ['bg-success', 'В наличии'],
                                                'out_of_stock' => ['bg-danger', 'Нет в наличии'],
                                                'on_order' => ['bg-warning text-dark', 'Под заказ'],
                                                default => ['bg-secondary', $product->availability ?? '—'],
                                            };
                                        @endphp
                                        <span class="badge {{ $availBadge[0] }}">{{ $availBadge[1] }}</span>
                                    </td>
                                    <td>
                                        @if($product->is_active)
                                            <span class="badge bg-success-subtle text-success">Активен</span>
                                        @else
                                            <span class="badge bg-secondary">Скрыт</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary" title="Редактировать">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Удалить продукт «{{ $product->name }}»?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Удалить" style="border-top-left-radius:0;border-bottom-left-radius:0;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                    Продуктов пока нет.
                    <a href="{{ route('admin.products.create') }}">Добавить первый</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
@endsection
