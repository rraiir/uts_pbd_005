<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    // Tampilan Layar Kasir Penjualan
    public function index()
    {
        // ambil data barang, harga jual dari function, sama sisa stok fisik
        $barang = DB::select(
            'SELECT b.idbarang, b.nama, b.harga AS modal, 
                    fn_hitung_harga_jual(b.idbarang) AS harga_jual,
                    IFNULL((SELECT SUM(k.masuk - k.keluar) FROM kartu_stok k WHERE k.idbarang = b.idbarang), 0) AS stok
             FROM barang b 
             WHERE b.status = 1 
             ORDER BY b.idbarang ASC'
        );

        // ambil riwayat penjualan terakhir
        $penjualan = DB::select(
            'SELECT p.idpenjualan, p.created_at, p.subtotal_nilai, p.ppn, p.total_nilai, 
                    u.username, dp.jumlah, b.nama AS nama_barang, dp.harga_satuan 
             FROM penjualan p 
             JOIN user u ON p.iduser = u.iduser 
             LEFT JOIN detail_penjualan dp ON p.idpenjualan = dp.penjualan_idpenjualan 
             LEFT JOIN barang b ON dp.idbarang = b.idbarang 
             ORDER BY p.idpenjualan DESC 
             LIMIT 10'
        );

        // ambil persen margin aktif
        $marginRow = DB::select('SELECT persen FROM margin_penjualan WHERE status = 1 ORDER BY updated_at DESC LIMIT 1');
        $marginAktif = !empty($marginRow) ? $marginRow[0]->persen : 10;

        return view('kasir.penjualan', [
            'barang'      => $barang,
            'penjualan'   => $penjualan,
            'marginAktif' => $marginAktif,
        ]);
    }

    // Proses Transaksi Penjualan (panggil SP sp_proses_penjualan)
    public function prosesPenjualan(Request $request)
    {
        $request->validate([
            'idbarang' => 'required',
            'jumlah'   => 'required|numeric|min:1',
        ]);

        $idbarang  = (int) $request->input('idbarang');
        $jumlah    = (int) $request->input('jumlah');
        $persenPpn = 11;
        $iduser    = (int) session('iduser', 2);

        // panggil stored procedure
        DB::statement('CALL sp_proses_penjualan(?, ?, ?, ?, @idjual, @pesan)', [
            $idbarang,
            $jumlah,
            $persenPpn,
            $iduser,
        ]);

        // ambil output dari SP
        $output = DB::select('SELECT @idjual AS idjual, @pesan AS pesan')[0];

        if ($output->idjual == 0) {
            return back()->with('error', $output->pesan)->withInput();
        }

        return back()->with('sukses', $output->pesan . ' (ID Penjualan: #' . $output->idjual . ')');
    }
}
