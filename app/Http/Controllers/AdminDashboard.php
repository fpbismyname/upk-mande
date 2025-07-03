<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboard extends Controller
{
    public $exclude = [''];

    public function index()
    {
        $title = "Dashboard";
        $exclude = $this->exclude;
        $datas = User::count();
        $routeName = 'admin';
        return view('components.admin.dashboard', compact('title', 'exclude', 'datas', 'routeName'));
    }
}
