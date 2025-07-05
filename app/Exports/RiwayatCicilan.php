<?php

namespace App\Exports;

use App\Models\CicilanPinjaman;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RiwayatCicilan implements FromView
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }
    public $relation = ['status', 'users'];
    public $relationCount = ['pinjaman'];

    public function view(): View
    {
        $query = $this->search;
        if ($query) {
            $datas = CicilanPinjaman::join('status', 'cicilan_pinjaman.status_id', '=', 'status.id')
                ->select('cicilan_pinjaman.*') // hanya ambil kolom dari cicilan_pinjaman
                ->selectRaw("
        CASE
            WHEN status.nama_status = 'sudah_dibayar' THEN '-'
            WHEN CURDATE() < jatuh_tempo THEN '-'
            WHEN CURDATE() > jatuh_tempo AND status.nama_status = 'belum_dibayar' THEN CONCAT(DATEDIFF(CURDATE(), jatuh_tempo), ' hari')
            ELSE 'Tidak telat'
        END AS telat_bayar
    ")->where(function ($qr) use ($query) {
                    $qr->where('nominal_cicilan', 'like', "%{$query}%")
                        ->orWhere('jatuh_tempo', 'like', "%{$query}%")
                        ->orWhereHas('status', function ($q) use ($query) {
                            $q->where('nama_status', 'like', "%{$query}%");
                        })
                        ->orWhereHas('grup', function ($q) use ($query) {
                            $q->where('nama_grup', 'like', "%{$query}%");
                        })
                        ->orWhereRaw('DATEDIFF(CURDATE(), jatuh_tempo) like ?', ["%{$query}%"]);
                })
                ->get();
            return view('components.admin.print.laporan-riwayat-cicilan', compact('datas'));
        } else {
            $datas = $datas = CicilanPinjaman::join('status', 'cicilan_pinjaman.status_id', '=', 'status.id')
                ->select('cicilan_pinjaman.*') // hanya ambil kolom dari cicilan_pinjaman
                ->selectRaw("
        CASE
            WHEN status.nama_status = 'sudah_dibayar' THEN '-'
            WHEN CURDATE() < jatuh_tempo THEN '-'
            WHEN CURDATE() > jatuh_tempo AND status.nama_status = 'belum_dibayar' THEN CONCAT(DATEDIFF(CURDATE(), jatuh_tempo), ' hari')
            ELSE 'Tidak telat'
        END AS telat_bayar
    ")
                ->get();
            return view('components.admin.print.laporan-riwayat-cicilan', compact('datas'));
        }
    }
}
