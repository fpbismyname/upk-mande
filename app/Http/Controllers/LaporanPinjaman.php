<?php

namespace App\Http\Controllers;

use App\Models\Grup;
use App\Models\Pinjaman;
use Illuminate\Http\Request;

class LaporanPinjaman extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $title = 'Data Rekapan Pinjaman';
    public $currentPaginate = 10;
    public static $routeName = 'laporan-rekapan-pinjaman';
    public $relation = ['status', 'users'];
    public $relationCount = ['pinjaman'];
    public function index()
    {
        $title = $this->title;
        $routeName = LaporanPinjaman::$routeName;
        $include = ['nama_grup', 'limit_pinjaman', 'status', 'nama_status',  'nama_status', 'nama_lengkap', 'pinjaman', 'pinjaman_count', 'pinjaman_sum_nominal_pinjaman', 'users', 'ketua_users_id'];
        $placeholder = "Cari data rekapan...";
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
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
            })->with($this->relation)->withCount($this->relationCount)->withSum($this->relationCount, 'nominal_pinjaman')->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        } else {
            $datas = Grup::with($this->relation)->withCount($this->relationCount)->withSum($this->relationCount, 'nominal_pinjaman')->paginate($paginate)->withQueryString();
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
