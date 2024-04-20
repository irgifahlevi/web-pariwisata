<?php

use App\Http\Controllers\Admin\AboutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\ProdukKeluar;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DetailsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GuidesController;
use App\Http\Controllers\Admin\NakesController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\KelolaStaffController;
use App\Http\Controllers\Admin\ProdukMasukController;
use App\Http\Controllers\Admin\PegawaiStaffController;
use App\Http\Controllers\Staff\ProdukKeluarController;
use App\Http\Controllers\Admin\ListProdukKeluarController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Public\PublicController;
use App\Http\Controllers\Public\SuggestionController;
use App\Http\Controllers\Public\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('user_public.index_public');
// });
Route::get('/', [PublicController::class, 'index'])->name('public.index');
Route::get('/destination/{id}/view', [PublicController::class, 'viewDestination'])->name('view.destination');
Route::get('/province/{id}/view', [PublicController::class, 'viewProvince'])->name('view.province');
Route::get('/get_destinations', [DestinationController::class, 'GetDestination'])->name('get.destinations');

Route::resource('/ticket', TicketController::class);
Route::resource('/suggestion', SuggestionController::class);

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    Route::get('beranda', [AdminController::class, 'index'])->name('admin.index');

    // Suggestion
    Route::get('suggestion', [AdminController::class, 'suggestions'])->name('admin.suggestions');
    Route::get('suggestion/{id}/show', [AdminController::class, 'showSugestion'])->name('admin.showSugestion');

    // Ticet
    Route::get('ticket', [AdminController::class, 'tickets'])->name('admin.tickets');
    Route::get('ticket/{id}/show', [AdminController::class, 'showTicket'])->name('admin.showTicket');

    // Slider 
    Route::resource('/slider', SliderController::class);
    //Route::get('kategori_item', [KategoriController::class, 'kategori'])->name('semua.kategori');

    // About
    Route::resource('/about', AboutController::class);

    // Guide
    Route::resource('/guide', GuidesController::class);

    //Province
    Route::resource('/province', ProvinceController::class);
    Route::get('get_province', [ProvinceController::class, 'GetProvince'])->name('get.province');

    //Destination
    Route::resource('/destination', DestinationController::class);
    Route::get('get_destination', [DestinationController::class, 'GetDestination'])->name('get.destination');

    //Gallery
    Route::resource('/gallery', GalleryController::class);
});


Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
});
