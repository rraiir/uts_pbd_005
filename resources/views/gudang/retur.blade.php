@extends('layouts.app')

@section('title', 'Kelola Retur')

@section('content')
<div class="flex flex-col w-full relative">
    {{-- Header Section --}}
    <header class="flex flex-col gap-3 pt-8 mb-5">
        <div class="flex items-center gap-3.5 flex-wrap">
            <h1 class="font-page-title text-page-title text-on-surface leading-none tracking-tight">Kelola</h1>
            <span class="inline-flex items-center justify-center bg-primary-container text-on-surface font-page-title text-page-title px-4 py-1.5 rounded-[12px] border border-[#C9B8EC]/40 leading-none shadow-sm">Retur</span>
        </div>
        <p class="font-body text-body text-[#504446]">Catat barang rusak atau cacat yang dikembalikan ke vendor mitra pemasok.</p>
    </header>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-12 gap-gutter items-start">
        {{-- Left: Table Card --}}
        <div class="col-span-12 xl:col-span-7 flex flex-col gap-space-md">
            {{-- Toolbar --}}
            <div class="flex flex-wrap items-center justify-between gap-space-sm">
                <div class="flex items-center gap-space-sm flex-1 min-w-[280px]">
                    <div class="relative flex-1">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                        <input class="w-full h-12 pl-11 pr-4 rounded-xl bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none transition-all placeholder:text-on-surface-variant/60 focus:border-[#C9B8EC] focus:shadow-md" placeholder="Cari ID retur..." type="text">
                    </div>
                    <span class="inline-flex items-center px-4 h-12 rounded-full bg-[#EDE7FA] text-[#20133d] border border-[#C9B8EC]/40 font-badge text-body-small whitespace-nowrap font-medium">Total: {{ count($retur) }} Retur</span>
                </div>
                <button class="h-12 px-5 rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-medium flex items-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer whitespace-nowrap" type="button">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>Buat Retur</span>
                </button>
            </div>

            {{-- Table --}}
            <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] overflow-hidden flex flex-col">
                <div class="h-12 px-6 bg-[#EDE7FA] border-b border-[#E8E1EC] flex items-center text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                    <div class="w-16 font-semibold">ID</div>
                    <div class="flex-1 font-semibold pl-2">TANGGAL</div>
                    <div class="w-36 text-center font-semibold">ID PENERIMAAN</div>
                    <div class="w-32 text-center font-semibold">PETUGAS</div>
                </div>

                <div class="divide-y divide-[#E8E1EC]/60">
                    @forelse ($retur as $row)
                        <div class="h-14 px-6 hover:bg-[#FAF7FE] transition-colors flex items-center text-body-small">
                            <div class="w-16 font-semibold text-on-surface">{{ $row->idretur }}</div>
                            <div class="flex-1 pl-2 font-medium text-on-surface">{{ $row->created_at }}</div>
                            <div class="w-36 text-center font-medium text-[#504446]">#PNR-{{ str_pad($row->idpenerimaan, 3, '0', STR_PAD_LEFT) }}</div>
                            <div class="w-32 text-center font-medium text-on-surface">{{ $row->username }}</div>
                        </div>
                    @empty
                        <div class="py-10 text-center text-body-small text-[#504446]">
                            Belum ada data retur barang
                        </div>
                    @endforelse
                </div>

                <div class="h-14 px-6 bg-[#FAF7FE] border-t border-[#E8E1EC] flex items-center justify-between">
                    <span class="font-body-small text-body-small text-on-surface-variant font-medium">Menampilkan {{ count($retur) }} data</span>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-[8px] bg-[#EDE7FA] border border-[#C9B8EC]/50 text-[#20133d] font-badge text-badge font-bold flex items-center justify-center shadow-sm">1</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Form Card --}}
        <div class="col-span-12 xl:col-span-5">
            <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] p-6 shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col gap-5">
                <div class="flex items-center justify-between pb-1 border-b border-[#E8E1EC]">
                    <h2 class="font-card-title text-card-title text-[#2B2630] font-semibold">Catat Retur Baru</h2>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-[#EDE7FA] text-[#2B2630] font-badge text-badge font-medium">Gudang</span>
                </div>
                <div class="p-3.5 rounded-[12px] bg-[#EDE7FA] border border-[#C9B8EC]/30 flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[18px] text-[#4d3f6b]">info</span>
                    <span class="font-caption text-caption text-[#4d3f6b] font-medium">Retur akan memotong stok gudang dan mencatat kartu stok.</span>
                </div>
                <form class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="font-body-small text-body-small font-semibold text-on-surface" for="idpenerimaan">Nomor Penerimaan *</label>
                        <input class="w-full h-12 px-4 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all placeholder:text-on-surface-variant/60" id="idpenerimaan" placeholder="Contoh: 1" type="number">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="font-body-small text-body-small font-semibold text-on-surface" for="alasan">Alasan Pengembalian *</label>
                        <textarea class="w-full h-24 p-3 rounded-[12px] bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none focus:border-[#C9B8EC] focus:shadow-md transition-all placeholder:text-on-surface-variant/60 resize-none" id="alasan" placeholder="Barang rusak, kemasan bocor, kadaluarsa..."></textarea>
                    </div>
                    <div class="flex items-center gap-3 pt-3">
                        <button class="flex-1 h-12 rounded-[14px] bg-primary-container text-on-surface font-card-title text-body-small font-semibold flex items-center justify-center gap-2 hover:opacity-95 shadow-sm active:scale-[0.98] transition-all cursor-pointer" type="button">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            <span>Simpan Retur</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
