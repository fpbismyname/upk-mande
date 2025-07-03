<?php

namespace App\Http\Controllers;

use App\Helpers\Messages;
use App\Models\Pendanaan as ModelsPendanaan;
use Illuminate\Http\Request;

class Pendanaan extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $title = 'Data Pendanaan';
    public $currentPaginate = 10;
    public static $routeName = 'pendanaan';
    public $formConfig;
    public function index()
    {
        $title = $this->title;
        $routeName = Pendanaan::$routeName;
        $include = ['saldo'];
        $placeholder = "Cari data anggota...";
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
        $datas = ModelsPendanaan::paginate($paginate)->withQueryString();
        if ($query) {
            return view('components.admin.dashboard', compact('datas', 'title', 'include', 'placeholder', 'routeName'));
        } else {
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
     * Alias - Tambah dana
     */
    public function store(Request $request)
    {
        $record = $request->validate([
            'new-saldo' => 'required | numeric | digits_between:5,15'
        ]);
        $pendanaan = ModelsPendanaan::get()->first();
        $addSaldo = max(0, $pendanaan->saldo + $record['new-saldo']);
        $pendanaan->saldo = $addSaldo;
        $updatingSaldo = $pendanaan->save();
        if (!$updatingSaldo) return redirect()->back()->with(Messages::$pendanaan['add-failed']);
        return redirect()->back()->with(Messages::$pendanaan['add-success']);
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
     * Alias - Kurangi Saldo
     */
    public function update(Request $request, string $id)
    {
        $record = $request->validate([
            'new-saldo' => 'required | numeric | digits_between:5,15'
        ]);
        $pendanaan = ModelsPendanaan::get()->first();
        $addSaldo = max(0, $pendanaan->saldo - $record['new-saldo']);
        $pendanaan->saldo = $addSaldo;
        $decreasingSaldo = $pendanaan->save();
        if (!$decreasingSaldo) return redirect()->back()->with(Messages::$pendanaan['decrease-failed']);
        return redirect()->back()->with(Messages::$pendanaan['decrease-success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
