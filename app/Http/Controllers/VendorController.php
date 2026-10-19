<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    // Tampilkan data vendor dari database view vendor_vu
    public function index()
    {
        $vendor = DB::select('SELECT * FROM vendor_vu');
        return view('admin.vendor', ['vendor' => $vendor]);
    }
}
