@extends('layouts.app')

@section('title', 'Buat Pengadaan')

@section('content')
<div class="flex flex-col w-full relative max-w-[1200px] mx-auto">
    {{-- Back Link --}}
    <div class="mb-3 pt-4">
        <a href="/manager/pengadaan" class="inline-flex items-center gap-2 text-sm font-medium text-[#6F6677] hover:text-[#2B2630] transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Daftar Pengadaan</span>
        </a>
    </div>

    {{-- Page Header --}}
    <header class="flex flex-col gap-2 mb-6">
        <h1 class="font-page-title text-page-title text-on-surface tracking-tight flex items-center gap-3">
            <span>Buat</span>
            <span class="bg-primary-container text-on-surface rounded-[12px] px-4 py-1 font-page-title text-page-title leading-tight font-bold border border-[#C9B8EC]/40">
                Pengadaan
            </span>
        </h1>
        <p class="font-body text-body text-[#504446]">Pesan barang baru ke vendor mitra logistik.</p>
    </header>

    {{-- Two Column Grid --}}
    <form action="{{ route('manager.pengadaan.simpan') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mb-12">
        @csrf
        {{-- Left: Form & Order Items --}}
        <div class="lg:col-span-8 bg-white border border-[#E8E1EC] rounded-[20px] p-6 shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col gap-6">
            {{-- Vendor Select --}}
            <div class="flex flex-col gap-2">
                <label class="font-body-small text-body-small font-semibold text-on-surface" for="vendor-select">
                    Vendor <span class="text-error">*</span>
                </label>
                <select name="vendor_idvendor" required class="w-full h-12 rounded-[12px] border border-[#E8E1EC] bg-white text-on-surface text-body-small font-medium px-4 outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all cursor-pointer" id="vendor-select">
                    <option value="">Pilih Vendor...</option>
                    @foreach ($vendors as $v)
                        <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Info Notice --}}
            <div class="bg-[#EDE7FA] rounded-[12px] p-4 flex items-center gap-3 text-body-small text-[#2B2630]">
                <span class="material-symbols-outlined text-[20px] text-[#4d3f6b]">info</span>
                <span>Tanggal dan status awal ("Dipesan") diisi otomatis oleh sistem.</span>
            </div>

            <hr class="border-t border-[#E8E1EC]">

            {{-- Items Header --}}
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-[#2B2630]">Daftar Barang Pesanan</h2>
            </div>

            {{-- Items Table --}}
            <div class="border border-[#E8E1EC] rounded-[14px] overflow-hidden">
                <table class="w-full text-left border-collapse text-body-small">
                    <thead>
                        <tr class="bg-[#EDE7FA] h-11 text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                            <th class="py-2 px-4">Barang</th>
                            <th class="py-2 px-4 text-center w-28">Jumlah</th>
                            <th class="py-2 px-4 w-36">Harga Satuan</th>
                            <th class="py-2 px-4">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8E1EC]">
                        <tr class="h-16 hover:bg-[#FAF7FE] transition-colors">
                            <td class="px-4 py-2">
                                <select name="idbarang" id="pilih-barang" required class="w-full h-10 text-body-small rounded-[8px] border border-[#E8E1EC] text-on-surface bg-white outline-none px-2" onchange="updateHitungan()">
                                    <option value="">Pilih Barang...</option>
                                    @foreach ($barangs as $b)
                                        <option value="{{ $b->idbarang }}" data-harga="{{ $b->harga }}">{{ $b->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="jumlah" id="input-jumlah" value="10" min="1" required class="w-full h-10 text-center rounded-[8px] border border-[#E8E1EC] outline-none" oninput="updateHitungan()">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="harga_satuan" id="input-harga" value="0" min="0" required class="w-full h-10 px-2 rounded-[8px] border border-[#E8E1EC] outline-none" oninput="updateHitungan()">
                            </td>
                            <td class="px-4 py-2 font-semibold text-on-surface" id="tampil-subtotal">
                                Rp 0
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right: Summary Card --}}
        <div class="lg:col-span-4 bg-white border border-[#E8E1EC] rounded-[20px] p-6 shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col gap-5">
            <h2 class="font-card-title text-card-title text-[#2B2630] font-semibold border-b border-[#E8E1EC] pb-3">Ringkasan Biaya</h2>
            <div class="flex flex-col gap-3 font-body-small text-body-small">
                <div class="flex justify-between text-[#504446]">
                    <span>Subtotal</span>
                    <span class="font-medium text-on-surface" id="ringkasan-subtotal">Rp 0</span>
                </div>
                <div class="flex justify-between text-[#504446]">
                    <span>PPN (11%)</span>
                    <span class="font-medium text-on-surface" id="ringkasan-ppn">Rp 0</span>
                </div>
                <hr class="border-t border-[#E8E1EC]">
                <div class="flex justify-between items-baseline pt-1">
                    <span class="font-semibold text-on-surface text-body">Total Pembayaran</span>
                    <span class="font-bold text-xl text-primary" id="ringkasan-total">Rp 0</span>
                </div>
            </div>

            <div class="flex flex-col gap-2.5 pt-4">
                <button type="submit" class="h-12 w-full rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-semibold flex items-center justify-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    <span>Simpan Pengadaan</span>
                </button>
                <a href="/manager/pengadaan" class="h-12 w-full rounded-[14px] bg-[#EDE7FA] text-[#4d3f6b] hover:bg-[#C9B8EC]/50 font-card-title text-body-small font-semibold flex items-center justify-center gap-2 shadow-sm transition-all text-center">
                    Batal
                </a>
            </div>
        </div>
    </form>

    <script>
    function updateHitungan() {
        const select = document.getElementById('pilih-barang');
        const opt = select.options[select.selectedIndex];
        const inputHarga = document.getElementById('input-harga');
        const inputJumlah = document.getElementById('input-jumlah');

        // Jika harga masih 0 atau user baru ganti barang, set harga default modalnya
        if (opt && opt.dataset.harga && (inputHarga.value == 0 || inputHarga.dataset.barangId != opt.value)) {
            inputHarga.value = opt.dataset.harga;
            inputHarga.dataset.barangId = opt.value;
        }

        const harga = parseFloat(inputHarga.value) || 0;
        const jumlah = parseFloat(inputJumlah.value) || 0;
        const subtotal = harga * jumlah;
        const ppn = Math.round(subtotal * 0.11);
        const total = subtotal + ppn;

        const fmt = (num) => 'Rp ' + num.toLocaleString('id-ID');
        document.getElementById('tampil-subtotal').innerText = fmt(subtotal);
        document.getElementById('ringkasan-subtotal').innerText = fmt(subtotal);
        document.getElementById('ringkasan-ppn').innerText = fmt(ppn);
        document.getElementById('ringkasan-total').innerText = fmt(total);
    }
    </script>
</div>
@endsection
