@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="flex flex-col w-full relative">
    {{-- Decorative subtle background accents --}}
    <div class="absolute -top-6 -right-6 w-36 h-36 rounded-full bg-secondary-fixed opacity-60 pointer-events-none select-none blur-2xl"></div>
    <div class="absolute top-[480px] -left-12 w-44 h-44 rounded-full bg-primary-container opacity-40 pointer-events-none select-none blur-3xl"></div>

    {{-- Page Heading --}}
    <header class="flex flex-col gap-3 pt-8 mb-5">
        <div class="flex items-center gap-3.5 flex-wrap">
            <h1 class="font-page-title text-page-title text-on-surface leading-none tracking-tight">Halo,</h1>
            <span class="inline-flex items-center justify-center bg-[#EDE7FA] text-[#4d3f6b] font-page-title text-page-title px-4 py-1.5 rounded-[12px] border border-[#C9B8EC]/40 leading-none shadow-sm">Admin</span>
        </div>
        <p class="font-body text-body text-[#504446]">Selamat datang kembali! Pantau ringkasan performa dan pergerakan stok inventaris StokKu.</p>
    </header>

    @php
        // Ambil hitungan COUNT dari database via DB::select
        $barangCount = \Illuminate\Support\Facades\DB::select('SELECT COUNT(*) as c FROM barang')[0]->c ?? 5;
        $vendorCount = \Illuminate\Support\Facades\DB::select('SELECT COUNT(*) as c FROM vendor')[0]->c ?? 5;
        $userCount   = \Illuminate\Support\Facades\DB::select('SELECT COUNT(*) as c FROM user')[0]->c ?? 5;
        $marginRow   = \Illuminate\Support\Facades\DB::select('SELECT persen FROM margin_penjualan WHERE status = 1 LIMIT 1');
        $marginAktif = !empty($marginRow) ? $marginRow[0]->persen : 10;
    @endphp

    {{-- Section 1: Ringkasan Inventaris (4 Stat Cards) --}}
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter mb-8 z-10">
        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between h-[156px] transition-transform duration-200 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="font-body-small text-body-small text-on-surface-variant font-medium">Barang Aktif</span>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed font-badge text-caption">
                    <span class="material-symbols-outlined text-[14px]">check_circle</span>Tersedia
                </span>
            </div>
            <div class="flex items-baseline justify-between mt-auto">
                <span class="font-page-title text-page-title text-on-surface font-bold tracking-tight">{{ $barangCount }}</span>
                <span class="font-caption text-caption text-on-surface-variant">Total SKU</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between h-[156px] transition-transform duration-200 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="font-body-small text-body-small text-on-surface-variant font-medium">Vendor</span>
                <div class="w-7 h-7 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-auto">
                <span class="font-page-title text-page-title text-on-surface font-bold tracking-tight">{{ $vendorCount }}</span>
                <span class="font-caption text-caption text-on-surface-variant">Mitra Terdaftar</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between h-[156px] transition-transform duration-200 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="font-body-small text-body-small text-on-surface-variant font-medium">User</span>
                <div class="w-7 h-7 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[16px]">group</span>
                </div>
            </div>
            <div class="flex items-baseline justify-between mt-auto">
                <span class="font-page-title text-page-title text-on-surface font-bold tracking-tight">{{ $userCount }}</span>
                <span class="font-caption text-caption text-on-surface-variant">Akun Aktif</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between h-[156px] transition-transform duration-200 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="font-body-small text-body-small text-on-surface-variant font-medium">Margin Aktif</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-surface-container-high text-on-surface-variant font-badge text-caption font-medium">Standar</span>
            </div>
            <div class="flex items-baseline justify-between mt-auto">
                <span class="font-page-title text-page-title text-on-surface font-bold tracking-tight">{{ $marginAktif }}%</span>
                <span class="font-caption text-caption text-on-surface-variant">Persentase Laba</span>
            </div>
        </div>
    </section>

    {{-- Section 2: Akses Cepat Navigasi Modul --}}
    <section class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] z-10 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-card-title text-card-title text-on-surface font-semibold tracking-tight">Akses Cepat</h2>
            <span class="font-caption text-caption text-on-surface-variant">Pilih menu navigasi utama</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            {{-- 1. Satuan --}}
            <a class="h-[92px] px-5 rounded-[14px] bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-4 group" href="/admin/satuan">
                <div class="w-12 h-12 rounded-xl bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">straighten</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-body text-body text-on-surface font-semibold truncate">Satuan</span>
                    <span class="font-caption text-caption text-on-surface-variant truncate">Kelola unit &amp; ukuran barang</span>
                </div>
            </a>
            {{-- 2. Barang --}}
            <a class="h-[92px] px-5 rounded-[14px] bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-4 group" href="/admin/barang">
                <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary-container flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">inventory_2</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-body text-body text-on-surface font-semibold truncate">Barang</span>
                    <span class="font-caption text-caption text-on-surface-variant truncate">Katalog &amp; ketersediaan stok</span>
                </div>
            </a>
            {{-- 3. Vendor --}}
            <a class="h-[92px] px-5 rounded-[14px] bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-4 group" href="/admin/vendor">
                <div class="w-12 h-12 rounded-xl bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">storefront</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-body text-body text-on-surface font-semibold truncate">Vendor</span>
                    <span class="font-caption text-caption text-on-surface-variant truncate">Pemasok &amp; rantai pasok</span>
                </div>
            </a>
            {{-- 4. User --}}
            <a class="h-[92px] px-5 rounded-[14px] bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-4 group" href="/admin/user">
                <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary-container flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">person</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-body text-body text-on-surface font-semibold truncate">User</span>
                    <span class="font-caption text-caption text-on-surface-variant truncate">Pengguna &amp; kredensial staf</span>
                </div>
            </a>
            {{-- 5. Role --}}
            <a class="h-[92px] px-5 rounded-[14px] bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-4 group" href="/admin/role">
                <div class="w-12 h-12 rounded-xl bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">verified_user</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-body text-body text-on-surface font-semibold truncate">Role</span>
                    <span class="font-caption text-caption text-on-surface-variant truncate">Tingkat hak akses sistem</span>
                </div>
            </a>
            {{-- 6. Margin Penjualan --}}
            <a class="h-[92px] px-5 rounded-[14px] bg-surface-container-low hover:bg-surface-container transition-colors flex items-center gap-4 group" href="/admin/margin">
                <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary-container flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">percent</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-body text-body text-on-surface font-semibold truncate">Margin Penjualan</span>
                    <span class="font-caption text-caption text-on-surface-variant truncate">Konfigurasi persentase laba</span>
                </div>
            </a>
        </div>
    </section>

    {{-- Section 3: Visual Rekapitulasi & Log Aktivitas Sistem --}}
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-gutter z-10 mb-8">
        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between min-h-[300px]">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-card-title text-card-title text-on-surface font-semibold">Status Gudang</h3>
                    <span class="font-caption text-caption text-tertiary font-medium">Optimal</span>
                </div>
                <p class="font-body-small text-body-small text-on-surface-variant mb-6">Kapasitas penampungan barang aktif berada dalam batas aman tanpa penumpukan signifikan.</p>
                <div class="h-24 w-full flex items-end justify-between gap-3 px-2">
                    <div class="flex-1 flex flex-col items-center gap-1.5"><div class="w-full bg-secondary-container rounded-lg h-14"></div><span class="font-caption text-caption text-on-surface-variant">Min</span></div>
                    <div class="flex-1 flex flex-col items-center gap-1.5"><div class="w-full bg-primary-container rounded-lg h-20"></div><span class="font-caption text-caption text-on-surface-variant">Sen</span></div>
                    <div class="flex-1 flex flex-col items-center gap-1.5"><div class="w-full bg-secondary-container rounded-lg h-16"></div><span class="font-caption text-caption text-on-surface-variant">Sel</span></div>
                    <div class="flex-1 flex flex-col items-center gap-1.5"><div class="w-full bg-primary-container rounded-lg h-24"></div><span class="font-caption text-caption text-on-surface font-semibold">Rab</span></div>
                    <div class="flex-1 flex flex-col items-center gap-1.5"><div class="w-full bg-surface-container rounded-lg h-8"></div><span class="font-caption text-caption text-on-surface-variant">Kam</span></div>
                </div>
            </div>
            <div class="pt-4 flex items-center justify-between border-t border-[#E8E1EC] mt-4">
                <span class="font-caption text-caption text-on-surface-variant">Pembaruan otomatis</span>
                <span class="font-caption text-caption text-on-surface font-semibold">Hari Ini, Realtime</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-[20px] p-6 border border-[#E8E1EC] shadow-[0_8px_24px_rgba(43,38,48,0.06)] flex flex-col justify-between min-h-[300px]">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-card-title text-card-title text-on-surface font-semibold">Aktivitas Terkini</h3>
                    <span class="font-body-small text-body-small text-primary font-medium">Log Sistem</span>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="h-14 flex items-center justify-between px-3 hover:bg-surface-container-low transition-colors rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container shrink-0">
                                <span class="material-symbols-outlined text-[16px]">edit</span>
                            </div>
                            <span class="font-body text-body text-on-surface font-medium">Pembaruan margin penjualan standar ke 10%</span>
                        </div>
                        <span class="font-caption text-caption text-on-surface-variant">Aktif</span>
                    </div>
                    <div class="h-14 flex items-center justify-between px-3 hover:bg-surface-container-low transition-colors rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container shrink-0">
                                <span class="material-symbols-outlined text-[16px]">add_box</span>
                            </div>
                            <span class="font-body text-body text-on-surface font-medium">Katalog {{ $barangCount }} barang siap dalam inventaris</span>
                        </div>
                        <span class="font-caption text-caption text-on-surface-variant">Tercatat</span>
                    </div>
                    <div class="h-14 flex items-center justify-between px-3 hover:bg-surface-container-low transition-colors rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed shrink-0">
                                <span class="material-symbols-outlined text-[16px]">sync_alt</span>
                            </div>
                            <span class="font-body text-body text-on-surface font-medium">{{ $vendorCount }} vendor logistik terverifikasi</span>
                        </div>
                        <span class="font-caption text-caption text-on-surface-variant">Terhubung</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
