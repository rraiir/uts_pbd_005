@extends('layouts.app')

@section('title', 'Kelola Barang')

@section('content')
<div class="flex flex-col w-full relative">
    {{-- Page Header --}}
    <header class="flex flex-col gap-3 pt-8 mb-5">
        <div class="flex items-center gap-3.5 flex-wrap">
            <h1 class="font-page-title text-page-title text-on-surface leading-none tracking-tight">Kelola</h1>
            <span class="inline-flex items-center justify-center bg-[#EDE7FA] text-[#4d3f6b] font-page-title text-page-title px-4 py-1.5 rounded-[12px] border border-[#C9B8EC]/40 leading-none shadow-sm">Barang</span>
        </div>
        <p class="font-body text-body text-[#504446]">Atur katalog dan master data inventaris barang gudang StokKu secara terpadu.</p>
    </header>

    {{-- Two-Column Workspace Layout --}}
    <div class="grid grid-cols-12 gap-gutter items-start">
        {{-- Left Column: Data Table & Toolbar --}}
        <section class="col-span-12 xl:col-span-7 flex flex-col gap-space-md">
            {{-- Action Toolbar --}}
            <div class="flex flex-wrap items-center justify-between gap-space-sm">
                <div class="flex items-center gap-space-sm flex-1 min-w-[280px]">
                    <div class="relative flex-1">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                        <input class="w-full h-12 pl-11 pr-4 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none transition-all placeholder:text-on-surface-variant/60 focus:border-[#C9B8EC] focus:shadow-md" placeholder="Cari nama barang..." type="text">
                    </div>
                    <span class="inline-flex items-center px-3.5 h-8 rounded-full bg-[#EDE7FA] text-[#4d3f6b] border border-[#C9B8EC]/30 font-badge text-badge whitespace-nowrap font-medium">Total: {{ count($barang) }} Barang</span>
                </div>
                <button class="h-12 px-5 rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-semibold flex items-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer whitespace-nowrap" type="button">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Tambah Barang</span>
                </button>
            </div>

            {{-- Inventory Data Table Card --}}
            <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] overflow-hidden flex flex-col">
                {{-- Card Header Bar --}}
                <div class="h-12 px-5 bg-[#EDE7FA]/80 border-b border-[#E8E1EC] flex items-center justify-between text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                    <div class="flex items-center gap-6">
                        <span class="w-16">ID</span>
                        <span>NAMA BARANG</span>
                    </div>
                    <div class="flex items-center gap-8 pr-2">
                        <span class="text-right min-w-[140px]">Harga (Modal / Jual)</span>
                        <span class="text-center min-w-[70px]">Status</span>
                    </div>
                </div>

                {{-- Items List --}}
                <div class="divide-y divide-[#E8E1EC]/60">
                    @forelse ($barang as $row)
                        <div class="p-4 hover:bg-[#FAF7FE] transition-colors flex flex-col gap-3 group">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="font-semibold text-body-small text-on-surface w-16 shrink-0">{{ $row->idbarang }}</span>
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-[#EDE7FA] text-[#4d3f6b] font-semibold text-caption border border-[#C9B8EC]/50 shrink-0">
                                        <span class="material-symbols-outlined text-[16px]">inventory_2</span>
                                    </span>
                                    <div>
                                        <p class="font-medium text-body-small text-on-surface">{{ $row->nama }}</p>
                                        <p class="font-caption text-caption text-[#504446]">Satuan: <span class="font-medium text-on-surface">{{ $row->nama_satuan }}</span></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="flex flex-col text-right min-w-[140px]">
                                        <span class="font-semibold text-body-small text-on-surface">Rp {{ number_format($row->harga, 0, ',', '.') }}</span>
                                        <span class="font-caption text-caption text-tertiary font-semibold flex items-center justify-end gap-1">
                                            <span class="material-symbols-outlined text-[13px]">sell</span> Jual: Rp {{ number_format($row->harga_jual, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="min-w-[70px] flex justify-center">
                                        @if ($row->status == 1)
                                            <span class="inline-flex items-center px-3 h-6 rounded-full bg-tertiary-fixed text-on-surface font-badge text-badge font-semibold">Aktif</span>
                                        @else
                                            <span class="inline-flex items-center px-3 h-6 rounded-full bg-error-container text-on-error-container font-badge text-badge font-semibold">Nonaktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- Action Sub-bar --}}
                            <div class="pt-2 border-t border-[#E8E1EC]/50 flex items-center justify-between bg-surface-container-low/40 -mx-4 -mb-4 px-4 py-2 mt-0.5 rounded-b-[6px]">
                                <span class="font-caption text-caption text-[#504446] flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px]">category</span> Jenis: {{ $row->jenis }}
                                </span>
                                <div class="flex items-center gap-2">
                                    <button class="h-7 px-3.5 rounded-[8px] bg-[#EDE7FA] text-[#4d3f6b] hover:bg-[#C9B8EC]/40 font-badge text-caption font-semibold transition-colors flex items-center gap-1 cursor-pointer" type="button">
                                        <span class="material-symbols-outlined text-[15px]">edit</span> Edit
                                    </button>
                                    <button class="h-7 px-3 rounded-[8px] bg-white border border-[#E8E1EC] text-error hover:bg-error-container/30 font-badge text-caption font-semibold transition-colors flex items-center gap-1 cursor-pointer" type="button">
                                        <span class="material-symbols-outlined text-[15px]">delete</span> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-body-small text-[#504446]">
                            Belum ada data
                        </div>
                    @endforelse
                </div>

                {{-- Table Footer --}}
                <div class="h-14 px-6 bg-[#FAF7FE] border-t border-[#E8E1EC] flex items-center justify-between">
                    <span class="font-body-small text-body-small text-on-surface-variant font-medium">Menampilkan {{ count($barang) }} dari {{ count($barang) }} barang</span>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-[8px] bg-[#EDE7FA] border border-[#C9B8EC]/50 text-[#20133d] font-badge text-badge font-bold flex items-center justify-center shadow-sm">1</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Right Column: Form Card --}}
        <div class="col-span-12 xl:col-span-5">
            <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] p-6 shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col gap-5">
                <div class="flex items-center justify-between pb-1 border-b border-[#E8E1EC]">
                    <h2 class="font-card-title text-card-title text-[#2B2630] font-semibold">Tambah / Edit Barang</h2>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-[#EDE7FA] text-[#2B2630] font-badge text-badge font-medium">Mode Baru</span>
                </div>
                <div class="p-3.5 rounded-[12px] bg-[#EDE7FA] border border-[#C9B8EC]/30 flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[18px] text-[#4d3f6b]">info</span>
                    <span class="font-caption text-caption text-[#4d3f6b] font-medium">ID barang dibuat otomatis oleh sistem secara berurutan.</span>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="font-body-small text-body-small font-semibold text-on-surface" for="nama_barang">Nama Barang *</label>
                        <input class="w-full h-12 px-4 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all placeholder:text-on-surface-variant/60" id="nama_barang" placeholder="Contoh: Wafer Cokelat" type="text">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="font-body-small text-body-small font-semibold text-on-surface" for="harga_satuan">Harga Satuan *</label>
                        <input class="w-full h-12 px-4 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all placeholder:text-on-surface-variant/60" id="harga_satuan" placeholder="Contoh: 2500" type="number">
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
