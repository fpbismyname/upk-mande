<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\Messages;
use App\Models\CicilanPinjaman as ModelsCicilanPinjaman;
use App\Models\Grup;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CicilanPinjaman extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $title = 'Data Transaksi Cicilan Pinjaman';
    public $currentPaginate;
    public static $routeName = 'transaksi-cicilan-pinjaman';
    public $formConfig;
    public $relation = ['grup', 'status'];

    public function __construct()
    {
        $this->currentPaginate = GeneralHelper::$pagination;
        $this->formConfig = [
            [
                'label' => 'Nominal Cicilan',
                'name' => 'nominal_cicilan',
                'type' => 'number'
            ],
            [
                'label' => 'Jatuh Tempo',
                'name' => 'jatuh_tempo',
                'type' => 'datetime-local',
            ],
            [
                'label' => 'Status Cicilan',
                'name' => 'status_id',
                'type' => 'select',
                'option' => Status::where('type_status', 'cicilan_pinjaman')->pluck('nama_status', 'id')
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
        $routeName = CicilanPinjaman::$routeName;
        $include = ['grup', 'nama_grup', 'status', 'nama_status', 'nominal_cicilan', 'jatuh_tempo'];
        $placeholder = "Cari data cicilan...";
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
        if ($query) {
            $datas = ModelsCicilanPinjaman::where(function ($qr) use ($query) {
                $qr->where('nominal_cicilan', 'like', "%{$query}%")
                    ->orWhereRaw("DATE_FORMAT(jatuh_tempo, '%Y-%m-%d') LIKE ?", ["%{$query}%"])
                    ->orWhereHas('status', function ($q) use ($query) {
                        $q->where('nama_status', 'like', "%{$query}%");
                    })
                    ->orWhereHas('grup', function ($q) use ($query) {
                        $q->where('nama_grup', 'like', "%{$query}%");
                    });
            })->with($this->relation)->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        } else {
            $datas = ModelsCicilanPinjaman::with($this->relation)->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah $this->title";
        $routeName = CicilanPinjaman::$routeName;
        $formConfig = $this->formConfig;

        return view('components.admin.crud.add', compact('title', 'formConfig', 'routeName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = $request->validate([
            'nominal_cicilan' => 'required | numeric | digits_between:1,15',
            'jatuh_tempo' => 'required',
            'status_id' => 'required',
            'grup_id' => 'required',
        ]);

        $record['id'] = (string)Str::uuid();

        $storingData = ModelsCicilanPinjaman::create($record);

        if ($storingData) {
            return redirect()->route(CicilanPinjaman::$routeName . '.index')->with(Messages::$collection['store']['success']);
        }
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
        $routeName = CicilanPinjaman::$routeName;
        $routeSubmit =  "$routeName.update";
        $formConfig = $this->formConfig;
        $datas = ModelsCicilanPinjaman::with($this->relation)->find($id);
        return view('components.admin.crud.edit', compact('title', 'routeName', 'datas', 'formConfig', 'routeSubmit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = ModelsCicilanPinjaman::findOrFail($id);

        if (!$record) {
            return redirect()->back()->with(Messages::$collection['update']['notFound']);
        }

        $datas = $request->validate([
            'nominal_cicilan' => 'required | numeric | digits_between:1,15',
            'jatuh_tempo' => 'required',
            'status_id' => 'required',
            'grup_id' => 'required',
        ]);
        $updatingData = $record->update($datas);

        if ($updatingData) {
            return redirect()->route(CicilanPinjaman::$routeName . '.index')->with(Messages::$collection['update']['success']);
        }

        return redirect()->route(CicilanPinjaman::$routeName . '.index')->with(Messages::$collection['update']['failed']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
