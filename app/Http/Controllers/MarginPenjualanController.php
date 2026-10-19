<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MarginPenjualanController extends Controller
{
    // Tampilkan data margin penjualan dari database view margin_penjualan_vu
    public function index()
    {
        $margins = DB::select('SELECT * FROM margin_penjualan_vu');
        return view('admin.margin', ['margins' => $margins]);
    }
}
