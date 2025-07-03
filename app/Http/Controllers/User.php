<?php

namespace App\Http\Controllers;

use App\Helpers\Messages;
use App\Models\RoleUser;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $title = 'Data Akun';
    public $currentPaginate = 10;
    public static $routeName = 'data-user';
    public $formConfig;

    public function __construct()
    {
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
                'label' => 'Alamat Email',
                'name' => 'email',
                'type' => 'email'
            ],
            [
                'label' => 'Password',
                'name' => 'password',
                'type' => 'password'
            ],
            [
                'label' => 'Role',
                'name' => 'role_id',
                'type' => 'select',
                'option' => RoleUser::pluck('nama_role', 'id')->toArray()
            ],
        ];
    }
    public function index()
    {
        $title = $this->title;
        $routeName = User::$routeName;
        $exclude = ['role_id', 'id', 'password'];
        $placeholder = "Cari data akun...";
        $query = request()->query('search');
        $paginate = $this->currentPaginate;
        if ($query) {
            $datas = ModelsUser::where(function ($qr) use ($query) {
                $qr->where('nama_lengkap', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhereHas('role_user', function ($q) use ($query) {
                        $q->where('nama_role', 'like', "%{$query}%");
                    });
            })->with('role_user')->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'exclude', 'placeholder', 'routeName'));
        } else {
            $datas = ModelsUser::with('role_user')->paginate($paginate)->withQueryString();
            return view('components.admin.dashboard', compact('datas', 'title', 'exclude', 'placeholder', 'routeName'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Tambah $this->title";
        $routeSubmit = User::$routeName . ".store";
        $formConfig = $this->formConfig;

        return view('components.admin.crud.add', compact('title', 'formConfig', 'routeSubmit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $creds = $request->validate([
            'nik' => 'required|numeric|digits_between:1,20',
            'nama_lengkap' => 'required | unique:users,nama_lengkap',
            'email' => 'required | email | unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        $creds['id'] = (string)Str::uuid();
        $creds['password'] = Hash::make($creds['password']);

        $storingData = ModelsUser::create($creds);

        if ($storingData) {
            return redirect()->route(User::$routeName . '.index')->with(Messages::$collection['store']['success']);
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
        $routeName = User::$routeName;
        $routeSubmit =  "$routeName.update";
        $formConfig = $this->formConfig;
        $datas = ModelsUser::with('role_user')->find($id);
        return view('components.admin.crud.edit', compact('title', 'routeName', 'datas', 'formConfig', 'routeSubmit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = ModelsUser::findOrFail($id);

        if (!$user) {
            return redirect()->back()->with(Messages::$collection['update']['notFound']);
        }

        $creds = $request->validate([
            'nik' => 'required|numeric|digits_between:1,20',
            'nama_lengkap' => 'required',
            'email' => 'required | email',
            'role_id' => 'required',
            'password' => '',
            'reset-password' => ''
        ]);
        if ($request->filled('password') && $request->filled('reset-password')) {
            $creds['password'] = Hash::make($creds['password']);
            unset($creds['reset-password']);
        } elseif (!$request->filled('reset-password') || !$request->filled('password')) {
            unset($creds['password']);
            unset($creds['reset-password']);
        }
        $updatingData = $user->update($creds);
        if ($updatingData) {
            return redirect()->route(User::$routeName . '.index')->with(Messages::$collection['update']['success']);
        }
        return redirect()->route(User::$routeName . '.index')->with(Messages::$collection['update']['failed']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = ModelsUser::findOrFail($id);
        $users = ModelsUser::with('role_user')->count();

        if ($users <= 1) {
            return redirect()->back()->with(Messages::$collection['delete']['onSession']);
        }

        if (!$user) {
            return redirect()->back()->with(Messages::$collection['delete']['notFound']);
        }

        $deletingData = $user->delete();

        if ($deletingData) {
            return redirect()->route(User::$routeName . '.index')->with(Messages::$collection['delete']['success']);
        }
        return redirect()->route(User::$routeName . '.index')->with(Messages::$collection['delete']['failed']);
    }
}
