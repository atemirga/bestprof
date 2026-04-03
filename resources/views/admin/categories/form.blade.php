@extends('admin.layouts.app')

@section('title', isset($category) ? 'Редактировать категорию' : 'Новая категория')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">{{ isset($category) ? 'Редактировать категорию' : 'Новая категория' }}</h4>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Назад
        </a>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif

                <div class="row g-4">
                    {{-- Name --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Название <span class="text-danger">*</span></label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $category->name ?? '') }}"
                               required>
                        @error('name')
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
                               value="{{ old('slug', $category->slug ?? '') }}"
                               placeholder="auto-generate">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Parent category --}}
                    <div class="col-md-6">
                        <label for="parent_id" class="form-label fw-semibold">Родительская категория</label>
                        <select id="parent_id"
                                name="parent_id"
                                class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">-- Корневая --</option>
                            @foreach($allCategories ?? [] as $cat)
                                @if(!isset($category) || $cat->id !== $category->id)
                                    <option value="{{ $cat->id }}"
                                        {{ old('parent_id', $category->parent_id ?? '') == $cat->id ? 'selected' : '' }}>
                                        {{ str_repeat('— ', $cat->depth ?? 0) }}{{ $cat->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Badge color --}}
                    <div class="col-md-3">
                        <label for="badge_color" class="form-label fw-semibold">Цвет бейджа</label>
                        <input type="color"
                               id="badge_color"
                               name="badge_color"
                               class="form-control form-control-color @error('badge_color') is-invalid @enderror"
                               value="{{ old('badge_color', $category->badge_color ?? '#193EEA') }}">
                        @error('badge_color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Sort order --}}
                    <div class="col-md-3">
                        <label for="sort_order" class="form-label fw-semibold">Порядок сортировки</label>
                        <input type="number"
                               id="sort_order"
                               name="sort_order"
                               class="form-control @error('sort_order') is-invalid @enderror"
                               value="{{ old('sort_order', $category->sort_order ?? 0) }}">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">Описание</label>
                        <textarea id="description"
                                  name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="col-md-6">
                        <label for="image" class="form-label fw-semibold">Изображение</label>
                        <input type="file"
                               id="image"
                               name="image"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if(isset($category) && $category->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $category->image) }}"
                                     alt="{{ $category->name }}"
                                     class="rounded"
                                     style="max-height: 120px;">
                            </div>
                        @endif
                    </div>

                    {{-- Is active --}}
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox"
                                   class="form-check-input"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">Активна</label>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> {{ isset($category) ? 'Сохранить' : 'Создать' }}
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        let slugManuallyEdited = slugInput.value !== '';

        slugInput.addEventListener('input', function () {
            slugManuallyEdited = this.value !== '';
        });

        nameInput.addEventListener('input', function () {
            if (!slugManuallyEdited) {
                slugInput.value = transliterate(this.value);
            }
        });

        function transliterate(text) {
            const map = {
                'а':'a','б':'b','в':'v','г':'g','д':'d','е':'e','ё':'yo','ж':'zh',
                'з':'z','и':'i','й':'y','к':'k','л':'l','м':'m','н':'n','о':'o',
                'п':'p','р':'r','с':'s','т':'t','у':'u','ф':'f','х':'kh','ц':'ts',
                'ч':'ch','ш':'sh','щ':'shch','ъ':'','ы':'y','ь':'','э':'e','ю':'yu','я':'ya',
                ' ':'-'
            };
            return text.toLowerCase().split('').map(function(c) {
                return map[c] !== undefined ? map[c] : c;
            }).join('').replace(/[^a-z0-9-]/g, '').replace(/-+/g, '-').replace(/^-|-$/g, '');
        }
    });
</script>
@endpush
