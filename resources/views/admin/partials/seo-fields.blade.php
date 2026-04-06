{{-- SEO Fields Partial --}}
{{-- Usage: @include('admin.partials.seo-fields', ['model' => $post]) --}}
<div class="card mb-4">
    <div class="card-header fw-semibold">
        <i class="bi bi-search me-1"></i> SEO настройки
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12">
                <label for="meta_title" class="form-label fw-semibold">META заголовок</label>
                <input type="text"
                       id="meta_title"
                       name="meta_title"
                       class="form-control @error('meta_title') is-invalid @enderror"
                       value="{{ old('meta_title', $model->meta_title ?? '') }}"
                       placeholder="Оставьте пустым для автоматической генерации"
                       maxlength="70">
                <div class="form-text">Рекомендуемая длина: до 60 символов. <span id="meta_title_count">0</span>/70</div>
                @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="meta_description" class="form-label fw-semibold">META описание</label>
                <textarea id="meta_description"
                          name="meta_description"
                          class="form-control @error('meta_description') is-invalid @enderror"
                          rows="3"
                          placeholder="Оставьте пустым для автоматической генерации"
                          maxlength="160">{{ old('meta_description', $model->meta_description ?? '') }}</textarea>
                <div class="form-text">Рекомендуемая длина: до 155 символов. <span id="meta_description_count">0</span>/160</div>
                @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="meta_keywords" class="form-label fw-semibold">META ключевые слова</label>
                <input type="text"
                       id="meta_keywords"
                       name="meta_keywords"
                       class="form-control @error('meta_keywords') is-invalid @enderror"
                       value="{{ old('meta_keywords', $model->meta_keywords ?? '') }}"
                       placeholder="ключевое слово 1, ключевое слово 2, ...">
                <div class="form-text">Через запятую</div>
                @error('meta_keywords')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    function setupCounter(inputId, counterId) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        if (!input || !counter) return;
        const update = () => counter.textContent = input.value.length;
        input.addEventListener('input', update);
        update();
    }
    setupCounter('meta_title', 'meta_title_count');
    setupCounter('meta_description', 'meta_description_count');
})();
</script>
@endpush
