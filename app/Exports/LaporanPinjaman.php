<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Grup;

class LaporanPinjaman implements FromView
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
        $include = ['nama_grup', 'limit_pinjaman', 'status', 'status_id', 'nama_status',  'nama_status', 'nama_lengkap', 'pinjaman', 'pinjaman_count', 'pinjaman_sum_nominal_pinjaman'];
        if ($query) {
            $datas = Grup::where(function ($qr) use ($query) {
                $qr->where('nama_grup', 'like', "%{$query}%")
                    ->orWhere('limit_pinjaman', 'like', "%{$query}%")
                    ->orWhereHas('status', function ($q) use ($query) {
                        $q->where('nama_status', 'like', "%{$query}%");
                    })
                    ->orWhereHas('users', function ($q) use ($query) {
                        $q->where('nama_lengkap', 'like', "%{$query}%");
                    });
            })->with($this->relation)->withCount($this->relationCount)->withSum($this->relationCount, 'nominal_pinjaman')->get();
            return view('components.admin.print.laporan-rekapan-pinjaman', compact('datas', 'include'));
        } else {
            $datas = Grup::with($this->relation)->withCount($this->relationCount)->withSum($this->relationCount, 'nominal_pinjaman')->get();
            return view('components.admin.print.laporan-rekapan-pinjaman', compact('datas', 'include'));
        }
    }
}
