<?php

namespace App\Http\Controllers;

use App\Helpers\Messages;
use App\Models\Grup;
use App\Models\HistoriPendanaan;
use App\Models\Pendanaan;
use App\Models\Pinjaman as ModelsPinjaman;
use App\Models\Status;
use App\Models\SukuBunga;
use App\Models\Tenor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Pinjaman extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $title = 'Data Transaksi pinjaman';
    public $currentPaginate = 10;
    public static $routeName = 'transaksi-pinjaman';
    public $formConfig;
    public $relation = ['grup', 'status', 'tenor', 'suku_bunga'];

    public function __construct()
    {
        $this->formConfig = [
            [
                'label' => 'Nominal Pinjaman',
                'name' => 'nominal_pinjaman',
                'type' => 'number'
            ],
            [
                'label' => 'Tenor',
                'name' => 'tenor',
                'type' => 'select',
                'option' => Tenor::pluck('nama_tenor', 'id')
            ],
            [
                'label' => 'Suku Bunga Flat',
                'name' => 'suku_bunga',
                'type' => 'select',
                'option' => SukuBunga::pluck('jumlah_suku_bunga', 'id')

            ],
            [
                'label' => 'Jadwal Pencairan',
                'name' => 'jadwal_pencairan',
                'type' => 'datetime-local',
            ],
            [
                'label' => 'Jumlah Pinjaman',
                'name' => 'jumlah_pinjaman',
                'type' => 'hidden',

            ],
            [
                'label' => 'Status Pinjaman',
                'name' => 'status_id',
                'type' => 'select',
                'option' => Status::where('type_status', 'pinjaman')->pluck('nama_status', 'id')
            ],
            [
                'label' => 'Grup Pinjaman',
                'name' => 'grup_id',
                'type' => 'select',
                'option' => Grup::pluck('nama_grup', 'id')
            ],
        ];
    }
    public function index()
    {
        $title = $this->title;
        $routeName = Pinjaman::$routeName;
        $include = ['grup', 'nama_grup', 'nominal_pinjaman', 'jumlah_pinjaman', 'jadwal_pencairan', 'tenor', 'nama_tenor', 'status', 'nama_status', 'suku_bunga', 'jumlah_suku_bunga'];
        $placeholder = "Cari data pinjaman...";
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
        if ($query) {
            $datas = ModelsPinjaman::where(function ($qr) use ($query) {
                $qr->where('nominal_pinjaman', 'like', "%{$query}%")
                    ->orWhereRaw("DATE_FORMAT(jadwal_pencairan, '%Y-%m-%d') LIKE ?", ["%{$query}%"])
                    ->orWhereHas('status', function ($q) use ($query) {
                        $q->where('nama_status', 'like', "%{$query}%");
                    })
                    ->orWhereHas('grup', function ($q) use ($query) {
                        $q->where('nama_grup', 'like', "%{$query}%");
                    })
                    ->orWhereHas('suku_bunga', function ($q) use ($query) {
                        $q->where('jumlah_suku_bunga', 'like', "%{$query}%");
                    })
                    ->orWhereHas('tenor', function ($q) use ($query) {
                        $q->where('nama_tenor', 'like', "%{$query}%");
                    });
            })->with($this->relation)->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        } else {
            $datas = ModelsPinjaman::with($this->relation)->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah $this->title";
        $routeName = Pinjaman::$routeName;
        $formConfig = $this->formConfig;

        return view('components.admin.crud.add', compact('title', 'formConfig', 'routeName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = $request->validate([
            'nominal_pinjaman' => 'required | numeric | digits_between:1,15',
            'suku_bunga' => 'required',
            'jadwal_pencairan' => 'required',
            'tenor' => 'required',
            'status_id' => 'required',
            'grup_id' => 'required',
        ]);

        // set uuid
        $record['id'] = (string)Str::uuid();
        // Ambil data nominal, tenor, dan sukubunga
        $nominalPinjaman = intval($record['nominal_pinjaman']);
        $tenor = Tenor::where('id', $record['tenor'])->first()->toArray()['waktu_tenor'];
        $sukuBunga = SukuBunga::where('id', $record['suku_bunga'])->first()->toArray()['jumlah_suku_bunga'];

        // Cek saldo pendanaan
        $Pendanaan = Pendanaan::get()->first();
        $saldoPendanaan = intval($Pendanaan->saldo);
        if ($nominalPinjaman > $saldoPendanaan) {
            return redirect()->route(Pinjaman::$routeName . '.index')->with(Messages::$pendanaan['insuficient-fund']);
        }

        // Kalkulasi Pinjaman + bunga pinjaman
        $tenorPinjaman = intval($tenor) / 12;
        $bungaPinjaman = $sukuBunga / 100;
        $totalBungaPinjaman = $nominalPinjaman * $bungaPinjaman * $tenorPinjaman;

        $record['jumlah_pinjaman'] =  $nominalPinjaman + $totalBungaPinjaman;

        // Store data ke table pinjaman
        $storingData = ModelsPinjaman::create($record);

        if ($storingData) {
            // lalu kasi message
            return redirect()->route(Pinjaman::$routeName . '.index')->with(Messages::$collection['store']['success']);
        }

        // Klo gagal kasi message
        return redirect()->back()->with(Messages::$collection['store']['failed']);
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
        $title = "Edit " . $this->title;
        $routeName = Pinjaman::$routeName;
        $routeSubmit =  "$routeName.update";
        $formConfig = $this->formConfig;
        $datas = ModelsPinjaman::with($this->relation)->find($id);
        return view('components.admin.crud.edit', compact('title', 'routeName', 'datas', 'formConfig', 'routeSubmit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = ModelsPinjaman::findOrFail($id);

        if (!$record) {
            return redirect()->back()->with(Messages::$collection['update']['notFound']);
        }

        $datas = $request->validate([
            'nominal_pinjaman' => 'required | numeric | digits_between:1,15',
            'suku_bunga' => 'required',
            'jadwal_pencairan' => 'required',
            'tenor' => 'required',
            'status_id' => 'required',
            'grup_id' => 'required',
        ]);
        $updatingData = $record->update($datas);

        if ($updatingData) {
            return redirect()->route(Pinjaman::$routeName . '.index')->with(Messages::$collection['update']['success']);
        }

        return redirect()->route(Pinjaman::$routeName . '.index')->with(Messages::$collection['update']['failed']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grup = ModelsPinjaman::findOrFail($id);

        if (!$grup) {
            return redirect()->back()->with(Messages::$collection['delete']['notFound']);
        }

        $deletingData = $grup->delete();

        if ($deletingData) {
            return redirect()->route(Pinjaman::$routeName . '.index')->with(Messages::$collection['delete']['success']);
        }
        return redirect()->route(Pinjaman::$routeName . '.index')->with(Messages::$collection['delete']['failed']);
    }
}
