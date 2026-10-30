@extends('layouts.app')

@section('title', 'Kasir Penjualan')

@section('content')
<div class="flex flex-col w-full relative">
    {{-- Decorative Background Accents --}}
    <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full bg-secondary-fixed opacity-60 pointer-events-none select-none blur-2xl"></div>
    <div class="absolute top-[480px] -left-12 w-44 h-44 rounded-full bg-primary-container opacity-40 pointer-events-none select-none blur-3xl"></div>

    {{-- Page Header --}}
    <header class="flex flex-col gap-3 pt-8 mb-5">
        <div class="flex items-center gap-3.5 flex-wrap">
            <h1 class="font-page-title text-page-title text-on-surface leading-none tracking-tight">Kasir</h1>
            <span class="inline-flex items-center justify-center bg-primary-container text-on-surface font-page-title text-page-title px-4 py-1.5 rounded-[12px] border border-[#C9B8EC]/40 leading-none shadow-sm">Penjualan</span>
        </div>
        <p class="font-body text-body text-[#504446]">Transaksi penjualan langsung menggunakan kalkulasi Function margin harga &amp; Stored Procedure database.</p>
    </header>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-12 gap-gutter items-start mb-12">
        {{-- Left: Form Transaksi Kasir --}}
        <div class="col-span-12 lg:col-span-5 flex flex-col gap-space-md">
            <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] p-6 shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col gap-5">
                <div class="flex items-center justify-between pb-3 border-b border-[#E8E1EC]">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-primary text-[24px]">point_of_sale</span>
                        <h2 class="font-card-title text-card-title text-[#2B2630] font-semibold">Input Transaksi Baru</h2>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-[#EDE7FA] text-[#4d3f6b] font-caption text-caption font-semibold">Margin {{ $marginAktif }}%</span>
                </div>

                {{-- Info Callout --}}
                <div class="p-3.5 rounded-[12px] bg-[#EDE7FA] border border-[#C9B8EC]/40 flex items-start gap-3">
                    <span class="material-symbols-outlined text-[20px] text-[#4d3f6b] shrink-0 mt-0.5">info</span>
                    <p class="font-caption text-caption text-[#4d3f6b] leading-relaxed">
                        Transaksi kasir dengan perhitungan harga jual otomatis (modal + margin) dan pemotongan stok langsung di database.
                    </p>
                </div>

                <form action="{{ route('kasir.penjualan.proses') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    {{-- Pilih Barang --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="font-body-small text-body-small font-semibold text-on-surface" for="idbarang">Pilih Barang *</label>
                        <select name="idbarang" id="select-barang-kasir" required class="w-full h-12 px-4 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all cursor-pointer" onchange="kalkulasiKasir()">
                            <option value="">Pilih barang...</option>
                            @foreach ($barang as $b)
                                <option value="{{ $b->idbarang }}" data-harga-jual="{{ $b->harga_jual }}" data-stok="{{ $b->stok }}">
                                    {{ $b->nama }} - Rp {{ number_format($b->harga_jual, 0, ',', '.') }} (Sisa Stok: {{ $b->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jumlah Item --}}
                    <div class="flex flex-col gap-1.5">
                        <div class="flex items-center justify-between">
                            <label class="font-body-small text-body-small font-semibold text-on-surface" for="input-jumlah-kasir">Jumlah Beli *</label>
                            <span class="font-caption text-caption text-[#504446]" id="label-stok-tersedia">Stok: -</span>
                        </div>
                        <input type="number" name="jumlah" id="input-jumlah-kasir" value="1" min="1" required class="w-full h-12 px-4 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all" oninput="kalkulasiKasir()">
                    </div>

                    {{-- Ringkasan Perhitungan Real-time --}}
                    <div class="bg-surface-container-low rounded-[14px] p-4 flex flex-col gap-2.5 border border-[#E8E1EC]/60 mt-1">
                        <div class="flex justify-between text-body-small text-[#504446]">
                            <span>Harga Satuan (Function)</span>
                            <span class="font-semibold text-on-surface" id="tampil-harga-satuan">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-body-small text-[#504446]">
                            <span>Subtotal</span>
                            <span class="font-semibold text-on-surface" id="tampil-subtotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-body-small text-[#504446]">
                            <span>PPN (11%)</span>
                            <span class="font-semibold text-on-surface" id="tampil-ppn">Rp 0</span>
                        </div>
                        <hr class="border-t border-[#E8E1EC]">
                        <div class="flex justify-between items-baseline pt-1">
                            <span class="font-semibold text-on-surface text-body">Total Akhir</span>
                            <span class="font-bold text-xl text-primary" id="tampil-total">Rp 0</span>
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="pt-2">
                        <button type="submit" class="w-full h-12 rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-semibold flex items-center justify-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-[20px]">shopping_cart_checkout</span>
                            <span>Bayar &amp; Simpan Penjualan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right: Riwayat Transaksi Penjualan Terkini --}}
        <div class="col-span-12 lg:col-span-7 flex flex-col gap-space-md">
            {{-- Toolbar Riwayat --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h2 class="font-card-title text-card-title text-on-surface font-semibold">Riwayat Penjualan Kasir</h2>
                    <span class="inline-flex items-center px-3 h-7 rounded-full bg-[#EDE7FA] text-[#4d3f6b] font-badge text-badge font-medium">Total: {{ count($penjualan) }} Transaksi</span>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] overflow-hidden flex flex-col">
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse text-body-small">
                        <thead>
                            <tr class="bg-[#EDE7FA] h-12 text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                                <th class="px-5 w-16 text-center">ID</th>
                                <th class="px-5">TANGGAL</th>
                                <th class="px-5">BARANG</th>
                                <th class="px-5 text-center">QTY</th>
                                <th class="px-5 text-right">TOTAL</th>
                                <th class="px-5 text-center">KASIR</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E8E1EC]">
                            @forelse ($penjualan as $row)
                                <tr class="h-14 hover:bg-[#FAF7FE] transition-colors">
                                    <td class="px-5 text-center font-semibold text-on-surface">#{{ $row->idpenjualan }}</td>
                                    <td class="px-5 font-medium text-[#504446]">{{ $row->created_at }}</td>
                                    <td class="px-5 font-semibold text-on-surface">{{ $row->nama_barang ?? '-' }}</td>
                                    <td class="px-5 text-center font-bold text-on-surface">{{ $row->jumlah ?? 1 }}</td>
                                    <td class="px-5 text-right font-bold text-primary">Rp {{ number_format($row->total_nilai, 0, ',', '.') }}</td>
                                    <td class="px-5 text-center font-medium text-[#504446]">{{ $row->username }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-[#504446]">
                                        Belum ada data transaksi penjualan tersimpan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="h-12 px-6 bg-[#FAF7FE] border-t border-[#E8E1EC] flex items-center justify-between">
                    <span class="font-body-small text-body-small text-on-surface-variant font-medium">Menampilkan transaksi terbaru</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function kalkulasiKasir() {
    const select = document.getElementById('select-barang-kasir');
    const opt = select.options[select.selectedIndex];
    const inputJumlah = document.getElementById('input-jumlah-kasir');
    const labelStok = document.getElementById('label-stok-tersedia');

    let hargaJual = 0;
    let stok = 0;

    if (opt && opt.dataset.hargaJual) {
        hargaJual = parseFloat(opt.dataset.hargaJual) || 0;
        stok = parseInt(opt.dataset.stok) || 0;
        labelStok.innerText = 'Stok Fisik: ' + stok + ' unit';
        if (stok <= 0) {
            labelStok.className = 'font-caption text-caption text-error font-semibold';
        } else {
            labelStok.className = 'font-caption text-caption text-tertiary font-semibold';
        }
    } else {
        labelStok.innerText = 'Stok: -';
        labelStok.className = 'font-caption text-caption text-[#504446]';
    }

    const jumlah = parseFloat(inputJumlah.value) || 0;
    const subtotal = hargaJual * jumlah;
    const ppn = Math.round(subtotal * 0.11);
    const total = subtotal + ppn;

    const fmt = (num) => 'Rp ' + num.toLocaleString('id-ID');
    document.getElementById('tampil-harga-satuan').innerText = fmt(hargaJual);
    document.getElementById('tampil-subtotal').innerText = fmt(subtotal);
    document.getElementById('tampil-ppn').innerText = fmt(ppn);
    document.getElementById('tampil-total').innerText = fmt(total);
}
</script>
@endsection
