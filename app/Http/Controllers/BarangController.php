<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    // ambil data barang dari view sekalian hitung harga jual pake function
    public function index()
    {
        $barang = DB::select('SELECT b.*, fn_hitung_harga_jual(b.idbarang) AS harga_jual FROM barang_vu b ORDER BY b.idbarang ASC');
        return view('admin.barang', ['barang' => $barang]);
    }
}
