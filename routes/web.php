<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\KomikController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthorMiddleware;
use Illuminate\Auth\Middleware\AdminAuthor;
use PharIo\Manifest\Author;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['admin'])->group(function () {
    Route::get('search', [AdminController::class, 'search'])->name('admin.search');
    Route::get('dashboard', function () {
        return view('admin.sb-admin');
    });
});

Route::middleware(['authorMiddleware'])->group(function() {
    Route::resource('author',AuthorController::class);
    Route::get('halaman_tambahkomik', [AuthorController::class, 'halaman_tambahkomik'])->name('author.halaman_tambahkomik');


    Route::post('tambahkomik', [AuthorController::class, 'tambahkomik'])->name('author.tambahkomik');

    Route::post('tambahvolume', [AuthorController::class, 'tambahvolume'])->name('author.tambahvolume');

    Route::get('halaman_tambahvol2/{komik_id}', [AuthorController::class, 'halaman_tambahvol2'])->name('author.halaman_tambahvol2');

    Route::post('tambahvolumeauthor', [AuthorController::class, 'tambahvolumeauthor'])->name('author.tambahvolumeauthor');

    Route::get('halaman_tambahvolume', [AuthorController::class, 'halaman_tambahvolume'])->name('author.halaman_tambahvolume');

   
});




Route::middleware(['AuthorAdmin'])->group(function(){
    Route::resource('komik',KomikController::class);
    Route::resource('admin', AdminController::class)->names([
        'index' => 'admin.tables',
    ]);
});

Auth::routes();

Route::delete('author_hapusvolume/{id}', [AuthorController::class, 'author_hapusvolume'])->name('author.author_hapusvolume');
Route::get('halaman_editvolume/{id}', [AuthorController::class, 'halaman_editvolume'])->name('author.halaman_editvolume');
Route::put('author_updatevolume/{id}', [AuthorController::class, 'author_updatevolume'])->name('author.author_updatevolume');

Route::get('editvolume/{id}', [KomikController::class, 'editvolume'])->name('komik.editvolume');
Route::put('updatevolume/{id}', [KomikController::class, 'updatevolume'])->name('komik.updatevolume');

Route::get('halaman_datavolume', [AuthorController::class, 'halaman_datavolume'])->name('author.halaman_datavolume');

Route::get('carikomikauthor', [AuthorController::class, 'carikomikauthor'])->name('carikomikauthor');

Route::get('carikomikadmin', [KomikController::class, 'carikomikadmin'])->name('carikomikadmin');

Route::get('pdf', [AdminController::class, 'generatePDF'])->name('admin.pdf');

Route::delete('hapusvolume/{id}', [KomikController::class, 'hapusvolume'])->name('komik.hapusvolume');

Route::get('datavolume', [KomikController::class, 'datavolume'])->name('komik.datavolume');

Route::get('bagiankomik', [KomikController::class, 'bagiankomik'])->name('komik.bagiankomik');

Route::post('input_bagiankomik', [KomikController::class, 'input_bagiankomik'])->name('komik.input_bagiankomik');

Route::get('bagianvolume', [KomikController::class, 'bagianvolume'])->name('komik.bagianvolume');

Route::post('bagian_volume_gambar', [KomikController::class, 'bagian_volume_gambar'])->name('komik.bagian_volume_gambar');

Route::get('/home', [KomikController::class, 'home'])->name('home');




Route::get('/detaillengkap/{id}', [KomikController::class, 'detaillengkap'])->name('detaillengkap');

Route::get('/bacakomik/{id}/{volume}', [KomikController::class, 'bacakomik'])->name('bacakomik');

Route::get('/listbaca_admin/{id}/{volume}', [KomikController::class, 'listbaca_admin'])->name('listbaca_admin');

Route::get('/listbaca_author/{id}/{volume}', [AuthorController::class, 'listbaca_author'])->name('listbaca_author');

Route::get('/simpankomik', [KomikController::class, 'halaman_simpankomik'])->name('simpankomik');

Route::get('/semuabuku', [KomikController::class, 'semuabuku'])->name('semuabuku');

Route::get('/tambahvolume/{komik_id}', [KomikController::class, 'halamantambahvolume'])->name('komik.tambahvolume');

Route::post('input_tambahvolume', [KomikController::class, 'input_tambahvolume'])->name('komik.input_tambahvolume');

Route::post('input_tambahgambar', [KomikController::class, 'input_tambahgambar'])->name('komik.input_tambahgambar');

Route::get('tambahgambar', [KomikController::class, 'halamantambahgambar'])->name('komik.tambahgambar');

Route::post('input_simpankomik', [KomikController::class, 'input_simpankomik'])->name('komik.input_simpankomik');

Route::get('/hasilcarikomik', [KomikController::class, 'hasilCariKomik'])->name('hasilcarikomik');

Route::post('/logika_komentar', [KomikController::class, 'logika_komentar'])->name('logika_komentar');

Route::match(['post', 'delete'], '/hapuskomentar/{id}', [KomikController::class, 'hapuskomentar'])->name('hapuskomentar');

Route::get('/delete_simpankomik/{id}', [KomikController::class, 'delete_simpankomik'])->name('delete_simpankomik');

Route::get('/komik-to-pdf', [KomikController::class, 'komikToPdf'])->name('komik.komik_pdf');

Route::get('/comic-to-pdf', [AuthorController::class, 'comicToPdf'])->name('author.comic_pdf');




