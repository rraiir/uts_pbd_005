@extends('layouts.app')

@section('title', 'Kelola Vendor')

@section('content')
<div class="flex flex-col w-full relative">
    {{-- Header Section --}}
    <header class="flex flex-col gap-3 pt-8 mb-5">
        <div class="flex items-center gap-3.5 flex-wrap">
            <h1 class="font-page-title text-page-title text-on-surface leading-none tracking-tight font-bold">Kelola</h1>
            <span class="inline-flex items-center justify-center bg-[#EDE7FA] text-[#4d3f6b] font-page-title text-page-title font-bold px-4 py-1.5 rounded-[12px] border border-[#C9B8EC]/40 leading-none shadow-sm">Vendor</span>
        </div>
        <p class="font-body text-body text-[#504446]">Atur daftar mitra pemasok dan badan hukum untuk kelancaran rantai pasok inventaris.</p>
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
                        <input class="w-full h-12 pl-11 pr-4 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none transition-all placeholder:text-on-surface-variant/60 focus:border-[#C9B8EC] focus:shadow-md" placeholder="Cari nama vendor..." type="text">
                    </div>
                    <span class="inline-flex items-center px-4 h-9 rounded-full bg-[#EDE7FA] text-[#20133d] border border-[#C9B8EC]/40 font-badge text-badge whitespace-nowrap font-medium">Total: {{ count($vendor) }} Vendor</span>
                </div>
                <button class="h-12 px-6 rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-semibold flex items-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer whitespace-nowrap" type="button">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Tambah Vendor</span>
                </button>
            </div>

            {{-- Data Table Card --}}
            <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] overflow-hidden flex flex-col">
                {{-- Header Bar --}}
                <div class="h-12 px-6 bg-[#EDE7FA] border-b border-[#E8E1EC] flex items-center text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                    <div class="w-16 font-semibold">ID</div>
                    <div class="flex-1 font-semibold pl-2">NAMA VENDOR</div>
                    <div class="w-28 text-center font-semibold">STATUS</div>
                    <div class="w-44 text-right pr-2 font-semibold">AKSI</div>
                </div>

                {{-- Rows --}}
                <div class="divide-y divide-[#E8E1EC]/60">
                    @forelse ($vendor as $row)
                        <div class="h-16 px-6 hover:bg-[#FAF7FE] transition-colors flex items-center">
                            <div class="w-16 font-semibold text-body-small text-on-surface">{{ $row->idvendor }}</div>
                            <div class="flex-1 flex items-center gap-3 pl-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#EDE7FA] text-[#4d3f6b] border border-[#C9B8EC]/50 shrink-0">
                                    <span class="material-symbols-outlined text-[16px]">storefront</span>
                                </span>
                                <div class="flex flex-col">
                                    <span class="font-medium text-body-small text-on-surface">{{ $row->nama_vendor }}</span>
                                    <span class="font-caption text-caption text-[#504446]">Badan Hukum: {{ $row->badan_hukum == 'Y' ? 'Ya' : 'Tidak' }}</span>
                                </div>
                            </div>
                            <div class="w-28 flex justify-center">
                                @if ($row->status == '1' || $row->status == 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-tertiary-fixed text-on-surface font-badge text-badge font-semibold min-w-[70px] justify-center">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-error-container text-on-error-container font-badge text-badge font-semibold min-w-[70px] justify-center">Nonaktif</span>
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
                        <div class="h-16 px-6 flex items-center justify-center text-body-small text-[#504446]">
                            Belum ada data
                        </div>
                    @endforelse
                </div>

                {{-- Footer --}}
                <div class="h-14 px-6 bg-[#FAF7FE] border-t border-[#E8E1EC] flex items-center justify-between">
                    <span class="font-body-small text-body-small text-on-surface-variant font-medium">Menampilkan {{ count($vendor) }} dari {{ count($vendor) }} vendor</span>
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
                    <h2 class="font-card-title text-card-title text-[#2B2630] font-semibold">Tambah / Edit Vendor</h2>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-[#EDE7FA] text-[#2B2630] font-badge text-badge font-medium">Mode Baru</span>
                </div>
                <div class="p-3.5 rounded-[12px] bg-[#EDE7FA] border border-[#C9B8EC]/30 flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[18px] text-[#4d3f6b]">info</span>
                    <span class="font-caption text-caption text-[#4d3f6b] font-medium">ID dibuat otomatis oleh sistem secara berurutan.</span>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="font-body-small text-body-small font-semibold text-on-surface" for="nama_vendor">Nama Vendor *</label>
                        <input class="w-full h-12 px-4 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all placeholder:text-on-surface-variant/60" id="nama_vendor" placeholder="Contoh: PT Mitra Pangan" type="text">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <span class="font-body-small text-body-small font-semibold text-on-surface">Badan Hukum</span>
                        <div class="grid grid-cols-2 gap-2 p-1 bg-[#F5EBF8] rounded-xl">
                            <button class="h-10 rounded-lg flex items-center justify-center gap-1.5 font-body-small text-body-small font-semibold transition-all bg-[#EDE7FA] text-[#2B2630] shadow-sm" type="button">
                                <span class="material-symbols-outlined text-[18px] text-[#2B2630] font-bold">check</span>
                                <span>Ya</span>
                            </button>
                            <button class="h-10 rounded-lg flex items-center justify-center gap-1.5 font-body-small text-body-small font-medium transition-all bg-transparent text-[#6F6677] hover:text-[#2B2630]" type="button">
                                <span>Tidak</span>
                            </button>
                        </div>
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
