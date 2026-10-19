<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Tampilkan data user dari database view user_vu
    public function index()
    {
        $users = DB::select('SELECT * FROM user_vu');
        return view('admin.user', ['users' => $users]);
    }
}
