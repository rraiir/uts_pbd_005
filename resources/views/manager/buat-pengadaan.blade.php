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
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mb-12">
        {{-- Left: Form & Order Items --}}
        <div class="lg:col-span-8 bg-white border border-[#E8E1EC] rounded-[20px] p-6 shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col gap-6">
            {{-- Vendor Select --}}
            <div class="flex flex-col gap-2">
                <label class="font-body-small text-body-small font-semibold text-on-surface" for="vendor-select">
                    Vendor <span class="text-error">*</span>
                </label>
                <select class="w-full h-12 rounded-[12px] border border-[#E8E1EC] bg-white text-on-surface text-body-small font-medium px-4 outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all cursor-pointer" id="vendor-select">
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
                <button class="bg-[#EDE7FA] hover:bg-[#C9B8EC]/50 text-[#2B2630] px-4 py-2 rounded-[12px] text-body-small font-semibold transition-colors inline-flex items-center gap-1.5 cursor-pointer" type="button">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Tambah Baris</span>
                </button>
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
                            <th class="py-2 px-4 text-center w-16">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8E1EC]">
                        <tr class="h-16 hover:bg-[#FAF7FE] transition-colors">
                            <td class="px-4 py-2">
                                <select class="w-full h-10 text-body-small rounded-[8px] border-[#E8E1EC] text-on-surface bg-white outline-none">
                                    <option value="">Pilih Barang...</option>
                                    @foreach ($barangs as $b)
                                        <option value="{{ $b->idbarang }}">{{ $b->nama }} (Rp {{ number_format($b->harga, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" value="10" min="1" class="w-full h-10 text-center rounded-[8px] border border-[#E8E1EC] outline-none">
                            </td>
                            <td class="px-4 py-2 font-medium">Rp 2.500</td>
                            <td class="px-4 py-2 font-semibold">Rp 25.000</td>
                            <td class="px-4 py-2 text-center">
                                <button type="button" class="text-error hover:bg-error-container/30 p-1.5 rounded-[8px] transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
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
                    <span class="font-medium text-on-surface">Rp 25.000</span>
                </div>
                <div class="flex justify-between text-[#504446]">
                    <span>PPN (11%)</span>
                    <span class="font-medium text-on-surface">Rp 2.750</span>
                </div>
                <hr class="border-t border-[#E8E1EC]">
                <div class="flex justify-between items-baseline pt-1">
                    <span class="font-semibold text-on-surface text-body">Total Pembayaran</span>
                    <span class="font-bold text-xl text-primary">Rp 27.750</span>
                </div>
            </div>

            <div class="flex flex-col gap-2.5 pt-4">
                <button type="button" class="h-12 w-full rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-semibold flex items-center justify-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    <span>Simpan Pengadaan</span>
                </button>
                <a href="/manager/pengadaan" class="h-12 w-full rounded-[14px] bg-[#EDE7FA] text-[#4d3f6b] hover:bg-[#C9B8EC]/50 font-card-title text-body-small font-semibold flex items-center justify-center gap-2 shadow-sm transition-all text-center">
                    Batal
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
