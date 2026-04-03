<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Админ') — BestProf</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bp-navy: #00074B;
            --bp-primary: #193EEA;
            --bp-primary-hover: #1232c4;
            --bp-sidebar-w: 260px;
        }

        * { font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif; }

        body {
            background: #f4f6fb;
            min-height: 100vh;
        }

        /* ---- Sidebar ---- */
        .bp-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--bp-sidebar-w);
            background: var(--bp-navy);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .bp-sidebar .sidebar-logo {
            padding: 1.5rem 1.25rem;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: .5px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .bp-sidebar .sidebar-logo span {
            color: var(--bp-primary);
            background: rgba(25,62,234,.15);
            padding: 2px 8px;
            border-radius: 6px;
            margin-right: 6px;
            font-weight: 800;
        }

        .bp-sidebar .nav-link {
            color: rgba(255,255,255,.6);
            padding: .7rem 1.25rem;
            font-size: .9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .65rem;
            border-radius: 0;
            transition: all .15s;
        }

        .bp-sidebar .nav-link i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
        }

        .bp-sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.06);
        }

        .bp-sidebar .nav-link.active {
            color: #fff;
            background: var(--bp-primary);
            font-weight: 600;
        }

        /* ---- Main wrapper ---- */
        .bp-main {
            margin-left: var(--bp-sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ---- Top header ---- */
        .bp-header {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: #fff;
            border-bottom: 1px solid #e9ecf3;
            padding: .85rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .bp-header h1 {
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0;
            color: var(--bp-navy);
        }

        /* ---- Content ---- */
        .bp-content {
            flex: 1;
            padding: 1.75rem;
        }

        /* ---- Utilities ---- */
        .btn-primary {
            background: var(--bp-primary);
            border-color: var(--bp-primary);
        }
        .btn-primary:hover, .btn-primary:focus {
            background: var(--bp-primary-hover);
            border-color: var(--bp-primary-hover);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }

        .toast-container {
            z-index: 1090;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <aside class="bp-sidebar">
        <div class="sidebar-logo">
            <span>BP</span> BestProf
        </div>

        <nav class="nav flex-column mt-2">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2-fill"></i> Дашборд
            </a>
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
               href="{{ route('admin.categories.index') }}">
                <i class="bi bi-folder-fill"></i> Категории
            </a>
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
               href="{{ route('admin.products.index') }}">
                <i class="bi bi-box-seam-fill"></i> Продукция
            </a>
            <a class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}"
               href="{{ route('admin.posts.index') }}">
                <i class="bi bi-newspaper"></i> Новости и блог
            </a>
            <a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}"
               href="{{ route('admin.projects.index') }}">
                <i class="bi bi-building"></i> Наши работы
            </a>
            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
               href="{{ route('admin.settings.index') }}">
                <i class="bi bi-gear-fill"></i> Настройки
            </a>
            <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}"
               href="{{ route('admin.pages.index') }}">
                <i class="bi bi-file-earmark-text-fill"></i> Страницы
            </a>
            <a class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}"
               href="{{ route('admin.media.index') }}">
                <i class="bi bi-images"></i> Медиа
            </a>
        </nav>
    </aside>

    {{-- Main --}}
    <div class="bp-main">
        {{-- Header --}}
        <header class="bp-header">
            <h1>@yield('title', 'Дашборд')</h1>

            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-box-arrow-right"></i> Выйти
                </button>
            </form>
        </header>

        {{-- Content --}}
        <main class="bp-content">
            @yield('content')
        </main>
    </div>

    {{-- Toast --}}
    @if(session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast align-items-center text-bg-success border-0 show" role="alert" id="bp-toast">
                <div class="d-flex">
                    <div class="toast-body">{{ session('success') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.getElementById('bp-toast');
            if (toastEl) {
                setTimeout(function () {
                    var bsToast = bootstrap.Toast.getOrCreateInstance(toastEl);
                    bsToast.hide();
                }, 4000);
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
