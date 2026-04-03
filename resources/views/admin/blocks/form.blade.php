@extends('admin.layouts.app')

@section('title', 'Редактировать блок: ' . ($block->title ?? $block->key ?? ''))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Редактировать блок</h4>
        <a href="{{ route('admin.pages.edit', $block->page) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Назад к странице
        </a>
    </div>

    <form action="{{ route('admin.blocks.update', $block) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Содержимое блока</div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- Key (readonly info) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ключ блока</label>
                                <input type="text"
                                       class="form-control"
                                       value="{{ $block->key }}"
                                       disabled>
                                <div class="form-text">Системный ключ, не редактируется</div>
                            </div>

                            {{-- Type (readonly info) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Тип</label>
                                <input type="text"
                                       class="form-control"
                                       value="{{ $block->type ?? 'content' }}"
                                       disabled>
                            </div>

                            {{-- Title --}}
                            <div class="col-12">
                                <label for="title" class="form-label fw-semibold">Заголовок</label>
                                <input type="text"
                                       id="title"
                                       name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $block->title) }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Content --}}
                            <div class="col-12">
                                <label for="content" class="form-label fw-semibold">Контент</label>
                                <textarea id="content"
                                          name="content"
                                          class="form-control @error('content') is-invalid @enderror"
                                          rows="8">{{ old('content', $block->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Data (JSON) --}}
                            <div class="col-12">
                                <label for="data" class="form-label fw-semibold">Данные (JSON)</label>
                                <textarea id="data"
                                          name="data"
                                          class="form-control font-monospace @error('data') is-invalid @enderror"
                                          rows="10"
                                          style="font-size: .85rem;">{{ old('data', isset($block->data) ? json_encode($block->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                                <div class="form-text">Введите валидный JSON. Используется для структурированных данных блока.</div>
                                @error('data')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Image --}}
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Изображение</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file"
                                   id="image"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($block->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $block->image) }}"
                                     alt="{{ $block->title }}"
                                     class="img-fluid rounded">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Settings --}}
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Параметры</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label fw-semibold">Порядок сортировки</label>
                            <input type="number"
                                   id="sort_order"
                                   name="sort_order"
                                   class="form-control @error('sort_order') is-invalid @enderror"
                                   value="{{ old('sort_order', $block->sort_order ?? 0) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox"
                                   class="form-check-input"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $block->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">Активен</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-check-lg me-1"></i> Сохранить блок
                </button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Validate JSON on form submit
        var dataField = document.getElementById('data');
        dataField.closest('form').addEventListener('submit', function (e) {
            var val = dataField.value.trim();
            if (val !== '') {
                try {
                    JSON.parse(val);
                } catch (err) {
                    e.preventDefault();
                    dataField.classList.add('is-invalid');
                    alert('Поле "Данные (JSON)" содержит невалидный JSON: ' + err.message);
                }
            }
        });

        // Auto-format JSON on blur
        dataField.addEventListener('blur', function () {
            var val = this.value.trim();
            if (val !== '') {
                try {
                    var parsed = JSON.parse(val);
                    this.value = JSON.stringify(parsed, null, 2);
                    this.classList.remove('is-invalid');
                } catch (err) {
                    // leave as-is
                }
            }
        });
    });
</script>
@endpush
