<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StokKu - @yield('title', 'Sistem Inventory')</title>

    {{-- Google Fonts: Inter + Material Symbols --}}
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    {{-- Tailwind CDN + config token dari Stitch --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "on-secondary-fixed": "#20133d",
                    "on-secondary-container": "#605280",
                    "on-background": "#1e1a23",
                    "secondary-fixed": "#eaddff",
                    "surface-variant": "#e9dfed",
                    "on-primary-container": "#603b44",
                    "surface-bright": "#fff7ff",
                    "tertiary": "#406658",
                    "on-surface": "#1e1a23",
                    "secondary-container": "#dbc9fe",
                    "on-primary-fixed-variant": "#613c45",
                    "on-tertiary": "#ffffff",
                    "on-tertiary-container": "#274c3f",
                    "on-tertiary-fixed-variant": "#294e40",
                    "inverse-surface": "#342e39",
                    "outline-variant": "#d4c2c5",
                    "secondary": "#655785",
                    "primary-fixed": "#ffd9e0",
                    "background": "#fff7ff",
                    "primary": "#7b535c",
                    "error": "#ba1a1a",
                    "surface-container-high": "#efe5f3",
                    "tertiary-fixed": "#c2ecd9",
                    "on-error": "#ffffff",
                    "tertiary-container": "#94bcab",
                    "outline": "#827476",
                    "surface-container": "#f5ebf8",
                    "on-error-container": "#93000a",
                    "error-container": "#ffdad6",
                    "secondary-fixed-dim": "#cfbef3",
                    "tertiary-fixed-dim": "#a7cfbe",
                    "surface-dim": "#e0d7e4",
                    "on-primary-fixed": "#2f121a",
                    "surface": "#fff7ff",
                    "inverse-on-surface": "#f7edfb",
                    "on-tertiary-fixed": "#002117",
                    "on-secondary-fixed-variant": "#4d3f6b",
                    "primary-container": "#d8a7b1",
                    "inverse-primary": "#ecb9c4",
                    "on-secondary": "#ffffff",
                    "surface-container-lowest": "#ffffff",
                    "surface-container-low": "#faf0fe",
                    "on-primary": "#ffffff",
                    "surface-tint": "#7b535c",
                    "primary-fixed-dim": "#ecb9c4",
                    "surface-container-highest": "#e9dfed",
                    "on-surface-variant": "#504446"
                },
                borderRadius: {
                    DEFAULT: "0.25rem",
                    lg: "0.5rem",
                    xl: "0.75rem",
                    full: "9999px"
                },
                spacing: {
                    "space-md": "1rem",
                    "space-sm": "0.75rem",
                    "space-xl": "3rem",
                    "space-lg": "1.5rem",
                    "gutter": "1.5rem",
                    "space-xs": "0.5rem",
                    "margin": "3rem"
                },
                fontFamily: {
                    "login-headline": ["Inter"],
                    "card-title": ["Inter"],
                    "body": ["Inter"],
                    "caption": ["Inter"],
                    "section-title": ["Inter"],
                    "badge": ["Inter"],
                    "page-title": ["Inter"],
                    "body-small": ["Inter"]
                },
                fontSize: {
                    "login-headline": ["72px", { lineHeight: "100px", letterSpacing: "-0.03em", fontWeight: "700" }],
                    "card-title": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                    "body": ["16px", { lineHeight: "22.4px", fontWeight: "400" }],
                    "caption": ["12px", { lineHeight: "16.8px", fontWeight: "500" }],
                    "section-title": ["28px", { lineHeight: "40px", letterSpacing: "-0.01em", fontWeight: "700" }],
                    "badge": ["12px", { lineHeight: "16.8px", fontWeight: "500" }],
                    "page-title": ["40px", { lineHeight: "56px", letterSpacing: "-0.02em", fontWeight: "700" }],
                    "body-small": ["14px", { lineHeight: "19.6px", fontWeight: "400" }]
                }
            }
        }
    };
    </script>

    {{-- Reset dasar sesuai Stitch --}}
    <style>
    @layer base {
        html, body { margin: 0; padding: 0; }
        body { overscroll-behavior: none; }
    }
    ::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-surface-container-lowest font-body text-on-surface antialiased">

    {{-- ===== TOP BAR (fixed) ===== --}}
    <header class="fixed top-0 left-0 right-0 h-[72px] z-50 bg-surface-container-lowest border-b border-surface-container-highest px-12 flex items-center justify-between">
        {{-- Logo --}}
        <div class="flex items-center gap-space-sm">
            <div class="w-9 h-9 rounded-xl bg-secondary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[22px]">local_florist</span>
            </div>
            <span class="font-page-title text-card-title text-on-surface tracking-tight">StokKu</span>
        </div>
        {{-- User info + tombol keluar --}}
        <div class="flex items-center gap-space-md">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-full bg-[#EDE7FA] border border-[#C9B8EC]/40 flex items-center justify-center text-[#4d3f6b]">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                </div>
                <span class="font-medium text-body-small text-[#20133d]">{{ session('username', '-') }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="h-10 px-4 rounded-[14px] border border-[#E8E1EC] bg-white text-[#20133d] font-body-small text-body-small font-medium hover:bg-surface-container-low transition-colors flex items-center gap-2 cursor-pointer shadow-sm">
                    <span class="material-symbols-outlined text-[18px] text-[#504446]">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </header>

    {{-- ===== SIDEBAR (fixed, dinamis per role) ===== --}}
    <aside class="fixed left-0 top-[72px] bottom-0 w-[260px] bg-surface-container-lowest border-r border-surface-container-highest py-6 px-4 z-40 overflow-y-auto">
        <nav class="flex flex-col gap-1.5">
            @php
                // Daftar menu sidebar per role
                $role = session('role', '');
                $menus = [];

                if ($role === 'Admin') {
                    $menus = [
                        ['url' => '/admin/dashboard', 'icon' => 'dashboard',             'label' => 'Dashboard'],
                        ['url' => '/admin/satuan',    'icon' => 'straighten',             'label' => 'Satuan'],
                        ['url' => '/admin/barang',    'icon' => 'inventory_2',            'label' => 'Barang'],
                        ['url' => '/admin/vendor',    'icon' => 'storefront',             'label' => 'Vendor'],
                        ['url' => '/admin/user',      'icon' => 'group',                  'label' => 'User'],
                        ['url' => '/admin/role',      'icon' => 'admin_panel_settings',   'label' => 'Role'],
                        ['url' => '/admin/margin',    'icon' => 'percent',                'label' => 'Margin Penjualan'],
                        ['url' => '/kasir/penjualan', 'icon' => 'point_of_sale',         'label' => 'Kasir Penjualan'],
                    ];
                } elseif ($role === 'Manager') {
                    $menus = [
                        ['url' => '/manager/dashboard',  'icon' => 'dashboard',    'label' => 'Dashboard'],
                        ['url' => '/manager/pengadaan',  'icon' => 'inventory',    'label' => 'Pengadaan'],
                    ];
                } elseif ($role === 'Gudang') {
                    $menus = [
                        ['url' => '/gudang/dashboard',   'icon' => 'dashboard',           'label' => 'Dashboard'],
                        ['url' => '/gudang/penerimaan',  'icon' => 'assignment_turned_in', 'label' => 'Penerimaan'],
                        ['url' => '/gudang/retur',       'icon' => 'assignment_return',   'label' => 'Retur'],
                        ['url' => '/gudang/kartu-stok',  'icon' => 'receipt_long',        'label' => 'Kartu Stok'],
                    ];
                } elseif ($role === 'Kasir') {
                    $menus = [
                        ['url' => '/kasir/penjualan',    'icon' => 'point_of_sale',       'label' => 'Kasir Penjualan'],
                    ];
                }
            @endphp

            @foreach ($menus as $menu)
                @php
                    $isActive = request()->is(ltrim($menu['url'], '/') . '*') || request()->url() === url($menu['url']);
                @endphp

                @if ($isActive)
                    <a href="{{ $menu['url'] }}" aria-current="page"
                       class="h-12 px-4 rounded-[14px] flex items-center gap-3 transition-colors bg-[#EDE7FA] text-[#20133d] border border-[#C9B8EC]/30 font-semibold">
                        <span class="material-symbols-outlined text-[20px] text-[#4d3f6b]">{{ $menu['icon'] }}</span>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @else
                    <a href="{{ $menu['url'] }}"
                       class="h-12 px-4 rounded-[14px] flex items-center gap-space-sm text-on-surface font-body-small text-body-small hover:bg-surface-container-low hover:text-on-surface transition-colors">
                        <span class="material-symbols-outlined text-[20px]">{{ $menu['icon'] }}</span>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </nav>
    </aside>

    {{-- ===== AREA KONTEN ===== --}}
    <div class="pl-[260px]">
        <main class="min-h-screen pt-[72px] bg-surface-container-lowest p-margin max-w-[1440px]">
            {{-- Pesan sukses/error --}}
            @if (session('sukses'))
                <div class="mb-4 p-3.5 rounded-[12px] bg-tertiary-fixed border border-tertiary-container/30 flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[18px] text-on-tertiary-container">check_circle</span>
                    <span class="font-caption text-caption text-on-tertiary-container font-medium">{{ session('sukses') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-3.5 rounded-[12px] bg-error-container border border-error/30 flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[18px] text-on-error-container">error</span>
                    <span class="font-caption text-caption text-on-error-container font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
