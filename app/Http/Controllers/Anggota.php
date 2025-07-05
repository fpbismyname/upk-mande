<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\Messages;
use App\Models\Anggota as ModelsAnggota;
use App\Models\Grup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Anggota extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $title = 'Data Grup';
    public $currentPaginate;
    public static $routeName = 'data-anggota-grup';
    public $formConfig;
    public $relation = ['grup'];

    public function __construct()
    {
        $this->currentPaginate = GeneralHelper::$pagination;
        $this->formConfig = [
            [
                'label' => 'Nomor NIK',
                'name' => 'nik',
                'type' => 'text'
            ],
            [
                'label' => 'Nama Lengkap',
                'name' => 'nama_lengkap',
                'type' => 'text'
            ],
            [
                'label' => 'Alamat Rumah',
                'name' => 'alamat',
                'type' => 'text'
            ],
            [
                'label' => 'Kelompok Grup',
                'name' => 'grup_id',
                'type' => 'select',
                'option' => Grup::pluck('nama_grup', 'id')->toArray()
            ],
        ];
    }
    public function index()
    {
        $title = $this->title;
        $routeName = Anggota::$routeName;
        $include = ['grup', 'nama_grup', 'nik', 'nama_lengkap', 'alamat'];
        $placeholder = "Cari data anggota...";
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
        if ($query) {
            $datas = ModelsAnggota::where(function ($qr) use ($query) {
                $qr->where('nik', 'like', "%{$query}%")
                    ->orWhere('nama_lengkap', 'like', "%{$query}%")
                    ->orWhere('alamat', 'like', "%{$query}%")
                    ->orWhereHas('grup', function ($q) use ($query) {
                        $q->where('nama_grup', 'like', "%{$query}%");
                    });
            })->with($this->relation)->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        } else {
            $datas = ModelsAnggota::with($this->relation)->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah $this->title";
        $routeName = Anggota::$routeName;
        $formConfig = $this->formConfig;

        return view('components.admin.crud.add', compact('title', 'formConfig', 'routeName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = $request->validate([
            'nik' => 'required|numeric|digits_between:1,20|unique:anggota,nik',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'grup_id' => 'required',
        ]);

        $record['id'] = (string)Str::uuid();

        $storingData = ModelsAnggota::create($record);

        if ($storingData) {
            return redirect()->route(Anggota::$routeName . '.index')->with(Messages::$collection['store']['success']);
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
        $routeName = Anggota::$routeName;
        $routeSubmit =  "$routeName.update";
        $formConfig = $this->formConfig;
        $datas = ModelsAnggota::with($this->relation)->find($id);
        return view('components.admin.crud.edit', compact('title', 'routeName', 'datas', 'formConfig', 'routeSubmit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = ModelsAnggota::findOrFail($id);

        if (!$record) {
            return redirect()->back()->with(Messages::$collection['update']['notFound']);
        }

        $datas = $request->validate([
            'nik' => 'required|numeric|digits_between:1,20',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'grup_id' => 'required',
        ]);
        $updatingData = $record->update($datas);

        if ($updatingData) {
            return redirect()->route(Anggota::$routeName . '.index')->with(Messages::$collection['update']['success']);
        }

        return redirect()->route(Anggota::$routeName . '.index')->with(Messages::$collection['update']['failed']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grup = ModelsAnggota::findOrFail($id);

        if (!$grup) {
            return redirect()->back()->with(Messages::$collection['delete']['notFound']);
        }

        $deletingData = $grup->delete();

        if ($deletingData) {
            return redirect()->route(Anggota::$routeName . '.index')->with(Messages::$collection['delete']['success']);
        }
        return redirect()->route(Anggota::$routeName . '.index')->with(Messages::$collection['delete']['failed']);
    }
}
