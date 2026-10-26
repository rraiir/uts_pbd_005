@extends('layouts.app')

@section('title', 'Kelola Penerimaan')

@section('content')
<div class="flex flex-col w-full relative">
    {{-- Header Section --}}
    <header class="flex flex-col gap-3 pt-8 mb-5">
        <div class="flex items-center gap-3.5 flex-wrap">
            <h1 class="font-page-title text-page-title text-on-surface leading-none tracking-tight">Kelola</h1>
            <span class="inline-flex items-center justify-center bg-primary-container text-on-surface font-page-title text-page-title px-4 py-1.5 rounded-[12px] border border-[#C9B8EC]/40 leading-none shadow-sm">Penerimaan</span>
        </div>
        <p class="font-body text-body text-[#504446]">Catat dan verifikasi penerimaan barang fisik dari pesanan pengadaan vendor.</p>
    </header>

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm mb-6">
        <div class="flex items-center gap-space-sm flex-1 min-w-[280px]">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                <input class="w-full h-12 pl-11 pr-4 rounded-xl bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none transition-all placeholder:text-on-surface-variant/60 focus:border-[#C9B8EC] focus:shadow-md" placeholder="Cari vendor atau nomor pengadaan..." type="text">
            </div>
            <span class="inline-flex items-center px-4 h-12 rounded-full bg-[#EDE7FA] text-[#20133d] border border-[#C9B8EC]/40 font-badge text-body-small whitespace-nowrap font-medium">Total: {{ count($penerimaan) }} Penerimaan</span>
        </div>
        <a href="/gudang/penerimaan/terima" class="h-12 px-6 rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-semibold flex items-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer whitespace-nowrap">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span>Terima Barang</span>
        </a>
    </div>

    {{-- Table Card --}}
    <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] overflow-hidden flex flex-col mb-8">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left border-collapse text-body-small">
                <thead>
                    <tr class="bg-[#EDE7FA] h-12 text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                        <th class="px-6 w-16 text-center">ID</th>
                        <th class="px-6">TANGGAL</th>
                        <th class="px-6">ID PENGADAAN</th>
                        <th class="px-6">VENDOR</th>
                        <th class="px-6">DITERIMA OLEH</th>
                        <th class="px-6 text-center">STATUS</th>
                        <th class="px-6 text-right pr-8">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8E1EC]">
                    @forelse ($penerimaan as $row)
                        <tr class="h-14 hover:bg-[#FAF7FE] transition-colors">
                            <td class="px-6 text-center font-medium text-[#6F6677]">{{ $row->idpenerimaan }}</td>
                            <td class="px-6 font-medium text-on-surface">{{ $row->created_at }}</td>
                            <td class="px-6 font-medium text-[#6F6677]">#PGD-{{ str_pad($row->idpengadaan, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 font-semibold text-on-surface">{{ $row->nama_vendor }}</td>
                            <td class="px-6 font-medium text-[#6F6677]">{{ $row->username }}</td>
                            <td class="px-6 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-caption font-medium bg-[#BFE8D6] text-[#2B2630]">
                                    Diterima
                                </span>
                            </td>
                            <td class="px-6 text-right pr-8">
                                <button class="h-8 px-3.5 rounded-[8px] border border-[#2B2630] text-[#2B2630] font-semibold text-caption hover:bg-[#EDE7FA] transition shadow-sm cursor-pointer" type="button">Detail</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-[#504446]">
                                Belum ada data transaksi penerimaan barang
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="h-14 px-6 bg-[#FAF7FE] border-t border-[#E8E1EC] flex items-center justify-between">
            <span class="font-body-small text-body-small text-on-surface-variant font-medium">Menampilkan {{ count($penerimaan) }} data</span>
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-[8px] bg-[#EDE7FA] border border-[#C9B8EC]/50 text-[#20133d] font-badge text-badge font-bold flex items-center justify-center shadow-sm">1</span>
            </div>
        </div>
    </div>
</div>
@endsection
