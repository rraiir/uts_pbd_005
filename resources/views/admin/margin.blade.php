@extends('layouts.app')

@section('title', 'Atur Margin Penjualan')

@section('content')
<div class="flex flex-col w-full relative">
    {{-- Header Section --}}
    <header class="flex flex-col gap-3 pt-8 mb-5">
        <div class="flex items-center gap-3.5 flex-wrap">
            <h1 class="font-page-title text-page-title text-on-surface leading-none tracking-tight">Atur</h1>
            <span class="inline-flex items-center justify-center bg-primary-container text-on-surface font-page-title text-page-title px-4 py-1.5 rounded-[12px] border border-[#C9B8EC]/40 leading-none shadow-sm">Margin Penjualan</span>
        </div>
        <p class="font-body text-body text-[#504446]">Tentukan persentase keuntungan penjualan barang toko. Hanya 1 margin yang aktif secara bersamaan.</p>
    </header>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-12 gap-gutter items-start">
        {{-- Left Column: Table Card --}}
        <div class="col-span-12 xl:col-span-7 flex flex-col gap-space-md">
            {{-- Toolbar --}}
            <div class="flex flex-wrap items-center justify-between gap-space-sm">
                <div class="flex items-center gap-space-sm flex-1 min-w-[280px]">
                    <div class="relative flex-1">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                        <input class="w-full h-12 pl-11 pr-4 rounded-xl bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none transition-all placeholder:text-on-surface-variant/60 focus:border-[#C9B8EC] focus:shadow-md" placeholder="Cari margin..." type="text">
                    </div>
                    <span class="inline-flex items-center px-4 h-12 rounded-full bg-[#EDE7FA] text-[#20133d] border border-[#C9B8EC]/40 font-badge text-body-small whitespace-nowrap font-medium">Total: {{ count($margins) }} Margin</span>
                </div>
                <button class="h-12 px-5 rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-medium flex items-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer whitespace-nowrap" type="button">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Tambah Margin</span>
                </button>
            </div>

            {{-- Table --}}
            <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] overflow-hidden flex flex-col">
                {{-- Header Bar --}}
                <div class="h-12 px-6 bg-[#EDE7FA] border-b border-[#E8E1EC] flex items-center text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                    <div class="w-16 font-semibold">ID</div>
                    <div class="flex-1 font-semibold pl-2">PERSENTASE</div>
                    <div class="w-32 text-center font-semibold">DIBUAT OLEH</div>
                    <div class="w-28 text-center font-semibold">STATUS</div>
                    <div class="w-44 text-right pr-2 font-semibold">AKSI</div>
                </div>

                {{-- Rows --}}
                <div class="divide-y divide-[#E8E1EC]/60">
                    @forelse ($margins as $row)
                        <div class="h-14 px-6 hover:bg-[#FAF7FE] transition-colors flex items-center">
                            <div class="w-16 font-semibold text-body-small text-on-surface">{{ $row->idmargin_penjualan }}</div>
                            <div class="flex-1 flex items-center gap-3 pl-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#EDE7FA] text-[#4d3f6b] border border-[#C9B8EC]/50 shrink-0">
                                    <span class="material-symbols-outlined text-[16px]">percent</span>
                                </span>
                                <span class="font-semibold text-body text-on-surface">{{ $row->persen }}%</span>
                            </div>
                            <div class="w-32 text-center text-body-small text-[#504446]">
                                {{ $row->dibuat_oleh }}
                            </div>
                            <div class="w-28 flex justify-center">
                                @if ($row->status == 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-tertiary-fixed text-on-surface font-badge text-badge font-semibold min-w-[70px] justify-center">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface-container-high text-[#504446] font-badge text-badge font-semibold min-w-[70px] justify-center">Nonaktif</span>
                                @endif
                            </div>
                            <div class="w-44 flex items-center justify-end gap-2 pr-2">
                                <button class="h-8 px-3.5 rounded-[8px] bg-[#EDE7FA] text-[#4d3f6b] hover:bg-[#C9B8EC]/50 font-badge text-caption font-semibold transition-colors flex items-center gap-1 cursor-pointer" type="button">
                                    <span class="material-symbols-outlined text-[15px]">edit</span> Edit
                                </button>
                                <button class="h-8 px-3 rounded-[8px] bg-white border border-[#E8E1EC] text-error hover:bg-error-container/30 font-badge text-caption font-semibold transition-colors flex items-center gap-1 cursor-pointer" type="button">
                                    <span class="material-symbols-outlined text-[15px]">delete</span> Hapus
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="h-14 px-6 flex items-center justify-center text-body-small text-[#504446]">
                            Belum ada data
                        </div>
                    @endforelse
                </div>

                {{-- Footer --}}
                <div class="h-14 px-6 bg-[#FAF7FE] border-t border-[#E8E1EC] flex items-center justify-between">
                    <span class="font-body-small text-body-small text-on-surface-variant font-medium">Menampilkan {{ count($margins) }} dari {{ count($margins) }} margin</span>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-[8px] bg-[#EDE7FA] border border-[#C9B8EC]/50 text-[#20133d] font-badge text-badge font-bold flex items-center justify-center shadow-sm">1</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Form Card --}}
        <div class="col-span-12 xl:col-span-5">
            <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] p-6 shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col gap-5">
                <div class="flex items-center justify-between pb-1 border-b border-[#E8E1EC]">
                    <h2 class="font-card-title text-card-title text-[#2B2630] font-semibold">Tambah / Edit Margin</h2>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-[#EDE7FA] text-[#2B2630] font-badge text-badge font-medium">Mode Baru</span>
                </div>
                <div class="p-3.5 rounded-[12px] bg-[#EDE7FA] border border-[#C9B8EC]/30 flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[18px] text-[#4d3f6b]">info</span>
                    <span class="font-caption text-caption text-[#4d3f6b] font-medium">Hanya boleh 1 margin yang aktif. Disarankan 10%.</span>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="font-body-small text-body-small font-semibold text-on-surface" for="persen">Persentase (%) *</label>
                        <input class="w-full h-12 px-4 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all placeholder:text-on-surface-variant/60" id="persen" placeholder="Contoh: 10.0" step="0.1" type="number">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <span class="font-body-small text-body-small font-semibold text-on-surface">Status</span>
                        <div class="grid grid-cols-2 gap-2 p-1 bg-[#F5EBF8] rounded-xl">
                            <button class="h-10 rounded-lg flex items-center justify-center gap-1.5 font-body-small text-body-small font-semibold transition-all bg-[#BFE8D6] text-[#2B2630] shadow-sm" type="button">
                                <span class="material-symbols-outlined text-[18px] text-[#2B2630] font-bold">check</span>
                                <span>Aktif</span>
                            </button>
                            <button class="h-10 rounded-lg flex items-center justify-center gap-1.5 font-body-small text-body-small font-medium transition-all bg-transparent text-[#6F6677] hover:text-[#2B2630]" type="button">
                                <span>Nonaktif</span>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 pt-3">
                        <button class="flex-1 h-12 rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-semibold flex items-center justify-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer" type="button">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            <span>Simpan</span>
                        </button>
                        <button class="flex-1 h-12 rounded-[14px] bg-[#EDE7FA] text-[#4d3f6b] hover:bg-[#C9B8EC]/50 font-card-title text-body-small font-semibold flex items-center justify-center gap-2 shadow-sm active:scale-[0.98] transition-all cursor-pointer" type="button">
                            <span>Batal</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
