@extends('layouts.app')

@section('title', 'Kartu Stok')

@section('content')
<div class="flex flex-col w-full relative">
    {{-- Header Section --}}
    <header class="flex flex-col gap-3 pt-8 mb-5">
        <div class="flex items-center gap-3.5 flex-wrap">
            <h1 class="font-page-title text-page-title text-on-surface leading-none tracking-tight">Kartu</h1>
            <span class="inline-flex items-center justify-center bg-primary-container text-on-surface font-page-title text-page-title px-4 py-1.5 rounded-[12px] border border-[#C9B8EC]/40 leading-none shadow-sm">Stok</span>
        </div>
        <p class="font-body text-body text-[#504446]">Riwayat pergerakan keluar masuk barang gudang secara kronologis dan saldo akhir.</p>
    </header>

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-space-sm mb-6">
        <div class="flex items-center gap-space-sm flex-1 min-w-[280px]">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">search</span>
                <input class="w-full h-12 pl-11 pr-4 rounded-xl bg-white border border-[#E8E1EC] text-on-surface font-body-small text-body-small shadow-sm outline-none transition-all placeholder:text-on-surface-variant/60 focus:border-[#C9B8EC] focus:shadow-md" placeholder="Cari nama barang..." type="text">
            </div>
            <span class="inline-flex items-center px-4 h-12 rounded-full bg-[#EDE7FA] text-[#20133d] border border-[#C9B8EC]/40 font-badge text-body-small whitespace-nowrap font-medium">Total: {{ count($kartuStok) }} Riwayat</span>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="w-full rounded-[20px] bg-white border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] overflow-hidden flex flex-col mb-8">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left border-collapse text-body-small">
                <thead>
                    <tr class="bg-[#EDE7FA] h-12 text-caption font-semibold uppercase tracking-wider text-[#4d3f6b]">
                        <th class="px-6 w-16 text-center">ID</th>
                        <th class="px-6">TANGGAL</th>
                        <th class="px-6">NAMA BARANG</th>
                        <th class="px-6 text-center">JENIS</th>
                        <th class="px-6 text-center">MASUK</th>
                        <th class="px-6 text-center">KELUAR</th>
                        <th class="px-6 text-center">STOK AKHIR</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8E1EC]">
                    @forelse ($kartuStok as $row)
                        <tr class="h-14 hover:bg-[#FAF7FE] transition-colors">
                            <td class="px-6 text-center font-medium text-[#6F6677]">{{ $row->idkartu_stok }}</td>
                            <td class="px-6 font-medium text-on-surface">{{ $row->created_at }}</td>
                            <td class="px-6 font-semibold text-on-surface">{{ $row->nama_barang }}</td>
                            <td class="px-6 text-center">
                                @if ($row->jenis_transaksi == 'M')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-caption font-semibold bg-tertiary-fixed text-on-surface">Masuk</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-caption font-semibold bg-error-container text-on-error-container">Keluar</span>
                                @endif
                            </td>
                            <td class="px-6 text-center font-semibold text-tertiary">{{ $row->masuk > 0 ? '+'.$row->masuk : '-' }}</td>
                            <td class="px-6 text-center font-semibold text-error">{{ $row->keluar > 0 ? '-'.$row->keluar : '-' }}</td>
                            <td class="px-6 text-center font-bold text-on-surface">{{ $row->stok_akhir }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-[#504446]">
                                Belum ada data kartu stok tercatat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="h-14 px-6 bg-[#FAF7FE] border-t border-[#E8E1EC] flex items-center justify-between">
            <span class="font-body-small text-body-small text-on-surface-variant font-medium">Menampilkan {{ count($kartuStok) }} data</span>
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-[8px] bg-[#EDE7FA] border border-[#C9B8EC]/50 text-[#20133d] font-badge text-badge font-bold flex items-center justify-center shadow-sm">1</span>
            </div>
        </div>
    </div>
</div>
@endsection
