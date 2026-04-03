@extends('admin.layouts.app')

@section('title', isset($product) ? 'Редактировать продукт' : 'Новый продукт')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">{{ isset($product) ? 'Редактировать продукт' : 'Новый продукт' }}</h4>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Назад
        </a>
    </div>

    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="row g-4">
            {{-- Left column: main fields --}}
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Основная информация</div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-md-8">
                                <label for="name" class="form-label fw-semibold">Название <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $product->name ?? '') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="col-md-4">
                                <label for="slug" class="form-label fw-semibold">Slug</label>
                                <input type="text"
                                       id="slug"
                                       name="slug"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug', $product->slug ?? '') }}"
                                       placeholder="auto-generate">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-semibold">Категория <span class="text-danger">*</span></label>
                                <select id="category_id"
                                        name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- Выберите --</option>
                                    @foreach($categories ?? [] as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                            {{ str_repeat('— ', $cat->depth ?? 0) }}{{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SKU --}}
                            <div class="col-md-3">
                                <label for="sku" class="form-label fw-semibold">Артикул (SKU)</label>
                                <input type="text"
                                       id="sku"
                                       name="sku"
                                       class="form-control @error('sku') is-invalid @enderror"
                                       value="{{ old('sku', $product->sku ?? '') }}">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Type label --}}
                            <div class="col-md-3">
                                <label for="type_label" class="form-label fw-semibold">Тип</label>
                                <input type="text"
                                       id="type_label"
                                       name="type_label"
                                       class="form-control @error('type_label') is-invalid @enderror"
                                       value="{{ old('type_label', $product->type_label ?? '') }}">
                                @error('type_label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Краткое описание</label>
                                <textarea id="description"
                                          name="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="3">{{ old('description', $product->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Full description --}}
                            <div class="col-12">
                                <label for="full_description" class="form-label fw-semibold">Полное описание</label>
                                <textarea id="full_description"
                                          name="full_description"
                                          class="form-control @error('full_description') is-invalid @enderror"
                                          rows="6">{{ old('full_description', $product->full_description ?? '') }}</textarea>
                                @error('full_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pricing & Availability --}}
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Цена и наличие</div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- Price --}}
                            <div class="col-md-4">
                                <label for="price" class="form-label fw-semibold">Цена</label>
                                <div class="input-group">
                                    <input type="number"
                                           id="price"
                                           name="price"
                                           class="form-control @error('price') is-invalid @enderror"
                                           value="{{ old('price', $product->price ?? '') }}"
                                           step="0.01"
                                           min="0">
                                    <span class="input-group-text">₽</span>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Price display --}}
                            <div class="col-md-4">
                                <label for="price_display" class="form-label fw-semibold">Отображение цены</label>
                                <input type="text"
                                       id="price_display"
                                       name="price_display"
                                       class="form-control @error('price_display') is-invalid @enderror"
                                       value="{{ old('price_display', $product->price_display ?? '') }}"
                                       placeholder="напр. от 1 200 ₽/м">
                                @error('price_display')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Availability --}}
                            <div class="col-md-4">
                                <label for="availability" class="form-label fw-semibold">Наличие</label>
                                <select id="availability"
                                        name="availability"
                                        class="form-select @error('availability') is-invalid @enderror">
                                    <option value="in_stock" {{ old('availability', $product->availability ?? '') == 'in_stock' ? 'selected' : '' }}>В наличии</option>
                                    <option value="out_of_stock" {{ old('availability', $product->availability ?? '') == 'out_of_stock' ? 'selected' : '' }}>Нет в наличии</option>
                                    <option value="on_order" {{ old('availability', $product->availability ?? '') == 'on_order' ? 'selected' : '' }}>Под заказ</option>
                                </select>
                                @error('availability')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Specs & extras --}}
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Характеристики</div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- Specs --}}
                            <div class="col-12">
                                <label for="specs" class="form-label fw-semibold">Характеристики</label>
                                <input type="text"
                                       id="specs"
                                       name="specs"
                                       class="form-control @error('specs') is-invalid @enderror"
                                       value="{{ old('specs', isset($product) && $product->specs ? implode(', ', $product->specs) : '') }}"
                                       placeholder="Через запятую: толщина 0.5мм, ширина 1200мм">
                                <div class="form-text">Введите характеристики через запятую</div>
                                @error('specs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Hardware --}}
                            <div class="col-12">
                                <label for="hardware" class="form-label fw-semibold">Комплектующие</label>
                                <textarea id="hardware"
                                          name="hardware"
                                          class="form-control @error('hardware') is-invalid @enderror"
                                          rows="2">{{ old('hardware', $product->hardware ?? '') }}</textarea>
                                @error('hardware')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right column: sidebar --}}
            <div class="col-lg-4">
                {{-- Status --}}
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Публикация</div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox"
                                   class="form-check-input"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">Активен</label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox"
                                   class="form-check-input"
                                   id="is_featured"
                                   name="is_featured"
                                   value="1"
                                   {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_featured">Рекомендуемый</label>
                        </div>

                        <div>
                            <label for="sort_order" class="form-label fw-semibold">Порядок сортировки</label>
                            <input type="number"
                                   id="sort_order"
                                   name="sort_order"
                                   class="form-control @error('sort_order') is-invalid @enderror"
                                   value="{{ old('sort_order', $product->sort_order ?? 0) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Badge --}}
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Бейдж</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="badge" class="form-label fw-semibold">Текст бейджа</label>
                            <input type="text"
                                   id="badge"
                                   name="badge"
                                   class="form-control @error('badge') is-invalid @enderror"
                                   value="{{ old('badge', $product->badge ?? '') }}"
                                   placeholder="напр. Новинка">
                            @error('badge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="badge_color" class="form-label fw-semibold">Цвет бейджа</label>
                            <input type="color"
                                   id="badge_color"
                                   name="badge_color"
                                   class="form-control form-control-color @error('badge_color') is-invalid @enderror"
                                   value="{{ old('badge_color', $product->badge_color ?? '#193EEA') }}">
                            @error('badge_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

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

                        <div id="image-preview">
                            @if(isset($product) && $product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="img-fluid rounded">
                            @endif
                        </div>

                        <div class="mt-3">
                            <label for="card_bg" class="form-label fw-semibold">Фон карточки (CSS)</label>
                            <input type="text"
                                   id="card_bg"
                                   name="card_bg"
                                   class="form-control @error('card_bg') is-invalid @enderror"
                                   value="{{ old('card_bg', $product->card_bg ?? '') }}"
                                   placeholder="напр. #f0f4ff или linear-gradient(...)">
                            @error('card_bg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-lg me-1"></i> {{ isset($product) ? 'Сохранить' : 'Создать продукт' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-lg">Отмена</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-generate slug from name
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

        // Image preview
        const imageInput = document.getElementById('image');
        const previewContainer = document.getElementById('image-preview');

        imageInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewContainer.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" alt="Preview">';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush
