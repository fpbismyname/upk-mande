<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\Messages;
use App\Models\SukuBunga as ModelsSukuBunga;
use Illuminate\Http\Request;

class SukuBunga extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $title = 'Pengaturan Suku Bunga';
    public $currentPaginate;
    public static $routeName = 'pengaturan-suku-bunga';
    public $formConfig;

    public function __construct()
    {
        $this->currentPaginate = GeneralHelper::$pagination;
        $this->formConfig = [
            [
                'label' => 'Nilai Suku Bunga',
                'name' => 'jumlah_suku_bunga',
                'type' => 'number'
            ],
        ];
    }
    public function index()
    {
        $title = $this->title;
        $routeName  = SukuBunga::$routeName;
        $include = ['jumlah_suku_bunga'];
        $placeholder = "Cari data suku_bunga...";
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
        if ($query) {
            $datas = ModelsSukuBunga::where(function ($qr) use ($query) {
                $qr->where('jumlah_suku_bunga', 'like', "%{$query}%");
            })->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        } else {
            $datas = ModelsSukuBunga::paginate($paginate)->withQueryString();
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
        $record = $request->validate([
            'jumlah_suku_bunga' => 'required | numeric | digits_between:1,3'
        ]);
        $sukuBunga = ModelsSukuBunga::get()->first();
        $updatingSukuBunga = $sukuBunga->update($record);
        if (!$updatingSukuBunga) return redirect()->back()->with(Messages::$sukuBunga['success']);
        return redirect()->back()->with(Messages::$sukuBunga['success']);
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
