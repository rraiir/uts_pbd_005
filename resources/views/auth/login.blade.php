<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StokKu - Masuk</title>

    {{-- Google Fonts --}}
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
                borderRadius: { DEFAULT: "0.25rem", lg: "0.5rem", xl: "0.75rem", full: "9999px" },
                spacing: { "space-md": "1rem", "space-sm": "0.75rem", "space-xl": "3rem", "space-lg": "1.5rem", "gutter": "1.5rem", "space-xs": "0.5rem", "margin": "3rem" },
                fontFamily: { "login-headline": ["Inter"], "card-title": ["Inter"], "body": ["Inter"], "caption": ["Inter"], "section-title": ["Inter"], "badge": ["Inter"], "page-title": ["Inter"], "body-small": ["Inter"] },
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
    <style>
    @layer base { html, body { margin: 0; padding: 0; } body { overscroll-behavior: none; } }
    ::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-surface-container-lowest font-body text-body text-on-surface min-h-screen flex items-center justify-center p-gutter antialiased">
<main class="w-full max-w-[1440px] mx-auto flex items-center justify-center">
<div class="flex flex-col w-full relative min-h-[860px] items-center justify-center overflow-hidden py-12 px-6">

    {{-- Elemen dekoratif latar (SVG blob dari Stitch) --}}
    <div aria-hidden="true" class="absolute -top-16 -left-16 w-80 h-80 pointer-events-none select-none z-0">
        <svg class="w-full h-full" fill="none" viewBox="0 0 200 200">
            <path d="M48.2,-64.3C61.4,-54.6,70.6,-39.8,74.8,-23.7C79,-7.6,78.2,9.7,72.4,25.2C66.6,40.6,55.8,54.1,42.1,62.8C28.4,71.5,11.8,75.4,-4.1,81.1C-20,86.8,-35.3,94.3,-47.9,88.7C-60.5,83.1,-70.5,64.4,-77.2,46.1C-84,27.8,-87.6,10,-84.3,-6.2C-81,-22.4,-70.9,-37,-57.9,-46.8C-45,-56.6,-29.3,-61.5,-13.7,-64.2C1.9,-66.8,35,-67.2,48.2,-64.3Z" fill="#EDE7FA" fill-opacity="0.9" transform="translate(100 100)"></path>
            <g transform="translate(90, 85)">
                <circle cx="0" cy="-22" fill="#C9B8EC" r="14"></circle>
                <circle cx="22" cy="0" fill="#C9B8EC" r="14"></circle>
                <circle cx="0" cy="22" fill="#C9B8EC" r="14"></circle>
                <circle cx="-22" cy="0" fill="#C9B8EC" r="14"></circle>
                <circle cx="0" cy="0" fill="#D8A7B1" r="12"></circle>
            </g>
        </svg>
    </div>
    <div aria-hidden="true" class="absolute -top-12 -right-12 w-72 h-72 pointer-events-none select-none z-0">
        <svg class="w-full h-full" fill="none" viewBox="0 0 200 200">
            <path d="M42.7,-58.2C54.9,-49.9,64,-36.8,69.1,-22.1C74.3,-7.4,75.4,8.8,70.5,23.1C65.6,37.3,54.6,49.6,41.4,58C28.2,66.4,12.7,71,-3.1,75.3C-18.9,79.5,-35,83.5,-47.5,76.5C-60,69.5,-69,51.6,-74.6,34.4C-80.2,17.2,-82.5,0.7,-79.1,-14.8C-75.7,-30.3,-66.7,-44.7,-54.1,-52.9C-41.5,-61.1,-25.3,-63,-9.4,-64.3C6.5,-65.5,30.5,-66.5,42.7,-58.2Z" fill="#F6E3E7" fill-opacity="0.95" transform="translate(100 100)"></path>
            <g transform="translate(110, 95)">
                <rect fill="#D8A7B1" height="36" rx="18" width="36" x="-18" y="-18"></rect>
                <circle cx="0" cy="-24" fill="#EDE7FA" r="11"></circle>
                <circle cx="24" cy="0" fill="#EDE7FA" r="11"></circle>
                <circle cx="0" cy="24" fill="#EDE7FA" r="11"></circle>
                <circle cx="-24" cy="0" fill="#EDE7FA" r="11"></circle>
            </g>
        </svg>
    </div>
    <div aria-hidden="true" class="absolute -bottom-20 -left-16 w-80 h-80 pointer-events-none select-none z-0">
        <svg class="w-full h-full" fill="none" viewBox="0 0 200 200">
            <path d="M37.8,-53.4C49.9,-44.7,61.4,-35.1,67.7,-22.4C74,-9.7,75.2,6.1,70.9,20.4C66.5,34.7,56.7,47.5,44.1,56.3C31.5,65.1,16.2,69.9,0.3,69.5C-15.6,69.1,-30.7,63.5,-43.6,54.6C-56.5,45.7,-67.2,33.5,-72.4,19C-77.5,4.6,-77.2,-12.1,-70.7,-25.5C-64.2,-38.9,-51.5,-48.9,-38.4,-57.4C-25.3,-65.8,-11.9,-72.7,0.8,-73.8C13.5,-74.9,25.7,-62.1,37.8,-53.4Z" fill="#F6E3E7" fill-opacity="0.85" transform="translate(100 100)"></path>
        </svg>
    </div>
    <div aria-hidden="true" class="absolute -bottom-16 -right-16 w-72 h-72 pointer-events-none select-none z-0">
        <svg class="w-full h-full" fill="none" viewBox="0 0 200 200">
            <path d="M45.5,-59.8C59.5,-52.1,71.9,-39.8,76.5,-24.8C81.1,-9.8,77.9,7.9,71.2,24C64.4,40.1,54.1,54.6,40.4,63.7C26.7,72.8,9.7,76.6,-6.9,76.1C-23.6,75.7,-39.9,71,-52.8,61.5C-65.7,52,-75.2,37.7,-79.6,21.8C-84,5.9,-83.4,-11.6,-76.3,-26.2C-69.2,-40.8,-55.7,-52.5,-41.2,-60C-26.7,-67.5,-11.2,-70.8,3.2,-75.2C17.6,-79.6,31.5,-67.5,45.5,-59.8Z" fill="#EDE7FA" fill-opacity="0.9" transform="translate(100 100)"></path>
            <g transform="translate(85, 90)">
                <circle cx="0" cy="0" fill="#C9B8EC" r="16"></circle>
                <circle cx="0" cy="-26" fill="#D8A7B1" r="10"></circle>
                <circle cx="26" cy="0" fill="#D8A7B1" r="10"></circle>
                <circle cx="0" cy="26" fill="#D8A7B1" r="10"></circle>
                <circle cx="-26" cy="0" fill="#D8A7B1" r="10"></circle>
            </g>
        </svg>
    </div>

    {{-- Konten login --}}
    <div class="relative z-10 flex flex-col items-center w-full max-w-[820px] mx-auto">

        {{-- Header + stiker --}}
        <div class="relative flex flex-col items-center text-center">
            {{-- Stiker kiri atas --}}
            <div class="absolute -top-6 -left-8 md:-left-20 transform -rotate-6 select-none shadow-sm">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-caption font-caption text-on-surface bg-[#BFE8D6] border border-[#9FD9C1]">
                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                    Stok rapi
                </span>
            </div>
            {{-- Stiker kanan atas --}}
            <div class="absolute -top-4 -right-6 md:-right-24 transform rotate-6 select-none shadow-sm">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-caption font-caption text-on-surface bg-[#FBEFB5] border border-[#ECDDA1]">
                    <span class="material-symbols-outlined text-[14px]">receipt_long</span>
                    Transaksi tercatat
                </span>
            </div>

            {{-- Judul utama --}}
            <h1 class="font-login-headline text-login-headline text-on-surface tracking-tight text-center flex flex-wrap items-center justify-center gap-x-4 gap-y-1">
                <span>Welcome to</span>
                <span class="inline-block bg-primary-container text-on-surface px-4 py-2 rounded-lg [transform:rotate(2deg)] shadow-sm">StokKu</span>
            </h1>

            <p class="font-body text-body text-[#6F6677] mt-3 max-w-md text-center">
                Catat stok, pengadaan, dan penjualan dengan rapi.
            </p>
        </div>

        {{-- Form Login --}}
        <div class="w-full max-w-[440px] mt-12 bg-surface-container-lowest rounded-[20px] border border-[#E8E1EC] p-8 md:p-10 shadow-[0_8px_24px_rgba(43,38,48,0.06)] relative">

            {{-- Pesan error login --}}
            @if (session('error'))
                <div class="mb-4 p-3 rounded-xl bg-error-container border border-error/30 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-on-error-container">error</span>
                    <span class="font-caption text-caption text-on-error-container font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <form class="flex flex-col gap-6" action="{{ route('login.proses') }}" method="POST">
                @csrf
                {{-- Username --}}
                <div class="flex flex-col text-left">
                    <label class="font-body-small text-body-small font-medium text-on-surface mb-2" for="username">Username</label>
                    <input autocomplete="username"
                    class="h-12 w-full rounded-xl border border-[#E8E1EC] bg-surface-container-lowest px-4 font-body text-body text-on-surface placeholder-[#6F6677] outline-none transition-colors focus:border-primary-container focus:ring-2 focus:ring-[#F6E3E7]"
                    id="username" name="username" placeholder="Masukkan username" required type="text"
                    value="{{ old('username') }}">
                </div>

                {{-- Password --}}
                <div class="flex flex-col text-left">
                    <label class="font-body-small text-body-small font-medium text-on-surface mb-2" for="password">Password</label>
                    <div class="relative w-full">
                        <input autocomplete="current-password"
                    class="h-12 w-full rounded-xl border border-[#E8E1EC] bg-surface-container-lowest pl-4 pr-12 font-body text-body text-on-surface placeholder-[#6F6677] outline-none transition-colors focus:border-primary-container focus:ring-2 focus:ring-[#F6E3E7]"
                    id="password" name="password" placeholder="Masukkan password" required type="password">
                        <button aria-label="Tampilkan atau sembunyikan kata sandi"
                                class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center justify-center p-1.5 text-[#6F6677] hover:text-on-surface transition-colors rounded-lg focus:outline-none"
                                id="togglePassword" type="button">
                            <span class="material-symbols-outlined text-[20px]" id="eyeIcon">visibility</span>
                        </button>
                    </div>
                </div>

                {{-- Tombol Masuk --}}
                <button class="h-12 w-full rounded-[14px] bg-primary-container text-on-surface font-body text-body font-semibold flex items-center justify-center transition-all hover:opacity-90 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#F6E3E7] mt-2 cursor-pointer"
                        type="submit">
                    Masuk
                </button>
            </form>

            {{-- Stiker dekoratif di sekitar card --}}
            <div class="hidden md:flex absolute -left-36 top-12 pointer-events-none select-none z-10 transform -rotate-3">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[13px] font-medium text-[#2B2630] bg-[#FBEFB5] border border-[#ECDDA1] shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">query_stats</span>Pantau real-time
                </span>
            </div>
            <div class="hidden md:flex absolute -left-44 bottom-14 pointer-events-none select-none z-10 transform rotate-3">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[13px] font-medium text-[#2B2630] bg-[#EDE7FA] border border-[#D5C7F2] shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">analytics</span>Laporan otomatis
                </span>
            </div>
            <div class="hidden md:flex absolute -right-36 top-16 pointer-events-none select-none z-10 transform rotate-2">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[13px] font-medium text-[#2B2630] bg-[#BFE8D6] border border-[#9FD9C1] shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">warehouse</span>Multi-gudang siap
                </span>
            </div>
            <div class="hidden md:flex absolute -right-40 bottom-12 pointer-events-none select-none z-10 transform -rotate-3">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[13px] font-medium text-[#2B2630] bg-[#F6E3E7] border border-[#EABEC6] shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">verified_user</span>Inventaris aman
                </span>
            </div>
        </div>
    </div>
</div>

{{-- Toggle password visibility --}}
<script>
(function() {
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    if (toggleBtn && passwordInput && eyeIcon) {
        toggleBtn.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            eyeIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
        });
    }
})();
</script>

</main>
</body>
</html>
