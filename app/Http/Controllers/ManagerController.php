<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    // simpan pengadaan baru ke vendor
    public function simpanPengadaan(Request $request)
    {
        $request->validate([
            'vendor_idvendor' => 'required',
            'idbarang'        => 'required',
            'jumlah'          => 'required|numeric|min:1',
            'harga_satuan'    => 'required|numeric|min:0',
        ]);

        $subtotal = (int) $request->input('jumlah') * (int) $request->input('harga_satuan');
        $ppn   = (int) round($subtotal * 0.11);
        $total = $subtotal + $ppn;

        // simpan header pengadaan
        DB::insert(
            'INSERT INTO pengadaan (user_iduser, status, vendor_idvendor, subtotal_nilai, ppn, total_nilai, timestamp) 
             VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)',
            [session('iduser', 4), 'P', $request->input('vendor_idvendor'), $subtotal, $ppn, $total]
        );

        $idPengadaan = DB::getPdo()->lastInsertId();

        // simpan detail pengadaan
        DB::insert(
            'INSERT INTO detail_pengadaan (idpengadaan, idbarang, harga_satuan, jumlah, sub_total) 
             VALUES (?, ?, ?, ?, ?)',
            [$idPengadaan, $request->input('idbarang'), $request->input('harga_satuan'), $request->input('jumlah'), $subtotal]
        );

        return redirect()->route('manager.pengadaan')->with('sukses', 'Pesanan pengadaan #' . $idPengadaan . ' ke vendor berhasil dibuat!');
    }
}
