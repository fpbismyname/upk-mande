<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $title = 'Data Akun';
    public $exclude = ['role_id', 'id'];

    public function index()
    {
        $title = $this->title;
        $exclude = $this->exclude;
        $placeholder = "Cari nama akun...";
        $query = request()->query('search');
        if ($query) {
            $datas = ModelsUser::with('role_user')->where('nama_lengkap', 'like', '%' . $query . '%')->get();
            return view('components.admin.dashboard', compact('datas', 'title', 'exclude', 'placeholder'));
        } else {
            $datas = ModelsUser::with('role_user')->get();
            return view('components.admin.dashboard', compact('datas', 'title', 'exclude', 'placeholder'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah " . $this->title;
        return view('components.admin.crud.add', compact('title'));
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
        $title = "Edit " . $this->title;
        return view('components.admin.crud.edit', compact('title'));
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
