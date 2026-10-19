<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    // Tampilkan data barang dari database view barang_vu
    public function index()
    {
        $barang = DB::select('SELECT * FROM barang_vu');
        return view('admin.barang', ['barang' => $barang]);
    }
}
