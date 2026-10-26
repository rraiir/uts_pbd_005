<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
    // Tampilan Dashboard Gudang
    public function dashboard()
    {
        $penerimaanCount = DB::select('SELECT COUNT(*) as c FROM penerimaan')[0]->c ?? 0;
        $returCount      = DB::select('SELECT COUNT(*) as c FROM retur')[0]->c ?? 0;
        $totalStok       = DB::select('SELECT SUM(masuk - keluar) as s FROM kartu_stok')[0]->s ?? 0;

        $barang = DB::select(
            'SELECT b.idbarang, b.nama, s.nama_satuan, b.status,
                    IFNULL((SELECT SUM(k.masuk - k.keluar) FROM kartu_stok k WHERE k.idbarang = b.idbarang), 0) as stok
            FROM barang b 
            JOIN satuan s ON b.idsatuan = s.idsatuan 
            ORDER BY b.idbarang ASC'
        );

        return view('gudang.dashboard', [
            'penerimaanCount' => $penerimaanCount,
            'returCount'      => $returCount,
            'totalStok'       => $totalStok,
            'barang'          => $barang,
        ]);
    }

    // Tampilan Kelola Penerimaan
    public function penerimaan()
    {
        $penerimaan = DB::select(
            'SELECT p.idpenerimaan, p.created_at, p.idpengadaan, v.nama_vendor, u.username, p.status 
            FROM penerimaan p 
            JOIN pengadaan pg ON p.idpengadaan = pg.idpengadaan 
            JOIN vendor v ON pg.vendor_idvendor = v.idvendor 
            JOIN user u ON p.iduser = u.iduser 
            ORDER BY p.idpenerimaan DESC'
        );

        return view('gudang.penerimaan', [
            'penerimaan' => $penerimaan,
        ]);
    }

    // Tampilan Form Terima Barang
    public function terima()
    {
        $pengadaan = DB::select('SELECT idpengadaan, timestamp as created_at, status FROM pengadaan ORDER BY idpengadaan DESC');
        return view('gudang.terima', [
            'pengadaan' => $pengadaan,
        ]);
    }

    // Tampilan Kelola Retur
    public function retur()
    {
        $retur = DB::select(
            'SELECT r.idretur, r.created_at, r.idpenerimaan, u.username 
            FROM retur r 
            JOIN penerimaan p ON r.idpenerimaan = p.idpenerimaan 
            JOIN user u ON r.iduser = u.iduser 
            ORDER BY r.idretur DESC'
        );

        return view('gudang.retur', [
            'retur' => $retur,
        ]);
    }

    // Tampilan Kartu Stok
    public function kartuStok()
    {
        $kartuStok = DB::select(
            'SELECT k.idkartu_stok, k.created_at, b.nama as nama_barang, k.jenis_transaksi, k.masuk, k.keluar, k.stok, k.stok as stok_akhir 
            FROM kartu_stok k 
            JOIN barang b ON k.idbarang = b.idbarang 
            ORDER BY k.idkartu_stok DESC'
        );

        return view('gudang.kartu-stok', [
            'kartuStok' => $kartuStok,
        ]);
    }
}
