<?php

namespace App\Http\Controllers;

use App\Models\CicilanPinjaman;
use Illuminate\Http\Request;

class RiwayatCicilan extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $title = 'Data Riwayat Cicilan';
    public static $routeName = 'laporan-riwayat-cicilan';
    public $relation = ['grup', 'status'];
    public $currentPaginate = 10;

    public function index()
    {
        $title = $this->title;
        $routeName = RiwayatCicilan::$routeName;
        $include = ['grup', 'nama_grup', 'status', 'nama_status', 'nominal_cicilan', 'jatuh_tempo', 'telat_bayar'];
        $placeholder = 'Cari data rekapan...';
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
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
                ->with($this->relation)
                ->paginate($paginate)
                ->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
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
                ->with($this->relation)
                ->paginate($paginate)
                ->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
