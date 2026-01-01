<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\TransaksiController;
use App\Models\Quotation;
use Illuminate\Support\Facades\Route;
use Termwind\Question;

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
    Route::post('/konsultation/{id}/message', [ChatMessageController::class, 'storeMessage'])->name('konsultation.message.store');
    Route::get('/proyek' , [QuotationController::class  , 'index'])->name('proyek.index');
    Route::get('/proyek/create' , [QuotationController::class  , 'create'])->name('proyek.create');
    Route::post('/proyek/create' , [QuotationController::class  , 'store'])->name('proyek.store');
    Route::get('/proyek/edit/{quotation}' , [QuotationController::class  , 'edit'])->name('proyek.edit');
    Route::get('/proyek/detail/{quotation}' , [QuotationController::class  , 'show'])->name('proyek.show');
    Route::put('/proyek/{quotation}' , [QuotationController::class  , 'update'])->name('proyek.update');
    Route::delete('/proyek/{id}' , [QuotationController::class  , 'destroy'])->name('proyek.destroy');

    Route::get('produksi', [ProduksiController::class, 'index'])->name('produksi');
    Route::get('produksi/add-product' , [ProduksiController::class , 'create'])->name('produksi.add-product');
    Route::get('produksi/add-service' , [ProduksiController::class , 'createService'])->name('produksi.add-service');
    Route::post('produksi', [ProduksiController::class, 'store'])->name('produksi.store');
    Route::post('produksi/service', [ProduksiController::class, 'storeService'])->name('produksi.store-service');
    Route::get('produksi/{id}/edit', [ProduksiController::class, 'edit'])->name('produksi.edit');
    Route::put('produksi/{id}', [ProduksiController::class, 'update'])->name('produksi.update');
    Route::get('produksi/{id}/product' , [ProduksiController::class , 'show'])->name('produksi.detail-product');
    Route::get('produksi/{id}/service' , [ProduksiController::class , 'showService'])->name('produksi.detail-service');
    Route::get('produksi/service/{id}/edit', [ProduksiController::class, 'editService'])->name('produksi.edit-service');
    Route::put('produksi/service/{id}', [ProduksiController::class, 'updateService'])->name('produksi.update-service');
    Route::delete('produksi/service/{id}', [ProduksiController::class, 'destroyService'])->name('produksi.destroy-service');
    Route::delete('produksi/photos/{id}', [ProduksiController::class, 'destroyPhoto'])->name('produksi.photo-destroy');
    Route::delete('produksi/{id}', [ProduksiController::class, 'destroy'])->name('produksi.destroy');

    Route::get('order' , [OrderController::class , 'index'])->name('order.index');
    Route::get('order/{order}' , [OrderController::class , 'show'])->name('order.show');
    Route::post('order' , [OrderController::class , 'store'])->name('order.store');


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


    Route::get('/admin/proyek', [ProyekController::class, 'admin'])->name('admin.proyek');
    Route::get('/admin/laporan', [LaporanController::class, 'admin'])->name('admin.laporan');
});

Route::middleware(['auth' , 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');
    Route::get('/teacher/konsultation', [ChatMessageController::class, 'teacher'])->name('teacher.konsultation');
    Route::get('/teacher/konsultation/{id}/chat', [ChatMessageController::class, 'showConversation'])->name('teacher.konsultation.chat');


});

Route::middleware(['auth' , 'role:student'])->group(function () {
    Route::get('/student/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');
});

Route::middleware(['auth' , 'role:customer'])->group(function () {
    Route::get('/customer/katalog' , [KatalogController::class , 'index'])->name('customer.katalog');
    Route::get('/customer/dashboard', [DashboardController::class, 'customer'])->name('customer.dashboard');
    Route::get('/customer/katalog/{id}/service' , [KatalogController::class , 'showService'])->name('customer.katalog.detail-service');
    Route::get('/customer/katalog/{id}/product' , [KatalogController::class , 'showProduct'])->name('customer.katalog.detail-product');
    Route::get('/customer/konsultation' , [ChatMessageController::class , 'customer'])->name('customer.konsultation');
    Route::get('/customer/konsultation/start/{teacher}', [ChatMessageController::class, 'startConsultation'])->name('customer.konsultation.start');
    Route::get('/customer/konsultation/{id}/chat', [ChatMessageController::class, 'showConversation'])->name('customer.konsultation.chat');
    Route::get('/customer/konsultation/create' , [ConsultationController::class  , 'create'])->name('customer.consultation.create');
    Route::post('/customer/konsultation' , [ConsultationController::class  , 'store'])->name('customer.consultation.store');

    Route::post('/quotations/{quotation}/approve', [OrderController::class, 'approve'])
    ->name('quotations.approve');

    Route::delete('/order/{order}', [OrderController::class, 'destroy'])->name('order.delete');
});

Route::middleware(['auth' , 'role:supplier'])->group(function () {
    Route::get('/supplier/dashboard', [DashboardController::class, 'supplier'])->name('supplier.dashboard');
});


