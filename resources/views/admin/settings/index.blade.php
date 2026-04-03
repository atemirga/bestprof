@extends('admin.layouts.app')

@section('title', 'Настройки')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Настройки сайта</h4>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        @forelse($groups ?? [] as $group => $settings)
            <div class="card mb-4">
                <div class="card-header fw-semibold text-capitalize">
                    <i class="bi bi-gear me-1"></i> {{ $group }}
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($settings as $setting)
                            <div class="col-md-6">
                                <label for="setting_{{ $setting->key }}" class="form-label fw-semibold">
                                    {{ $setting->label ?? $setting->key }}
                                </label>

                                @if($setting->type === 'textarea')
                                    <textarea id="setting_{{ $setting->key }}"
                                              name="settings[{{ $setting->key }}]"
                                              class="form-control @error('settings.' . $setting->key) is-invalid @enderror"
                                              rows="3">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                                @elseif($setting->type === 'boolean')
                                    <div>
                                        <input type="hidden" name="settings[{{ $setting->key }}]" value="0">
                                        <div class="form-check form-switch">
                                            <input type="checkbox"
                                                   class="form-check-input"
                                                   id="setting_{{ $setting->key }}"
                                                   name="settings[{{ $setting->key }}]"
                                                   value="1"
                                                   {{ old('settings.' . $setting->key, $setting->value) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="setting_{{ $setting->key }}">Включено</label>
                                        </div>
                                    </div>
                                @else
                                    <input type="text"
                                           id="setting_{{ $setting->key }}"
                                           name="settings[{{ $setting->key }}]"
                                           class="form-control @error('settings.' . $setting->key) is-invalid @enderror"
                                           value="{{ old('settings.' . $setting->key, $setting->value) }}">
                                @endif

                                @error('settings.' . $setting->key)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    <i class="bi bi-gear fs-1 d-block mb-2"></i>
                    Настроек пока нет.
                </div>
            </div>
        @endforelse

        @if(count($groups ?? []) > 0)
            <div class="d-flex">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg me-1"></i> Сохранить настройки
                </button>
            </div>
        @endif
    </form>
@endsection
