<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\HomeController;

// ═══════ PUBLIC ═══════
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/catalog/{category:slug}', [HomeController::class, 'category'])->name('catalog.category');
Route::get('/product/{product:slug}', [HomeController::class, 'product'])->name('product.show');

Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/post/{post:slug}', [HomeController::class, 'post'])->name('post.show');

Route::get('/projects', [HomeController::class, 'projects'])->name('projects');
Route::get('/project/{project:slug}', [HomeController::class, 'project'])->name('project.show');

// ═══════ ADMIN AUTH ═══════
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ═══════ ADMIN PANEL ═══════
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('posts', PostController::class)->except(['show']);
    Route::resource('projects', ProjectController::class)->except(['show']);

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::resource('pages', PageController::class)->except(['show', 'create', 'store', 'destroy']);

    Route::get('blocks/{block}/edit', [BlockController::class, 'edit'])->name('blocks.edit');
    Route::put('blocks/{block}', [BlockController::class, 'update'])->name('blocks.update');

    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
});
