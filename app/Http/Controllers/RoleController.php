<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // Tampilkan data role dari database view role_vu
    public function index()
    {
        $roles = DB::select('SELECT * FROM role_vu');
        return view('admin.role', ['roles' => $roles]);
    }
}
