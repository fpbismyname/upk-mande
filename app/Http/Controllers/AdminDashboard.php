<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Grup;
use App\Models\Pinjaman;
use App\Models\User;

class AdminDashboard extends Controller
{
    public $routeName = 'admin';

    public function index()
    {
        $title = "Dashboard";
        $datas = [
            'jumlah_akun_pengguna' => ['icon' => 'users', 'value' => User::count()],
            'grup_peminjam_yang_aktif' => ['icon' => 'user-round-check', 'value' => Grup::join('status', 'grup.status_id', '=', 'status.id')->where('nama_status', '=', 'aktif')->select('grup.*')->count()],
            'grup_peminjam_yang_tidak_aktif' => ['icon' => 'user-round-minus', 'value' => Grup::join('status', 'grup.status_id', '=', 'status.id')->where('nama_status', '=', 'non-aktif')->select('grup.*')->count()],
            'grup_peminjam_yang_diblokir' => ['icon' => 'user-round-x', 'value' => Grup::join('status', 'grup.status_id', '=', 'status.id')->where('nama_status', '=', 'diblokir')->select('grup.*')->count()],
            'jumlah_anggota_grup' => ['icon' => 'user-round', 'value' => Anggota::join('grup', 'anggota.grup_id', '=', 'grup.id')
                ->join('status', 'grup.status_id', '=', 'status.id')
                ->where('status.nama_status', 'aktif')
                ->count()],
            'jumlah_pinjaman_lunas' => ['icon' => 'badge-check', 'value' => Pinjaman::join('status', 'pinjaman.status_id', '=', 'status.id')->where('nama_status', '=', 'sudah_lunas')->select('pinjaman.*')->count()],
            'jumlah_pinjaman_belum_lunas' => ['icon' => 'badge-x', 'value' => Pinjaman::join('status', 'pinjaman.status_id', '=', 'status.id')->where('nama_status', '=', 'belum_lunas')->select('pinjaman.*')->count()],
        ];
        $routeName = $this->routeName;
        return view('components.admin.dashboard', compact('title', 'datas', 'routeName'));
    }
}
