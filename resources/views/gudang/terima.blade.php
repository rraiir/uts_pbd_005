@extends('layouts.app')

@section('title', 'Terima Barang')

@section('content')
<div class="flex flex-col w-full relative max-w-[1200px] mx-auto">
    {{-- Back Link --}}
    <div class="mb-3 pt-4">
        <a href="/gudang/penerimaan" class="inline-flex items-center gap-2 text-sm font-medium text-[#6F6677] hover:text-[#2B2630] transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Daftar Penerimaan</span>
        </a>
    </div>

    {{-- Page Header --}}
    <header class="flex flex-col gap-2 mb-6">
        <h1 class="font-page-title text-page-title text-on-surface tracking-tight flex items-center gap-3">
            <span>Terima</span>
            <span class="bg-primary-container text-on-surface rounded-[12px] px-4 py-1 font-page-title text-page-title leading-tight font-bold border border-[#C9B8EC]/40">
                Barang
            </span>
        </h1>
        <p class="font-body text-body text-[#504446]">Catat barang fisik yang datang dari vendor, boleh dicicil (parsial).</p>
    </header>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mb-12">
        {{-- Left: Form & Items --}}
        <div class="lg:col-span-8 bg-white border border-[#E8E1EC] rounded-[20px] p-6 shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col gap-6">
            {{-- Pengadaan Select --}}
            <div class="flex flex-col gap-2">
                <label class="font-body-small text-body-small font-semibold text-on-surface" for="pengadaan-select">
                    Nomor Pengadaan <span class="text-error">*</span>
                </label>
                <select class="w-full h-12 rounded-[12px] border border-[#E8E1EC] bg-white text-on-surface text-body-small font-medium px-4 outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all cursor-pointer" id="pengadaan-select">
                    <option value="">Pilih Pengadaan...</option>
                    @forelse ($pengadaan as $p)
                        <option value="{{ $p->idpengadaan }}">#PGD-{{ str_pad($p->idpengadaan, 3, '0', STR_PAD_LEFT) }} - {{ $p->created_at }}</option>
                    @empty
                        <option disabled>Tidak ada pengadaan yang menunggu penerimaan</option>
                    @endforelse
                </select>
            </div>

            {{-- Auto-fill info --}}
            <div class="bg-[#EDE7FA] rounded-[12px] p-4 flex items-center gap-3 text-body-small text-[#2B2630]">
                <span class="material-symbols-outlined text-[20px] text-[#4d3f6b]">info</span>
                <span>Penerimaan boleh dicicil (parsial) sesuai barang yang benar-benar sampai di gudang.</span>
            </div>

            <hr class="border-t border-[#E8E1EC]">

            {{-- Table header --}}
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-[#2B2630]">Daftar Barang Penerimaan</h2>
                <span class="bg-[#EDE7FA] text-[#2B2630] text-xs font-semibold px-3 py-1 rounded-full">Bisa Dicicil</span>
            </div>

            {{-- Table --}}
            <div class="border border-[#E8E1EC] rounded-[14px] overflow-hidden">
                <table class="w-full text-left border-collapse text-body-small">
                    <thead>
                        <tr class="bg-[#EDE7FA] h-11 text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                            <th class="py-2 px-4">Barang</th>
                            <th class="py-2 px-4 text-center w-24">Dipesan</th>
                            <th class="py-2 px-4 text-center w-28">Sudah Diterima</th>
                            <th class="py-2 px-4 text-center w-36">Diterima Sekarang</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8E1EC]">
                        <tr class="h-16 hover:bg-[#FAF7FE] transition-colors">
                            <td class="px-4 py-2 font-medium">Wafer Cokelat</td>
                            <td class="px-4 py-2 text-center text-[#504446]">50 PCS</td>
                            <td class="px-4 py-2 text-center text-[#504446]">0 PCS</td>
                            <td class="px-4 py-2">
                                <input type="number" value="25" min="1" max="50" class="w-full h-10 text-center rounded-[8px] border border-[#E8E1EC] outline-none">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right: Actions & Info --}}
        <div class="lg:col-span-4 bg-white border border-[#E8E1EC] rounded-[20px] p-6 shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col gap-5">
            <h2 class="font-card-title text-card-title text-[#2B2630] font-semibold border-b border-[#E8E1EC] pb-3">Konfirmasi Kedatangan</h2>
            <div class="flex flex-col gap-3 font-body-small text-body-small">
                <div class="flex justify-between text-[#504446]">
                    <span>Petugas Gudang</span>
                    <span class="font-semibold text-on-surface">{{ session('username', 'gudang1') }}</span>
                </div>
                <div class="flex justify-between text-[#504446]">
                    <span>Status Akhir</span>
                    <span class="font-medium text-tertiary">Sebagian / Selesai</span>
                </div>
            </div>

            <div class="flex flex-col gap-2.5 pt-4">
                <button type="button" class="h-12 w-full rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-semibold flex items-center justify-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    <span>Simpan Penerimaan</span>
                </button>
                <a href="/gudang/penerimaan" class="h-12 w-full rounded-[14px] bg-[#EDE7FA] text-[#4d3f6b] hover:bg-[#C9B8EC]/50 font-card-title text-body-small font-semibold flex items-center justify-center gap-2 shadow-sm transition-all text-center">
                    Batal
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
