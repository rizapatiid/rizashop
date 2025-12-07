<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index()
    {
        // bisa kirim data ke view kalau perlu
        return view('admin.dashboard');
    }
}
