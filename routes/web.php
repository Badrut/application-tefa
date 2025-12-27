<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function (){
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.view');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/update-picture', [ProfileController::class, 'updatePicture'])->name('profile.updatePicture');
    Route::put('/profile/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

Route::middleware(['auth' , 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/admin/master/user', [MasterDataController::class, 'users'])->name('admin.master-data.users');
    Route::get('/admin/master/add-user', [MasterDataController::class, 'userCreate'])->name('admin.master-data.add-user');
    Route::get('/admin/master/users/show/{id}', [MasterDataController::class, 'userShow'])->name('admin.master-data.user-show');
    Route::get('/admin/master/users/edit/{id}', [MasterDataController::class, 'userEdit'])->name('admin.master-data.user-edit');
    Route::put('/admin/master/users/update/{id}', [MasterDataController::class, 'userUpdate'])->name('admin.master-data.user-update');
    Route::delete('/admin/master/users/{id}', [MasterDataController::class, 'userDestroy'])->name('admin.master-data.user-destroy');
    Route::post('/admin/master/store-user', [MasterDataController::class, 'userStore'])->name('admin.master-data.user-store');

    Route::get('/admin/master/major', [MasterDataController::class, 'major'])->name('admin.master-data.major');
    Route::get('/admin/master/add-major', [MasterDataController::class, 'majorCreate'])->name('admin.master-data.add-major');
    Route::get('/admin/master/majors/show/{id}', [MasterDataController::class, 'majorShow'])->name('admin.master-data.major-show');
    Route::get('/admin/master/majors/edit/{id}', [MasterDataController::class, 'majorEdit'])->name('admin.master-data.major-edit');
    Route::put('/admin/master/majors/update/{id}', [MasterDataController::class, 'majorUpdate'])->name('admin.master-data.major-update');
    Route::delete('/admin/master/majors/{id}', [MasterDataController::class, 'majorDestroy'])->name('admin.master-data.major-destroy');
    Route::post('/admin/master/store-major', [MasterDataController::class, 'majorStore'])->name('admin.master-data.major-store');



    Route::get('/admin/transaksi', [TransaksiController::class, 'admin'])->name('admin.transaksi');
    Route::get('/admin/produksi', [ProduksiController::class, 'admin'])->name('admin.produksi');
    Route::get('/admin/produksi/add-product' , [ProduksiController::class , 'create'])->name('admin.produksi.add-product');
    Route::get('/admin/produksi/add-service' , [ProduksiController::class , 'createService'])->name('admin.produksi.add-service');
    Route::post('/admin/produksi', [ProduksiController::class, 'store'])->name('admin.produksi.store');
    Route::post('/admin/produksi/service', [ProduksiController::class, 'storeService'])->name('admin.produksi.store-service');
    Route::get('/admin/produksi/{id}/edit', [ProduksiController::class, 'edit'])->name('admin.produksi.edit');
    Route::put('/admin/produksi/{id}', [ProduksiController::class, 'update'])->name('admin.produksi.update');
    Route::get('/admin/produksi/{id}/product' , [ProduksiController::class , 'show'])->name('admin.produksi.detail-product');
    Route::get('/admin/produksi/{id}/service' , [ProduksiController::class , 'showService'])->name('admin.produksi.detail-service');
    Route::get('/admin/produksi/service/{id}/edit', [ProduksiController::class, 'editService'])->name('admin.produksi.edit-service');
    Route::put('/admin/produksi/service/{id}', [ProduksiController::class, 'updateService'])->name('admin.produksi.update-service');
    Route::delete('/admin/produksi/service/{id}', [ProduksiController::class, 'destroyService'])->name('admin.produksi.destroy-service');
    Route::delete('/admin/produksi/photos/{id}', [ProduksiController::class, 'destroyPhoto'])->name('admin.produksi.photo-destroy');
    Route::delete('/admin/produksi/{id}', [ProduksiController::class, 'destroy'])->name('admin.produksi.destroy');

    Route::get('/admin/proyek', [ProyekController::class, 'admin'])->name('admin.proyek');
    Route::get('/admin/laporan', [LaporanController::class, 'admin'])->name('admin.laporan');
});

Route::middleware(['auth' , 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');
});

Route::middleware(['auth' , 'role:student'])->group(function () {
    Route::get('/student/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');
});

Route::middleware(['auth' , 'role:customer'])->group(function () {
    Route::get('/customer/katalog' , [KatalogController::class , 'index'])->name('customer.katalog');
    Route::get('/customer/dashboard', [DashboardController::class, 'customer'])->name('customer.dashboard');
    Route::get('/customer/katalog/{id}/service' , [KatalogController::class , 'showService'])->name('customer.katalog.detail-service');
    Route::get('/customer/katalog/{id}/product' , [KatalogController::class , 'showProduct'])->name('customer.katalog.detail-product');
});

Route::middleware(['auth' , 'role:supplier'])->group(function () {
    Route::get('/supplier/dashboard', [DashboardController::class, 'supplier'])->name('supplier.dashboard');
});


