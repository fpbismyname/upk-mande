<?php

namespace App\Http\Controllers;

use App\Models\Grup as ModelsGrup;
use Illuminate\Http\Request;

class Grup extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $title = 'Data Grup';
    public $exclude = [''];
    public function index()
    {
        $title = $this->title;
        $exclude = $this->exclude;
        $placeholder = "Cari nama grup...";
        $query = request()->query('search');
        if ($query) {
            $datas = ModelsGrup::with(['anggota', 'pinjaman', 'cicilan_pinjaman'])->whereLike('nama_grup', "%$query%")->get();
            return view('components.admin.dashboard', compact('datas', 'title', 'exclude', 'placeholder'));
        } else {
            $datas = ModelsGrup::with(['anggota', 'pinjaman', 'cicilan_pinjaman'])->get();
            return view('components.admin.dashboard', compact('datas', 'title', 'exclude', 'placeholder'));
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
