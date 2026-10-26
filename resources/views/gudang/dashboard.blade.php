@extends('layouts.app')

@section('title', 'Dashboard Gudang')

@section('content')
<div class="flex flex-col w-full relative">
    {{-- Decorative Background Accents --}}
    <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full bg-secondary-fixed opacity-60 pointer-events-none select-none blur-2xl"></div>
    <div class="absolute top-[480px] -left-12 w-44 h-44 rounded-full bg-primary-container opacity-40 pointer-events-none select-none blur-3xl"></div>

    {{-- Page Header --}}
    <header class="flex flex-col gap-3 pt-8 mb-5">
        <div class="flex items-center gap-3.5 flex-wrap">
            <h1 class="font-page-title text-page-title text-on-surface leading-none tracking-tight">Halo,</h1>
            <span class="inline-flex items-center justify-center bg-primary-container text-on-surface font-page-title text-page-title px-4 py-1.5 rounded-[12px] border border-[#C9B8EC]/40 leading-none shadow-sm">Gudang</span>
        </div>
        <p class="font-body text-body text-[#504446]">Terima barang fisik, catat retur, dan pantau kartu stok inventaris harian.</p>
    </header>

    {{-- Stat Cards Grid --}}
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter mb-8 z-10">
        {{-- Card 1 --}}
        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between h-[156px] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-2 h-full bg-[#FBEFB5]"></div>
            <div class="flex items-center justify-between">
                <span class="font-body-small text-body-small text-on-surface-variant font-medium">Menunggu Diterima</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-[#FBEFB5] text-[11px] font-semibold text-[#2B2630]">Perlu Cek</span>
            </div>
            <div class="flex items-baseline justify-between mt-auto">
                <span class="font-page-title text-page-title text-on-surface font-bold tracking-tight">0</span>
                <span class="font-caption text-caption text-on-surface-variant">Pesanan Masuk</span>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between h-[156px]">
            <div class="flex items-center justify-between">
                <span class="font-body-small text-body-small text-on-surface-variant font-medium">Total Penerimaan</span>
                <div class="w-9 h-9 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                    <span class="material-symbols-outlined text-[18px]">assignment_turned_in</span>
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-auto">
                <span class="font-page-title text-page-title text-on-surface font-bold tracking-tight">{{ $penerimaanCount }}</span>
                <span class="font-caption text-caption text-on-surface-variant">Transaksi Diterima</span>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between h-[156px]">
            <div class="flex items-center justify-between">
                <span class="font-body-small text-body-small text-on-surface-variant font-medium">Total Retur</span>
                <div class="w-9 h-9 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-auto">
                <span class="font-page-title text-page-title text-on-surface font-bold tracking-tight">{{ $returCount }}</span>
                <span class="font-caption text-caption text-on-surface-variant">Barang Dikembalikan</span>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between h-[156px]">
            <div class="flex items-center justify-between">
                <span class="font-body-small text-body-small text-on-surface-variant font-medium">Total Unit Stok</span>
                <div class="w-9 h-9 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed">
                    <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-auto">
                <span class="font-page-title text-page-title text-on-surface font-bold tracking-tight">{{ $totalStok }}</span>
                <span class="font-caption text-caption text-on-surface-variant">Akumulasi Fisik</span>
            </div>
        </div>
    </section>

    {{-- Main Section: Stok Barang Card --}}
    <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] overflow-hidden flex flex-col mb-8">
        {{-- Card Header --}}
        <div class="px-6 py-5 border-b border-[#E8E1EC] flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <h2 class="font-card-title text-card-title text-on-surface font-semibold">Stok Barang</h2>
                <span class="px-3 py-1 rounded-full bg-[#EDE7FA] text-[#2B2630] font-badge text-badge font-medium">{{ count($barang) }} Barang Terdaftar</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="/gudang/penerimaan/terima" class="h-10 px-4 rounded-[12px] bg-primary-container text-on-surface font-semibold text-body-small flex items-center gap-1.5 hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Terima Barang</span>
                </a>
                <a href="/gudang/retur" class="h-10 px-4 rounded-[12px] bg-[#EDE7FA] text-[#4d3f6b] font-semibold text-body-small flex items-center gap-1.5 hover:bg-[#C9B8EC]/50 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                    <span>Retur</span>
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left border-collapse text-body-small">
                <thead>
                    <tr class="bg-[#EDE7FA] h-12 text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                        <th class="px-6 w-16 text-center">ID</th>
                        <th class="px-6">NAMA BARANG</th>
                        <th class="px-6">SATUAN</th>
                        <th class="px-6 text-center">STOK FISIK</th>
                        <th class="px-6 text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8E1EC]">
                    @forelse ($barang as $row)
                        <tr class="h-14 hover:bg-[#FAF7FE] transition-colors">
                            <td class="px-6 text-center font-medium text-[#6F6677]">{{ $row->idbarang }}</td>
                            <td class="px-6 font-semibold text-on-surface">{{ $row->nama }}</td>
                            <td class="px-6 font-medium text-[#504446]">{{ $row->nama_satuan }}</td>
                            <td class="px-6 text-center font-bold text-on-surface">{{ $row->stok ?? 0 }}</td>
                            <td class="px-6 text-center">
                                @if ($row->status == 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-caption font-semibold bg-tertiary-fixed text-on-surface">Tersedia</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-caption font-semibold bg-error-container text-on-error-container">Kosong</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-[#504446]">
                                Belum ada data barang di gudang
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
