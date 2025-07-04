<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    public $routeName = '';

    public function index()
    {
        $title = "Dashboard";
        $datas = User::count();
        $routeName = $this->routeName;
        return view('components.admin.dashboard', compact('title', 'datas', 'routeName'));
    }
}
