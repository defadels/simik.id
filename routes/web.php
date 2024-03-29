<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\BlogController;
use App\Http\Controllers\pages\CategoryBlogController;
use App\Http\Controllers\pages\UserController;
use App\Http\Controllers\pages\CalonMuridController;
use App\Http\Controllers\pages\SliderController;
use App\Http\Controllers\pages\ProfilWebsiteController;
use App\Http\Controllers\pages\FAQController;
use App\Http\Controllers\pages\TestimoniController;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;

use App\Http\Controllers\front_pages\HomeController;
use App\Http\Controllers\front_pages\PendaftaranController;
use App\Http\Controllers\front_pages\FrontBlogController;


use App\Http\Controllers\guru\DashboardController;
use App\Http\Controllers\guru\GrafikController;
use App\Http\Controllers\guru\LaporanController;

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

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/terima-kasih', [HomeController::class, 'terimaKasih'])->name('home.terima-kasih');
Route::get('/informasi', [HomeController::class, 'informasi'])->name('home.informasi');
Route::get('/daftar', [PendaftaranController::class, 'index'])->name('home.daftar');
Route::post('/daftar', [PendaftaranController::class, 'store'])->name('home.daftar.store');

Route::get('/blog', [FrontBlogController::class, 'index'])->name('home.blog');
Route::get('/blog/{slug}', [FrontBlogController::class, 'show'])->name('home.blog.detail');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->prefix('webmin')->
name('webmin.')->namespace('Dashboard')->group(function () {
    // Main Page Route
    Route::get('/', [HomePage::class, 'index'])->name('pages-home');
    Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

    // locale
    Route::get('lang/{locale}', [LanguageController::class, 'swap']);

    // pages
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

    // authentication
    Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
    Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/tambah', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{blog}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{blog}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{blog}', [BlogController::class, 'destroy'])->name('blog.delete');

    Route::get('/category', [CategoryBlogController::class, 'index'])->name('category');
    Route::get('/category/tambah', [CategoryBlogController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryBlogController::class, 'store'])->name('category.store');
    Route::get('/category/{kategori}', [CategoryBlogController::class, 'edit'])->name('category.edit');
    Route::put('/category/{kategori}', [CategoryBlogController::class, 'update'])->name('category.update');
    Route::delete('/category/{kategori}', [CategoryBlogController::class, 'destroy'])->name('category.delete');

    Route::get('/users', [UserController::class, 'index'])->name('user');
    Route::get('/users/tambah', [UserController::class, 'create'])->name('user.create');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::get('/users/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.delete');

    Route::get('/slider', [SliderController::class, 'index'])->name('slider');
    Route::get('/slider/tambah', [SliderController::class, 'create'])->name('slider.create');
    Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
    Route::get('/slider/{slider}', [SliderController::class, 'edit'])->name('slider.edit');
    Route::put('/slider/{slider}', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/slider/{slider}', [SliderController::class, 'destroy'])->name('slider.delete');

    Route::get('/profil-website', [ProfilWebsiteController::class, 'index'])->name('profil-website');
    Route::get('/profil-website/tambah', [ProfilWebsiteController::class, 'create'])->name('profil-website.create');
    Route::post('/profil-website', [ProfilWebsiteController::class, 'store'])->name('profil-website.store');
    Route::get('/profil-website/{profil}', [ProfilWebsiteController::class, 'edit'])->name('profil-website.edit');
    Route::put('/profil-website/{profil}', [ProfilWebsiteController::class, 'update'])->name('profil-website.update');


    Route::get('/faq', [FAQController::class, 'index'])->name('faq');
    Route::get('/faq/tambah', [FAQController::class, 'create'])->name('faq.create');
    Route::post('/faq', [FAQController::class, 'store'])->name('faq.store');
    Route::get('/faq/{faq}', [FAQController::class, 'edit'])->name('faq.edit');
    Route::put('/faq/{faq}', [FAQController::class, 'update'])->name('faq.update');
    Route::delete('/faq/{faq}', [FAQController::class, 'destroy'])->name('faq.delete');

    Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni');
    Route::get('/testimoni/tambah', [TestimoniController::class, 'create'])->name('testimoni.create');
    Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');
    Route::get('/testimoni/{testimoni}', [TestimoniController::class, 'edit'])->name('testimoni.edit');
    Route::put('/testimoni/{testimoni}', [TestimoniController::class, 'update'])->name('testimoni.update');
    Route::delete('/testimoni/{testimoni}', [TestimoniController::class, 'destroy'])->name('testimoni.delete');


    Route::get('/calon-murid', [CalonMuridController::class, 'index'])->name('calon-murid');
    // Route::get('/calon-murid', [CalonMuridController::class, 'index'])->name('calon-murid');

    Route::get('/daftar-tahap-kedua/{calon_murid}', [CalonMuridController::class, 'daftarTahapKedua'])->name('calon-murid.tahap-kedua');
    Route::get('/lampiran-berkas/{calon_murid}', [CalonMuridController::class, 'lampiranBerkas'])->name('calon-murid.lampiran-berkas');
    Route::put('/daftar-tahap-kedua/{calon_murid}', [CalonMuridController::class, 'update'])->name('calon-murid.tahap-kedua.update');
  });

  Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->prefix('gurunda')->
name('gurunda.')->namespace('guru')->group(function () {
    // Main Page Route
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');  
    Route::get('grafik', [GrafikController::class, 'index'])->name('grafik');   
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan');    
    Route::get('laporan/{id}/lihat', [LaporanController::class, 'lihat'])->name('laporan.lihat');    
    Route::get('laporan/{id}/lihat/{id_murid}/cetak', [LaporanController::class, 'lihat_cetak'])->name('laporan.lihat.cetak');    
    Route::get('laporan/{id}/penilaian', [LaporanController::class, 'penilaian'])->name('laporan.penilaian');    
    Route::get('laporan/{id}/penilaian/{id_penilaian}/rating', [LaporanController::class, 'rating'])->name('laporan.penilaian.rating');    
    Route::post('laporan/{id}/penilaian/{id_penilaian}/rating', [LaporanController::class, 'rating'])->name('laporan.penilaian.rating');   
 
  });

  Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->prefix('dashboard')->
  name('dashboard.')->namespace('Dashboard')->group(function () { 
      // authentication
      Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
      Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
  });

// Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
//   Route::get('/dashboard', function () {
//     return view('terms');
//   })->name('dashboard');
// });
