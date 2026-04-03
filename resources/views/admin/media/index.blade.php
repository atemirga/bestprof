@extends('admin.layouts.app')

@section('title', 'Медиа')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Медиа-библиотека</h4>
    </div>

    {{-- Upload form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf

                <div id="drop-zone"
                     class="border border-2 border-dashed rounded-3 p-5 text-center"
                     style="border-color: #c5cee0 !important; background: #f8f9fd; cursor: pointer; transition: all .2s;">
                    <i class="bi bi-cloud-arrow-up fs-1 text-muted d-block mb-2"></i>
                    <p class="mb-1 fw-semibold">Перетащите файлы сюда или нажмите для выбора</p>
                    <p class="text-muted small mb-0">PNG, JPG, GIF, SVG, WebP. Макс. 10MB</p>
                    <input type="file"
                           id="media-files"
                           name="files[]"
                           class="d-none"
                           accept="image/*"
                           multiple>
                </div>

                @error('files')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
                @error('files.*')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror

                <div id="upload-preview" class="row g-2 mt-3" style="display: none;"></div>

                <div id="upload-actions" class="mt-3" style="display: none;">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i> Загрузить
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Media grid --}}
    <div class="card">
        <div class="card-body">
            @if(($media ?? collect())->count())
                <div class="row g-3">
                    @foreach($media as $item)
                        <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                            <div class="position-relative rounded overflow-hidden border" style="aspect-ratio: 1;">
                                @if(str_starts_with($item->mime_type ?? '', 'image/'))
                                    <img src="{{ asset('storage/' . $item->path) }}"
                                         alt="{{ $item->alt ?? $item->filename }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                        <i class="bi bi-file-earmark fs-1 text-muted"></i>
                                    </div>
                                @endif

                                {{-- Overlay with actions --}}
                                <div class="position-absolute bottom-0 start-0 end-0 p-2"
                                     style="background: linear-gradient(transparent, rgba(0,0,0,.7));">
                                    <div class="d-flex justify-content-between align-items-end">
                                        <small class="text-white text-truncate" style="max-width: 70%;" title="{{ $item->filename }}">
                                            {{ $item->filename }}
                                        </small>
                                        <form action="{{ route('admin.media.destroy', $item) }}"
                                              method="POST"
                                              onsubmit="return confirm('Удалить файл «{{ $item->filename }}»?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Удалить" style="padding: 2px 6px; font-size: .7rem;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Copy URL --}}
                            <div class="mt-1">
                                <input type="text"
                                       class="form-control form-control-sm text-muted"
                                       value="{{ asset('storage/' . $item->path) }}"
                                       readonly
                                       onclick="this.select(); document.execCommand('copy');"
                                       title="Нажмите, чтобы скопировать URL"
                                       style="font-size: .7rem;">
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($media->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $media->links() }}
                    </div>
                @endif
            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-images fs-1 d-block mb-2"></i>
                    Медиа-файлов пока нет. Загрузите первый файл выше.
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    #drop-zone.drag-over {
        border-color: #193EEA !important;
        background: rgba(25, 62, 234, .05) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dropZone = document.getElementById('drop-zone');
        var fileInput = document.getElementById('media-files');
        var preview = document.getElementById('upload-preview');
        var actions = document.getElementById('upload-actions');

        // Click to open file dialog
        dropZone.addEventListener('click', function () {
            fileInput.click();
        });

        // Drag & drop
        dropZone.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        dropZone.addEventListener('dragleave', function (e) {
            e.preventDefault();
            this.classList.remove('drag-over');
        });

        dropZone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            fileInput.files = e.dataTransfer.files;
            showPreviews(fileInput.files);
        });

        // File input change
        fileInput.addEventListener('change', function () {
            showPreviews(this.files);
        });

        function showPreviews(files) {
            preview.innerHTML = '';
            if (files.length === 0) {
                preview.style.display = 'none';
                actions.style.display = 'none';
                return;
            }

            preview.style.display = '';
            actions.style.display = '';

            Array.from(files).forEach(function (file) {
                var col = document.createElement('div');
                col.className = 'col-4 col-md-2';

                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        col.innerHTML = '<div class="rounded border overflow-hidden" style="aspect-ratio:1;">' +
                            '<img src="' + e.target.result + '" class="w-100 h-100" style="object-fit:cover;">' +
                            '</div><small class="text-muted text-truncate d-block" style="font-size:.75rem;">' + file.name + '</small>';
                    };
                    reader.readAsDataURL(file);
                } else {
                    col.innerHTML = '<div class="rounded border bg-light d-flex align-items-center justify-content-center" style="aspect-ratio:1;">' +
                        '<i class="bi bi-file-earmark fs-3 text-muted"></i></div>' +
                        '<small class="text-muted text-truncate d-block" style="font-size:.75rem;">' + file.name + '</small>';
                }

                preview.appendChild(col);
            });
        }
    });
</script>
@endpush
