<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    // Tampilan Dashboard Manager
    public function dashboard()
    {
        $pengadaanCount = DB::select('SELECT COUNT(*) as c FROM pengadaan')[0]->c ?? 0;
        $vendorCount    = DB::select('SELECT COUNT(*) as c FROM vendor WHERE status = 1')[0]->c ?? 0;
        $totalBelanja   = DB::select('SELECT SUM(total_nilai) as s FROM pengadaan')[0]->s ?? 0;

        $pengadaan = DB::select(
            'SELECT p.idpengadaan, p.timestamp as created_at, v.nama_vendor, p.total_nilai, p.status 
            FROM pengadaan p 
            JOIN vendor v ON p.vendor_idvendor = v.idvendor 
            ORDER BY p.idpengadaan DESC 
            LIMIT 5'
        );

        return view('manager.dashboard', [
            'pengadaanCount' => $pengadaanCount,
            'vendorCount'    => $vendorCount,
            'totalBelanja'   => $totalBelanja,
            'pengadaan'      => $pengadaan,
        ]);
    }

    // Tampilan Kelola Pengadaan
    public function pengadaan()
    {
        $pengadaan = DB::select(
            'SELECT p.idpengadaan, p.timestamp as created_at, v.nama_vendor, p.total_nilai, p.status 
            FROM pengadaan p 
            JOIN vendor v ON p.vendor_idvendor = v.idvendor 
            ORDER BY p.idpengadaan DESC'
        );

        return view('manager.pengadaan', [
            'pengadaan' => $pengadaan,
        ]);
    }

    // Tampilan Form Buat Pengadaan Baru
    public function buatPengadaan()
    {
        $vendors = DB::select('SELECT idvendor, nama_vendor FROM vendor WHERE status = 1');
        $barangs = DB::select('SELECT idbarang, nama, harga FROM barang WHERE status = 1');

        return view('manager.buat-pengadaan', [
            'vendors' => $vendors,
            'barangs' => $barangs,
        ]);
    }
}
