<?php

namespace App\Http\Controllers;

use App\Helpers\Messages;
use App\Models\Grup as ModelsGrup;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Grup extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $title = 'Data Grup';
    public $currentPaginate = 10;
    public static $routeName = 'data-grup';
    public $formConfig;

    public function __construct()
    {
        $this->formConfig = [
            [
                'label' => 'Nama Grup',
                'name' => 'nama_grup',
                'type' => 'text'
            ],
            [
                'label' => 'Limit Pinjaman',
                'name' => 'limit_pinjaman',
                'type' => 'number'
            ],
            [
                'label' => 'Status Grup',
                'name' => 'status_id',
                'type' => 'select',
                'option' => Status::pluck('nama_status', 'id')->toArray()
            ],
            [
                'label' => 'Ketua',
                'name' => 'ketua_user_id',
                'type' => 'select',
                'option' => User::pluck('nama_lengkap', 'id')->toArray()
            ],
        ];
    }
    public function index()
    {
        $title = $this->title;
        $routeName = Grup::$routeName;
        $exclude = [''];
        $placeholder = "Cari data grup...";
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
        if ($query) {
            $datas = ModelsGrup::where(function ($qr) use ($query) {
                $qr->where('nama_grup', 'like', "%{$query}%")
                    ->orWhere('limit_pinjaman', 'like', "%{$query}%")
                    ->orWhereHas('status_id', function ($q) use ($query) {
                        $q->where('nama_status', 'like', "%{$query}%");
                    })
                    ->orWhereHas('ketua_user_id', function ($q) use ($query) {
                        $q->where('nama_lengkap', 'like', "%{$query}%");
                    });
            })->with(['status', 'users'])->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'exclude', 'placeholder', 'routeName'));
        } else {
            $datas = ModelsGrup::with(['status', 'users'])->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'exclude', 'placeholder', 'routeName'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah $this->title";
        $routeSubmit = Grup::$routeName . ".store";
        $formConfig = $this->formConfig;

        return view('components.admin.crud.add', compact('title', 'formConfig', 'routeSubmit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $creds = $request->validate([
            'nama_grup' => 'required',
            'limit_pinjaman' => 'required|numeric|digits_between:1,20',
            'status_id' => 'required',
            'ketua_user_id' => 'required',
        ]);

        $creds['id'] = (string)Str::uuid();

        $storingData = ModelsGrup::create($creds);

        if ($storingData) {
            return redirect()->route(Grup::$routeName . '.index')->with(Messages::$collection['store']['success']);
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
        $grup = ModelsGrup::findOrFail($id);

        if (!$grup) {
            return redirect()->back()->with(Messages::$collection['delete']['notFound']);
        }

        $deletingData = $grup->delete();

        if ($deletingData) {
            return redirect()->route(Grup::$routeName . '.index')->with(Messages::$collection['delete']['success']);
        }
        return redirect()->route(Grup::$routeName . '.index')->with(Messages::$collection['delete']['failed']);
    }
}
