<?php
use Illuminate\Support\Facades\Route;

Route::prefix('academy')->name('academy.')->middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Academy\CatalogController::class, 'index'])->name('catalog');
    Route::get('/dashboard', [\App\Http\Controllers\Academy\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\Academy\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Academy\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Academy\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/checkout/success', [\App\Http\Controllers\Academy\CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/{package:slug}', [\App\Http\Controllers\Academy\CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/{package:slug}', [\App\Http\Controllers\Academy\PackageController::class, 'show'])->name('package');
    Route::get('/{package:slug}/{lesson:slug}', [\App\Http\Controllers\Academy\LessonController::class, 'show'])->name('lesson');
});

Route::get('admin', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'platform_admin']);

Route::prefix('admin/academy')->name('admin.academy.')->middleware(['auth', 'platform_admin'])->group(function () {
    Route::get('/packages', [\App\Http\Controllers\Admin\Academy\PackageAdminController::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [\App\Http\Controllers\Admin\Academy\PackageAdminController::class, 'create'])->name('packages.create');
    Route::post('/packages', [\App\Http\Controllers\Admin\Academy\PackageAdminController::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/edit', [\App\Http\Controllers\Admin\Academy\PackageAdminController::class, 'edit'])->name('packages.edit');
    Route::patch('/packages/{package}', [\App\Http\Controllers\Admin\Academy\PackageAdminController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}', [\App\Http\Controllers\Admin\Academy\PackageAdminController::class, 'destroy'])->name('packages.destroy');

    Route::get('/lessons', [\App\Http\Controllers\Admin\Academy\LessonAdminController::class, 'index'])->name('lessons.index');
    Route::get('/lessons/create', [\App\Http\Controllers\Admin\Academy\LessonAdminController::class, 'create'])->name('lessons.create');
    Route::post('/lessons', [\App\Http\Controllers\Admin\Academy\LessonAdminController::class, 'store'])->name('lessons.store');
    Route::get('/lessons/{lesson}/edit', [\App\Http\Controllers\Admin\Academy\LessonAdminController::class, 'edit'])->name('lessons.edit');
    Route::patch('/lessons/{lesson}', [\App\Http\Controllers\Admin\Academy\LessonAdminController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [\App\Http\Controllers\Admin\Academy\LessonAdminController::class, 'destroy'])->name('lessons.destroy');
});

Route::prefix('admin/academy/lessons')->name('admin.academy.lessons.')->middleware(['auth', 'platform_admin'])->group(function () {
    Route::post('/{lesson}/upload-url', [\App\Http\Controllers\Admin\Academy\LessonAdminController::class, 'getUploadUrl'])->name('upload-url');
    Route::post('/{lesson}/confirm-upload', [\App\Http\Controllers\Admin\Academy\LessonAdminController::class, 'confirmUpload'])->name('confirm-upload');
});

Route::prefix('academy/progress')->name('academy.progress.')->middleware(['auth'])->group(function () {
    Route::post('/{lesson}', [\App\Http\Controllers\Academy\ProgressController::class, 'save'])->name('save');
    Route::post('/{lesson}/complete', [\App\Http\Controllers\Academy\ProgressController::class, 'complete'])->name('complete');
});

Route::prefix('admin/academy/packages/{package}/modules')->name('admin.academy.modules.')->middleware(['auth', 'platform_admin'])->group(function () {
    Route::post('/', [\App\Http\Controllers\Admin\Academy\ModuleAdminController::class, 'store'])->name('store');
    Route::delete('/{module}', [\App\Http\Controllers\Admin\Academy\ModuleAdminController::class, 'destroy'])->name('destroy');
});



Route::post('/webhook/stripe', [\App\Http\Controllers\Academy\CheckoutController::class, 'webhook'])->name('stripe.webhook')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
