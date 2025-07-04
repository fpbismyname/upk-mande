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
            $datas = CicilanPinjaman::select('*')
                ->selectRaw(
                    "
        CASE
            WHEN DATEDIFF(CURDATE(), jatuh_tempo) > 0 THEN CONCAT(DATEDIFF(CURDATE(), jatuh_tempo), ' hari')
            ELSE 'Tidak telat'
        END as telat_bayar
    ",
                )
                ->where(function ($qr) use ($query) {
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
            $datas = $datas = CicilanPinjaman::select('*')
                ->selectRaw(
                    "
        CASE
            WHEN DATEDIFF(CURDATE(), jatuh_tempo) > 0 THEN CONCAT(DATEDIFF(CURDATE(), jatuh_tempo), ' hari')
            ELSE 'Tidak telat'
        END as telat_bayar
    ",
                )
                ->get();
            return view('components.admin.print.laporan-riwayat-cicilan', compact('datas'));
        }
    }
}
