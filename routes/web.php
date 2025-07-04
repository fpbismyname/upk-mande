<?php

use App\Exports\LaporanPinjaman;
use App\Exports\RiwayatCicilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    $userId = auth()->user();
    $roleUser = [];
    if ($userId) {
        $roleUser = $userId->load('role_user')->toArray()['role_user']['nama_role'];
    }
    $roleUser = $roleUser === [] ? '' : $roleUser;
    $datas = compact('roleUser');
    return view('pages.welcome', $datas);
});

Route::get('/print-laporan-rekapan-pinjaman', function (Request $req) {
    $search = $req->query('search');
    return Excel::download(new LaporanPinjaman($search), 'laporan-pinjaman.xlsx');
})->name('print.laporan-rekapan-pinjaman');

Route::get('/print-laporan-riwayat-cicilan', function (Request $req) {
    $search = $req->query('search');
    return Excel::download(new RiwayatCicilan($search), 'laporan-riwayat-cicilan.xlsx');
})->name('print.laporan-riwayat-cicilan');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/client.php';
