<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\Messages;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NamaStatus extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $title = 'Pengaturan Nama Status';
    public $currentPaginate;
    public static $routeName = 'pengaturan-nama-status';
    public $formConfig;

    public function __construct()
    {
        $this->currentPaginate = GeneralHelper::$pagination;
        $this->formConfig = [
            [
                'label' => 'Nama Status',
                'name' => 'nama_status',
                'type' => 'text'
            ],
            [
                'label' => 'Status Untuk',
                'name' => 'type_status',
                'type' => 'select',
                'option' => [
                    'pinjaman' => 'pinjaman',
                    'cicilan_pinjaman' => 'cicilan_pinjaman',
                    'grup' => 'grup',
                ]
            ],
        ];
    }
    public function index()
    {
        $title = $this->title;
        $routeName = NamaStatus::$routeName;
        $include = ['nama_status', 'type_status'];
        $placeholder = "Cari data nama status...";
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
        if ($query) {
            $datas = Status::where(function ($qr) use ($query) {
                $qr->where('nama_status', 'like', "%{$query}%")->orWhere('type_status', 'like', "%{$query}%");
            })->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        } else {
            $datas = Status::paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah $this->title";
        $routeName = NamaStatus::$routeName;
        $formConfig = $this->formConfig;

        return view('components.admin.crud.add', compact('title', 'formConfig', 'routeName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = $request->validate([
            'nama_status' => 'required | unique:status,nama_status',
            'type_status' => 'required ',
        ]);

        $record['id'] = (string)Str::uuid();
        $record['nama_status'] = GeneralHelper::SnakeCase($record['nama_status']);

        $storingData = Status::create($record);

        if ($storingData) {
            return redirect()->route(NamaStatus::$routeName . '.index')->with(Messages::$collection['store']['success']);
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
        $routeName = NamaStatus::$routeName;
        $routeSubmit =  "$routeName.update";
        $formConfig = $this->formConfig;
        $datas = Status::find($id);
        return view('components.admin.crud.edit', compact('title', 'routeName', 'datas', 'formConfig', 'routeSubmit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Status::findOrFail($id);

        if (!$record) {
            return redirect()->back()->with(Messages::$collection['update']['notFound']);
        }

        $datas = $request->validate([
            'nama_status' => 'required | unique:status,nama_status',
            'type_status' => 'required ',
        ]);

        $datas['nama_status'] = GeneralHelper::SnakeCase($datas['nama_status']);

        $updatingData = $record->update($datas);

        if ($updatingData) {
            return redirect()->route(NamaStatus::$routeName . '.index')->with(Messages::$collection['update']['success']);
        }

        return redirect()->route(NamaStatus::$routeName . '.index')->with(Messages::$collection['update']['failed']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Status::findOrFail($id);

        if (!$record) {
            return redirect()->back()->with(Messages::$collection['delete']['notFound']);
        }

        $deletingData = $record->delete();

        if ($deletingData) {
            return redirect()->route(NamaStatus::$routeName . '.index')->with(Messages::$collection['delete']['success']);
        }
        return redirect()->route(NamaStatus::$routeName . '.index')->with(Messages::$collection['delete']['failed']);
    }
}
