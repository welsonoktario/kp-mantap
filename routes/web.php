<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::redirect('/', '/login');
Route::redirect('/register', '/login', 302);

Route::get('admin', function () {
    if (Auth::check()) {
        if (Auth::user()->status == 0) {
            Auth::logout();
            return back()->withErrors(['nonaktif', 'Akun belum diaktivasi']);
        }
        return view('admin.index');
    }
    return redirect('/login');
});

Route::get('/laporan', 'LaporanController@load');
Route::get('/laporan/pdf', 'LaporanController@pdf');

/* Route::get('/users', 'UsersController@index');
Route::post('/users', 'UsersController@create'); */

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
    Route::get('user', function() {
        return Auth::user();
    });

    Route::delete('transaksi-kegiatan/{id}', 'KegiatanController@detachTransaksi');
    Route::patch('transaksi-verif/{id}', 'TransaksiController@verifikasi');
    Route::get('transaksi-all', 'TransaksiController@all');
    Route::get('kategori-all', 'KategoriController@all');
    Route::post('transaksi-kegiatan', 'TransaksiController@addAktivitas');
    Route::post('transaksi-pilih', 'TransaksiController@addAktivitasPilih');
    Route::get('transaksi-tanggal', 'TransaksiController@tanggalTransaksi');
    Route::resource('dompet', 'DompetController');
    Route::resource('pegawai', 'PegawaiController');
    Route::resource('kategori', 'KategoriController');
    Route::resource('transaksi', 'TransaksiController');
    Route::resource('aktivitas', 'KegiatanController');
    Route::get('laporan', 'LaporanController@load');
});

Route::get('/admin/pegawai', function () {
    if (Auth::user()->role != 'Kajur') {
        return redirect('admin');
    }
    return view('admin.pegawai.index');
});

Route::get('/admin/transaksi', function () {
    return view('admin.transaksi.index');
});

Route::get('/admin/dompet', function () {
    return view('admin.dompet.index');
});

Route::get('/admin/dompet/{id}', function () {
    return view('admin.dompet.index');
});

Route::get('/admin/kategori', function () {
    return view('admin.kategori.index');
});

Route::get('/admin/kategori/{id}', function () {
    return view('admin.kategori.index');
});

Route::get('/admin/aktivitas', function () {
    return view('admin.aktivitas.index');
});

Route::get('/admin/aktivitas/{id}', function () {
    return view('admin.aktivitas.detail-aktivitas');
});

Route::get('/admin/laporan', function () {
    return view('admin.laporan.index');
});

Route::get('/admin/home', function () {
    return view('admin.index');
});
