<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RapidTech.mrq – Servis Laptop Merauke</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/jpeg" href="/images/logo.png" />
    <link rel="shortcut icon" href="/images/logo.png" />

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#3B82F6',
                            blueDim: '#1D4ED8',
                            dark: '#0D0F14',
                            card: '#13161E',
                            border: '#1E2330',
                            muted: '#6B7280',
                            text: '#E2E8F0',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.7s ease both',
                        'glow-pulse': 'glowPulse 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(24px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        glowPulse: {
                            '0%, 100%': {
                                boxShadow: '0 0 20px 2px rgba(59,130,246,0.25)'
                            },
                            '50%': {
                                boxShadow: '0 0 40px 8px rgba(59,130,246,0.45)'
                            },
                        }
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap"
        rel="stylesheet" />

    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    {{-- Leaflet.js (OpenStreetMap) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        /* ── Base ─────────────────────────────────────────────── */
        html,
        body {
            background-color: #0D0F14;
            color: #E2E8F0;
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        /* ── Light Mode Base ──────────────────────────────────── */
        html.light body {
            background-color: #F0F4FF;
            color: #1E2330;
        }

        /* Scanline texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: repeating-linear-gradient(0deg,
                    rgba(255, 255, 255, 0.015) 0px,
                    rgba(255, 255, 255, 0.015) 1px,
                    transparent 1px,
                    transparent 4px);
            pointer-events: none;
            z-index: 0;
            transition: opacity 0.4s ease;
        }

        html.light body::before {
            opacity: 0.3;
        }

        /* ── Hero orb ─────────────────────────────────────────── */
        .hero-orb {
            position: absolute;
            width: 700px;
            height: 700px;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.18) 0%, transparent 70%);
            filter: blur(60px);
            top: -120px;
            left: 50%;
            transform: translateX(-50%);
            animation: glowPulse 4s ease-in-out infinite;
        }

        /* ── Navbar glass ─────────────────────────────────────── */
        .navbar-glass {
            background: rgba(13, 15, 20, 0.82);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(30, 35, 48, 0.8);
            transition: background 0.4s ease, border-color 0.4s ease;
        }

        html.light .navbar-glass {
            background: rgba(240, 244, 255, 0.88);
            border-bottom: 1px solid rgba(203, 213, 225, 0.8);
        }

        /* ── Mobile menu transition ───────────────────────────── */
        #mobile-menu {
            transition: max-height 0.35s ease, opacity 0.35s ease;
        }

        /* ── CTA button glow ──────────────────────────────────── */
        .btn-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            transition: box-shadow 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 0 24px 6px rgba(59, 130, 246, 0.4);
            transform: translateY(-2px);
        }

        /* ── Stat card ────────────────────────────────────────── */
        .stat-card {
            border: 1px solid #1E2330;
            background: rgba(19, 22, 30, 0.7);
            transition: border-color 0.3s, background 0.4s ease;
        }

        .stat-card:hover {
            border-color: rgba(59, 130, 246, 0.4);
        }

        html.light .stat-card {
            border: 1px solid #CBD5E1;
            background: rgba(255, 255, 255, 0.8);
        }

        /* ── Light mode: brand overrides ─────────────────────── */
        html.light .text-brand-text { color: #1E2330 !important; }
        html.light .text-brand-muted { color: #64748B !important; }
        html.light .bg-brand-card { background-color: #FFFFFF !important; }
        html.light .bg-brand-dark { background-color: #F0F4FF !important; }
        html.light .border-brand-border { border-color: #CBD5E1 !important; }
        html.light .border-t.border-brand-border { border-color: #CBD5E1 !important; }

        html.light [class*="bg-brand-card"] {
            background-color: #FFFFFF;
        }
        html.light [class*="border-brand-border"] {
            border-color: #CBD5E1;
        }
        html.light [class*="bg-brand-dark"] {
            background-color: #F0F4FF;
        }
        html.light footer {
            background-color: #E8EDF8;
            border-top-color: #CBD5E1;
        }
        html.light .hero-orb {
            background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
        }

        /* ── Theme Toggle Button ─────────────────────────────── */
        #theme-toggle {
            position: relative;
            width: 44px;
            height: 24px;
            border-radius: 9999px;
            background: linear-gradient(135deg, #1D4ED8, #3B82F6);
            border: none;
            cursor: pointer;
            transition: background 0.4s ease, box-shadow 0.3s ease;
            box-shadow: 0 0 10px 2px rgba(59, 130, 246, 0.3);
            flex-shrink: 0;
        }

        html.light #theme-toggle {
            background: linear-gradient(135deg, #F59E0B, #FBBF24);
            box-shadow: 0 0 10px 2px rgba(251, 191, 36, 0.4);
        }

        #theme-toggle-thumb {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 18px;
            height: 18px;
            border-radius: 9999px;
            background: white;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        html.light #theme-toggle-thumb {
            transform: translateX(20px);
        }

        #theme-toggle-icon-moon { display: inline; }
        #theme-toggle-icon-sun { display: none; }
        html.light #theme-toggle-icon-moon { display: none; }
        html.light #theme-toggle-icon-sun { display: inline; }

        /* ── Cara Kerja: travelling dot ───────────────────────── */
        @keyframes travelDot {
            0% {
                left: 0%;
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                left: 100%;
                opacity: 0;
            }
        }

        /* ── Animation delay utilities ────────────────────────── */
        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-500 {
            animation-delay: 0.5s;
        }

        /* ── WA Team Modal ────────────────────────────────────── */
        #wa-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(7, 9, 14, 0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        #wa-modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        #wa-modal {
            background: linear-gradient(135deg, #13161E 0%, #0D0F14 100%);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 24px;
            padding: 2rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 0 60px 10px rgba(59, 130, 246, 0.12),
                0 25px 50px rgba(0, 0, 0, 0.6);
            transform: translateY(24px) scale(0.97);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1),
                opacity 0.3s ease;
            opacity: 0;
            position: relative;
            overflow: hidden;
        }

        #wa-modal-overlay.open #wa-modal {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        #wa-modal::before {
            content: '';
            position: absolute;
            top: -80px;
            left: -80px;
            width: 240px;
            height: 240px;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        #wa-modal::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -60px;
            width: 180px;
            height: 180px;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .wa-contact-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid rgba(30, 35, 48, 0.8);
            background: rgba(19, 22, 30, 0.6);
            text-decoration: none;
            transition: border-color 0.25s ease, background 0.25s ease,
                transform 0.25s ease, box-shadow 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .wa-contact-card:hover {
            border-color: rgba(37, 211, 102, 0.45);
            background: rgba(37, 211, 102, 0.07);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.1);
        }

        .wa-contact-card .wa-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1a472a 0%, #15803d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            color: #4ade80;
            font-family: 'JetBrains Mono', monospace;
            flex-shrink: 0;
            border: 1px solid rgba(74, 222, 128, 0.2);
        }

        .wa-contact-card .wa-info {
            flex: 1;
            min-width: 0;
        }

        .wa-contact-card .wa-name {
            font-size: 14px;
            font-weight: 700;
            color: #E2E8F0;
            margin-bottom: 2px;
        }

        .wa-contact-card .wa-number {
            font-size: 12px;
            font-family: 'JetBrains Mono', monospace;
            color: #6B7280;
        }

        .wa-contact-card .wa-btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(37, 211, 102, 0.12);
            border: 1px solid rgba(37, 211, 102, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #25D366;
            font-size: 16px;
            flex-shrink: 0;
            transition: background 0.2s, border-color 0.2s;
        }

        .wa-contact-card:hover .wa-btn-icon {
            background: rgba(37, 211, 102, 0.22);
            border-color: rgba(37, 211, 102, 0.4);
        }

        @keyframes modalCardIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #wa-modal-overlay.open .wa-contact-card:nth-child(1) {
            animation: modalCardIn 0.4s ease 0.1s both;
        }

        #wa-modal-overlay.open .wa-contact-card:nth-child(2) {
            animation: modalCardIn 0.4s ease 0.18s both;
        }

        #wa-modal-overlay.open .wa-contact-card:nth-child(3) {
            animation: modalCardIn 0.4s ease 0.26s both;
        }

        #wa-modal-overlay.open .wa-contact-card:nth-child(4) {
            animation: modalCardIn 0.4s ease 0.34s both;
        }
    </style>
</head>

<body class="dark font-sans antialiased relative">

    {{-- ================================================================ --}}
    {{--  NAVBAR                                                           --}}
    {{-- ================================================================ --}}
    <header class="navbar-glass fixed top-0 inset-x-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="#" class="flex items-center gap-2 group">
                    <img src="/images/logo.png" alt="RapidTech.mrq Logo"
                        class="w-8 h-8 rounded-lg object-cover
                                ring-1 ring-blue-600/40
                                group-hover:ring-blue-500/70 transition-all duration-200" />
                    <span class="text-lg font-bold tracking-tight text-brand-text">
                        Rapid<span class="text-brand-blue">Tech</span><span
                            class="text-brand-muted font-light">.mrq</span>
                    </span>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center gap-1">
                    @foreach ([['href' => '#about', 'label' => 'Tentang Kami'], ['href' => '#services', 'label' => 'Layanan'], ['href' => '#how', 'label' => 'Cara Kerja'], ['href' => '#gallery', 'label' => 'Galeri'], ['href' => '#faq', 'label' => 'FAQ'], ['href' => '#location', 'label' => 'Lokasi']] as $item)
                        <a href="{{ $item['href'] }}"
                            class="px-4 py-2 rounded-md text-sm font-medium text-brand-muted
                              hover:text-brand-text hover:bg-brand-border transition-all duration-200">
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    {{-- Theme Toggle (Desktop) --}}
                    <button id="theme-toggle" aria-label="Toggle dark/light mode" title="Toggle mode">
                        <div id="theme-toggle-thumb">
                            <span id="theme-toggle-icon-moon" style="color:#1D4ED8;">🌙</span>
                            <span id="theme-toggle-icon-sun" style="color:#F59E0B;">☀️</span>
                        </div>
                    </button>

                    <a href="#contact"
                        class="ml-4 btn-primary flex items-center gap-2 px-4 py-2 rounded-lg
                           text-sm font-semibold text-white">
                        <i class="fa-solid fa-headset text-xs"></i>
                        Butuh Bantuan
                    </a>
                </div>

                {{-- Mobile: Theme toggle + Hamburger --}}
                <div class="md:hidden flex items-center gap-2">
                    <button id="theme-toggle-mobile" onclick="toggleTheme()"
                        aria-label="Toggle dark/light mode"
                        class="flex items-center justify-center w-9 h-9 rounded-lg
                               text-brand-muted hover:text-brand-text hover:bg-brand-border transition">
                        <i class="fa-solid fa-moon text-sm text-brand-blue" id="mobile-header-icon-moon"></i>
                        <i class="fa-solid fa-sun text-sm text-yellow-400 hidden" id="mobile-header-icon-sun"></i>
                    </button>
                    <button id="menu-btn"
                        class="flex items-center justify-center w-9 h-9 rounded-lg
                                text-brand-muted hover:text-brand-text hover:bg-brand-border transition"
                        aria-label="Buka menu">
                        <i class="fa-solid fa-bars text-base" id="menu-icon"></i>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu Dropdown --}}
            <div id="mobile-menu" class="md:hidden overflow-hidden max-h-0 opacity-0">
                <div class="pb-4 pt-2 flex flex-col gap-1 border-t border-brand-border mt-1">
                    @foreach ([['href' => '#about', 'icon' => 'fa-circle-info', 'label' => 'Tentang Kami'], ['href' => '#services', 'icon' => 'fa-screwdriver-wrench', 'label' => 'Layanan'], ['href' => '#how', 'icon' => 'fa-list-check', 'label' => 'Cara Kerja'], ['href' => '#gallery', 'icon' => 'fa-images', 'label' => 'Galeri'], ['href' => '#faq', 'icon' => 'fa-circle-question', 'label' => 'FAQ'], ['href' => '#location', 'icon' => 'fa-location-dot', 'label' => 'Lokasi'], ['href' => '#contact', 'icon' => 'fa-headset', 'label' => 'Butuh Bantuan']] as $item)
                        <a href="{{ $item['href'] }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium
                               text-brand-muted hover:text-brand-text hover:bg-brand-border transition">
                            <i class="fa-solid {{ $item['icon'] }} w-4 text-brand-blue"></i>
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    {{-- Mobile Theme Toggle --}}
                    <button onclick="toggleTheme()"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium
                               text-brand-muted hover:text-brand-text hover:bg-brand-border transition w-full text-left"
                        id="mobile-theme-btn">
                        <i class="fa-solid fa-circle-half-stroke w-4 text-brand-blue"></i>
                        <span id="mobile-theme-label">Mode Terang</span>
                    </button>
                </div>
            </div>
        </nav>
    </header>
    {{-- /NAVBAR --}}


    {{-- ================================================================ --}}
    {{--  HERO SECTION                                                     --}}
    {{-- ================================================================ --}}
    <section id="hero" class="relative min-h-screen flex items-center overflow-hidden pt-16">

        {{-- Background orb --}}
        <div class="hero-orb" aria-hidden="true"></div>

        {{-- Grid dot background --}}
        <div class="absolute inset-0 z-0"
            style="background-image: radial-gradient(rgba(59,130,246,0.12) 1px, transparent 1px);
                background-size: 36px 36px;">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 w-full">
            <div class="max-w-3xl mx-auto text-center">

                {{-- Eyebrow badge --}}
                <div
                    class="animate-fade-up inline-flex items-center gap-2 px-3 py-1.5 mb-6
                         rounded-full border border-blue-600/30 bg-blue-600/10 text-blue-400
                         text-xs font-mono font-medium tracking-widest uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    Merauke &mdash; Jasa Servis Laptop Profesional
                </div>

                {{-- Headline --}}
                <h1
                    class="animate-fade-up delay-100 text-4xl sm:text-5xl lg:text-6xl font-extrabold
                        leading-tight tracking-tight text-brand-text mb-6">
                    Kembalikan Performa
                    <span class="relative inline-block">
                        <span class="text-brand-blue">Laptopmu</span>
                        <svg class="absolute -bottom-1 left-0 w-full" viewBox="0 0 220 10"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M2 8 Q110 2 218 8" stroke="#3B82F6" stroke-width="2.5" fill="none"
                                stroke-linecap="round" opacity="0.6" />
                        </svg>
                    </span>
                    <br />Seperti Baru.
                </h1>

                {{-- Subheading --}}
                <p
                    class="animate-fade-up delay-200 text-base sm:text-lg text-brand-muted
                       leading-relaxed max-w-xl mx-auto mb-10">
                    RapidTech.mrq hadir untuk menangani laptop lambat, overheat, hingga
                    masalah sistem operasi yang bikin kerja terhambat —
                    <span class="text-brand-text font-medium">cepat, tuntas, dan bergaransi</span>.
                </p>

                {{-- Problem Pills --}}
                <div class="animate-fade-up delay-300 flex flex-wrap justify-center gap-2 mb-10">
                    @foreach ([['icon' => 'fa-gauge-high', 'text' => 'Laptop Lambat'], ['icon' => 'fa-temperature-high', 'text' => 'Overheat'], ['icon' => 'fa-hard-drive', 'text' => 'Instal / Repair OS'], ['icon' => 'fa-battery-quarter', 'text' => 'Baterai Drop'], ['icon' => 'fa-display', 'text' => 'Layar Rusak']] as $pill)
                        <span
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                  bg-brand-card border border-brand-border
                                  text-xs font-medium text-brand-muted">
                            <i class="fa-solid {{ $pill['icon'] }} text-brand-blue text-[10px]"></i>
                            {{ $pill['text'] }}
                        </span>
                    @endforeach
                </div>

                {{-- CTA Buttons --}}
                <div class="animate-fade-up delay-500 flex flex-col sm:flex-row justify-center gap-3">
                    <a href="#services"
                        class="btn-primary inline-flex items-center justify-center gap-2
                          px-7 py-3.5 rounded-xl text-sm font-bold text-white">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        Lihat Layanan Kami
                    </a>
                    <a href="https://wa.me/6282199547682" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-2
                          px-7 py-3.5 rounded-xl text-sm font-semibold
                          border border-brand-border text-brand-text
                          hover:border-blue-600/50 hover:bg-brand-card transition-all duration-200">
                        <i class="fa-brands fa-whatsapp text-green-400"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>

                {{-- Trust Stats --}}
                <div class="animate-fade-up delay-500 mt-16 grid grid-cols-3 gap-4 max-w-lg mx-auto">
                    @foreach ([['value' => '50+', 'label' => 'Laptop Ditangani'], ['value' => '< 48j', 'label' => 'Rata-rata Selesai'], ['value' => '100%', 'label' => 'Bergaransi']] as $stat)
                        <div class="stat-card rounded-xl p-4 text-center">
                            <p class="text-2xl font-extrabold font-mono text-brand-blue">
                                {{ $stat['value'] }}
                            </p>
                            <p class="text-xs text-brand-muted mt-0.5 leading-snug">
                                {{ $stat['label'] }}
                            </p>
                        </div>
                    @endforeach
                </div>

                {{-- Scroll indicator --}}
                <div class="mt-16 flex justify-center">
                    <a href="#services"
                        class="flex flex-col items-center gap-1.5 text-brand-muted
                           hover:text-brand-blue transition group">
                        <span class="text-xs font-mono tracking-widest uppercase opacity-60">Scroll</span>
                        <i
                            class="fa-solid fa-chevron-down text-sm animate-bounce
                               group-hover:text-brand-blue"></i>
                    </a>
                </div>

            </div>
        </div>
    </section>
    {{-- /HERO --}}


    {{-- ================================================================ --}}
    {{--  LAYANAN & HARGA                                                  --}}
    {{-- ================================================================ --}}
    <section id="services" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8">
        <div
            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r
                 from-transparent via-blue-600/30 to-transparent">
        </div>

        <div class="max-w-7xl mx-auto">

            <div class="text-center mb-14">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full
                         border border-blue-600/30 bg-blue-600/10 text-blue-400
                         text-xs font-mono font-medium tracking-widest uppercase">
                    <i class="fa-solid fa-screwdriver-wrench text-[10px]"></i>
                    Layanan & Harga
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-text tracking-tight">
                    Pilih Layanan yang Kamu Butuhkan
                </h2>
                <p class="mt-3 text-brand-muted text-base max-w-xl mx-auto">
                    Harga transparan, tanpa biaya tersembunyi. Semua layanan mencakup garansi pengerjaan.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                {{-- Card 1: Install Ulang --}}
                <div
                    class="relative flex flex-col rounded-2xl border border-brand-border
                         bg-brand-card p-6 hover:border-blue-600/40
                         hover:-translate-y-1 transition-all duration-300 group">
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-600/15 flex items-center
                             justify-center mb-5">
                        <i class="fa-solid fa-arrow-rotate-right text-blue-400 text-lg"></i>
                    </div>
                    <h3 class="text-base font-bold text-brand-text mb-1">Install Ulang OS</h3>
                    <p class="text-xs text-brand-muted leading-relaxed mb-4 flex-1">
                        Windows 10 / 11 bersih. Termasuk driver dasar, aktivasi trial, dan setup awal.
                    </p>
                    <div class="mb-5">
                        <span class="text-xs text-brand-muted font-mono">Mulai dari</span>
                        <p class="text-2xl font-extrabold font-mono text-brand-text mt-0.5">
                            Rp 100<span class="text-brand-blue">k</span>
                        </p>
                    </div>
                    <a href="https://wa.me/6282199547682?text=Halo%20RapidTech,%20saya%20mau%20order%20jasa%20Install%20Ulang%20OS"
                        target="_blank" rel="noopener noreferrer"
                        class="w-full flex items-center justify-center gap-2 py-2.5 px-4
                           rounded-xl border border-brand-border text-sm font-semibold
                           text-brand-text hover:border-blue-500 hover:text-blue-400
                           hover:bg-blue-600/10 transition-all duration-200">
                        <i class="fa-brands fa-whatsapp text-green-400 text-sm"></i>
                        Pesan Sekarang
                    </a>
                </div>

                {{-- Card 2: Lisensi Win 11 Pro --}}
                <div
                    class="relative flex flex-col rounded-2xl border border-brand-border
                         bg-brand-card p-6 hover:border-blue-600/40
                         hover:-translate-y-1 transition-all duration-300 group">
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-600/15 flex items-center
                             justify-center mb-5">
                        <i class="fa-brands fa-windows text-blue-400 text-lg"></i>
                    </div>
                    <h3 class="text-base font-bold text-brand-text mb-1">Lisensi Windows 11 Pro</h3>
                    <p class="text-xs text-brand-muted leading-relaxed mb-4 flex-1">
                        Aktivasi permanen Windows 11 Pro original. Aman, legal, dan tidak akan expired.
                    </p>
                    <div class="mb-5">
                        <span class="text-xs text-brand-muted font-mono">Harga</span>
                        <p class="text-2xl font-extrabold font-mono text-brand-text mt-0.5">
                            Rp 150<span class="text-brand-blue">k</span>
                        </p>
                    </div>
                    <a href="https://wa.me/6282199547682?text=Halo%20RapidTech,%20saya%20mau%20order%20jasa%20Lisensi%20Windows%2011%20Pro"
                        target="_blank" rel="noopener noreferrer"
                        class="w-full flex items-center justify-center gap-2 py-2.5 px-4
                           rounded-xl border border-brand-border text-sm font-semibold
                           text-brand-text hover:border-blue-500 hover:text-blue-400
                           hover:bg-blue-600/10 transition-all duration-200">
                        <i class="fa-brands fa-whatsapp text-green-400 text-sm"></i>
                        Pesan Sekarang
                    </a>
                </div>

                {{-- Card 3: Cleaning Internal --}}
                <div
                    class="relative flex flex-col rounded-2xl border border-brand-border
                         bg-brand-card p-6 hover:border-blue-600/40
                         hover:-translate-y-1 transition-all duration-300 group">
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-600/15 flex items-center
                             justify-center mb-5">
                        <i class="fa-solid fa-wind text-blue-400 text-lg"></i>
                    </div>
                    <h3 class="text-base font-bold text-brand-text mb-1">Cleaning Internal</h3>
                    <p class="text-xs text-brand-muted leading-relaxed mb-4 flex-1">
                        Bersihkan debu di kipas, heatsink, dan komponen internal agar sirkulasi udara optimal.
                    </p>
                    <div class="mb-5">
                        <span class="text-xs text-brand-muted font-mono">Harga</span>
                        <p class="text-2xl font-extrabold font-mono text-brand-text mt-0.5">
                            Rp 50<span class="text-brand-blue">k</span>
                        </p>
                    </div>
                    <a href="https://wa.me/6282199547682?text=Halo%20RapidTech,%20saya%20mau%20order%20jasa%20Cleaning%20Internal"
                        target="_blank" rel="noopener noreferrer"
                        class="w-full flex items-center justify-center gap-2 py-2.5 px-4
                           rounded-xl border border-brand-border text-sm font-semibold
                           text-brand-text hover:border-blue-500 hover:text-blue-400
                           hover:bg-blue-600/10 transition-all duration-200">
                        <i class="fa-brands fa-whatsapp text-green-400 text-sm"></i>
                        Pesan Sekarang
                    </a>
                </div>

                {{-- Card 4: Cleaning + Repasta — BEST DEAL --}}
                <div
                    class="relative flex flex-col rounded-2xl border-2 border-blue-500
                         bg-gradient-to-b from-blue-600/10 to-brand-card p-6
                         hover:-translate-y-1 transition-all duration-300
                         shadow-[0_0_28px_4px_rgba(59,130,246,0.15)]
                         hover:shadow-[0_0_40px_8px_rgba(59,130,246,0.28)]">
                    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                  bg-blue-500 text-white text-[11px] font-bold tracking-wide
                                  shadow-lg shadow-blue-500/40 uppercase">
                            <i class="fa-solid fa-star text-yellow-300 text-[9px]"></i>
                            Best Deal
                        </span>
                    </div>
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-500/25 flex items-center
                             justify-center mb-5 mt-1">
                        <i class="fa-solid fa-fire-flame-curved text-blue-300 text-lg"></i>
                    </div>
                    <h3 class="text-base font-bold text-blue-200 mb-1">Cleaning + Repasta</h3>
                    <p class="text-xs text-blue-300/70 leading-relaxed mb-4 flex-1">
                        Cleaning menyeluruh ditambah penggantian thermal paste CPU/GPU untuk suhu
                        optimal dan performa maksimal.
                    </p>
                    <div class="mb-5">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs text-blue-400/60 font-mono line-through">Rp 200k</span>
                            <span
                                class="text-[10px] px-1.5 py-0.5 rounded bg-green-500/20
                                      text-green-400 font-bold">HEMAT
                                25%</span>
                        </div>
                        <p class="text-2xl font-extrabold font-mono text-white mt-0.5">
                            Rp 150<span class="text-blue-300">k</span>
                        </p>
                    </div>
                    <a href="https://wa.me/6282199547682?text=Halo%20RapidTech,%20saya%20mau%20order%20jasa%20Cleaning%20dan%20Repasta"
                        target="_blank" rel="noopener noreferrer"
                        class="w-full flex items-center justify-center gap-2 py-2.5 px-4
                           rounded-xl bg-blue-600 hover:bg-blue-500 text-white
                           text-sm font-bold transition-all duration-200
                           shadow-md shadow-blue-600/30">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        Pesan Sekarang
                    </a>
                </div>

            </div>
        </div>
    </section>
    {{-- /LAYANAN & HARGA --}}


    {{-- ================================================================ --}}
    {{--  CARA KERJA                                                       --}}
    {{-- ================================================================ --}}
    <section id="how" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div
            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r
                 from-transparent via-blue-600/30 to-transparent">
        </div>
        <div
            class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r
                 from-transparent via-blue-600/30 to-transparent">
        </div>

        <div class="max-w-5xl mx-auto">

            <div class="text-center mb-16">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full
                         border border-blue-600/30 bg-blue-600/10 text-blue-400
                         text-xs font-mono font-medium tracking-widest uppercase">
                    <i class="fa-solid fa-list-check text-[10px]"></i>
                    Cara Kerja
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-text tracking-tight">
                    Servis Mudah, Tanpa Ribet
                </h2>
                <p class="mt-3 text-brand-muted text-base max-w-lg mx-auto">
                    Cukup 4 langkah dan laptopmu kembali prima — semua dikerjakan langsung di tempat kami.
                </p>
            </div>

            <div class="relative">

                {{-- Connector line (desktop) --}}
                <div class="hidden lg:block absolute top-[52px] left-[12.5%] right-[12.5%] h-px z-0">
                    <div
                        class="w-full h-full bg-gradient-to-r
                             from-blue-600/20 via-blue-500/50 to-blue-600/20 relative">
                        <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 rounded-full
                                 bg-blue-400 shadow-[0_0_10px_3px_rgba(59,130,246,0.6)]"
                            style="animation: travelDot 4s ease-in-out infinite;"></div>
                    </div>
                </div>

                @php
                    $steps = [
                        [
                            'num' => '01',
                            'icon' => 'fa-comments',
                            'title' => 'Konsultasi',
                            'desc' =>
                                'Ceritakan keluhan laptopmu via WhatsApp atau langsung datang ke tempat kami. Gratis, tanpa biaya diagnosa awal.',
                            'color' => 'from-blue-600/20 to-blue-600/5',
                            'ring' => 'ring-blue-500/40',
                        ],
                        [
                            'num' => '02',
                            'icon' => 'fa-magnifying-glass',
                            'title' => 'Diagnosa',
                            'desc' =>
                                'Teknisi kami memeriksa kondisi hardware & software secara menyeluruh, lalu memberikan estimasi biaya sebelum pengerjaan dimulai.',
                            'color' => 'from-blue-600/20 to-blue-600/5',
                            'ring' => 'ring-blue-500/40',
                        ],
                        [
                            'num' => '03',
                            'icon' => 'fa-screwdriver-wrench',
                            'title' => 'Pengerjaan',
                            'desc' =>
                                'Servis dikerjakan langsung oleh teknisi berpengalaman. Kamu bisa menunggu atau meninggalkan laptopmu — estimasi selesai dikirim via WA.',
                            'color' => 'from-blue-600/20 to-blue-600/5',
                            'ring' => 'ring-blue-500/40',
                        ],
                        [
                            'num' => '04',
                            'icon' => 'fa-circle-check',
                            'title' => 'Selesai & Garansi',
                            'desc' =>
                                'Laptop diserahkan kembali beserta laporan singkat hasil servis. Garansi pengerjaan berlaku — ada masalah, kami tanggung jawab.',
                            'color' => 'from-green-600/20 to-green-600/5',
                            'ring' => 'ring-green-500/40',
                        ],
                    ];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-4 relative z-10">
                    @foreach ($steps as $step)
                        <div class="flex flex-col items-center text-center group">
                            <div class="relative mb-5">
                                <div
                                    class="w-[104px] h-[104px] rounded-full border border-brand-border
                                     flex items-center justify-center
                                     bg-gradient-to-b {{ $step['color'] }}
                                     ring-2 ring-transparent group-hover:{{ $step['ring'] }}
                                     transition-all duration-300
                                     group-hover:shadow-[0_0_20px_4px_rgba(59,130,246,0.2)]">
                                    <i
                                        class="fa-solid {{ $step['icon'] }} text-2xl
                                       {{ $loop->last ? 'text-green-400' : 'text-blue-400' }}
                                       group-hover:scale-110 transition-transform duration-300"></i>
                                </div>
                                <span
                                    class="absolute -top-2 -right-2 w-7 h-7 rounded-full
                                      bg-brand-dark border border-brand-border
                                      flex items-center justify-center
                                      text-[11px] font-mono font-bold
                                      {{ $loop->last ? 'text-green-400 border-green-500/30' : 'text-blue-400' }}">
                                    {{ $step['num'] }}
                                </span>
                            </div>

                            @if (!$loop->last)
                                <div
                                    class="lg:hidden w-px h-8 bg-gradient-to-b
                                 from-blue-500/40 to-transparent mb-5">
                                </div>
                            @endif

                            <h3 class="text-base font-bold text-brand-text mb-2">{{ $step['title'] }}</h3>
                            <p class="text-xs text-brand-muted leading-relaxed max-w-[200px]">
                                {{ $step['desc'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-16 text-center">
                <p class="text-sm text-brand-muted mb-4">
                    Siap mulai? Konsultasi pertama gratis — tidak ada kewajiban servis.
                </p>
                <a href="https://wa.me/6282199547682?text=Halo%20RapidTech,%20saya%20mau%20konsultasi%20dulu"
                    target="_blank" rel="noopener noreferrer"
                    class="btn-primary inline-flex items-center gap-2
                       px-6 py-3 rounded-xl text-sm font-bold text-white">
                    <i class="fa-brands fa-whatsapp"></i>
                    Mulai Konsultasi Gratis
                </a>
            </div>

        </div>
    </section>
    {{-- /CARA KERJA --}}


    {{-- ================================================================ --}}
    {{--  GALERI HASIL KERJA                                               --}}
    {{-- ================================================================ --}}
    <section id="gallery" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div
            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r
                     from-transparent via-blue-600/30 to-transparent">
        </div>

        {{-- Subtle background glow --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                     w-[600px] h-[400px] rounded-full
                     bg-radial-[circle] pointer-events-none"
            style="background: radial-gradient(circle, rgba(59,130,246,0.06) 0%, transparent 70%);"></div>

        <div class="max-w-6xl mx-auto">

            {{-- Section Header --}}
            <div class="text-center mb-14">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full
                             border border-blue-600/30 bg-blue-600/10 text-blue-400
                             text-xs font-mono font-medium tracking-widest uppercase">
                    <i class="fa-solid fa-images text-[10px]"></i>
                    Galeri Hasil Kerja
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-text tracking-tight">
                    Bukti Nyata Servis Kami
                </h2>
                <p class="mt-3 text-brand-muted text-base max-w-xl mx-auto">
                    Setiap laptop yang masuk ditangani dengan serius — ini sebagian hasil kerja kami.
                </p>
            </div>

            @php
                $gallery = [
                    [
                        'img' => '/images/gallery/1.jpeg',
                        'tag' => 'Cleaning Internal',
                        'tag_color' => 'blue',
                        'caption' =>
                            'Pembongkaran total laptop gaming — debu 2 tahun dibersihkan dari heatsink & kipas.',
                        'detail' => 'Suhu turun 18°C setelah proses cleaning',
                        'icon' => 'fa-wind',
                    ],
                    [
                        'img' => '/images/gallery/2.jpeg',
                        'tag' => 'Repasta CPU',
                        'tag_color' => 'orange',
                        'caption' =>
                            'Penggantian thermal paste CPU & GPU — laptop kembali dingin dan performa optimal.',
                        'detail' => 'Thermal paste premium grade diganti baru',
                        'icon' => 'fa-fire-flame-curved',
                    ],
                    [
                        'img' => '/images/gallery/3edit.jpeg',
                        'tag' => 'Install Ulang OS',
                        'tag_color' => 'green',
                        'caption' =>
                            'Windows 11 Pro terinstal bersih dengan lisensi digital permanen. Laptop siap pakai.',
                        'detail' => 'Aktivasi Windows berhasil & permanen',
                        'icon' => 'fa-circle-check',
                    ],
                    [
                        'img' => '/images/gallery/4.jpeg',
                        'tag' => 'Selesai & Siap',
                        'tag_color' => 'blue',
                        'caption' =>
                            'Laptop dikembalikan dalam kondisi prima — bersih, terawat, dan siap digunakan kembali.',
                        'detail' => 'Garansi 7 hari setelah servis',
                        'icon' => 'fa-laptop',
                    ],
                ];

                $tagColors = [
                    'blue' => [
                        'border' => 'rgba(59,130,246,0.4)',
                        'bg' => 'rgba(59,130,246,0.15)',
                        'text' => '#93C5FD',
                    ],
                    'orange' => [
                        'border' => 'rgba(251,146,60,0.4)',
                        'bg' => 'rgba(251,146,60,0.15)',
                        'text' => '#FDC293',
                    ],
                    'green' => [
                        'border' => 'rgba(74,222,128,0.4)',
                        'bg' => 'rgba(74,222,128,0.15)',
                        'text' => '#86EFAC',
                    ],
                    'purple' => [
                        'border' => 'rgba(167,139,250,0.4)',
                        'bg' => 'rgba(167,139,250,0.15)',
                        'text' => '#C4B5FD',
                    ],
                ];
            @endphp

            {{-- Masonry-style grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 gallery-grid">

                @foreach ($gallery as $i => $item)
                    @php
                        $color = $tagColors[$item['tag_color']];
                        $isWide = $i === 0 || $i === 4; // first and last span 2 cols on lg
                    @endphp

                    <div class="gallery-card group relative flex flex-col rounded-2xl overflow-hidden
                             border border-brand-border bg-brand-card
                             hover:border-blue-600/40 hover:-translate-y-1
                             transition-all duration-400
                             {{ $isWide ? 'lg:col-span-2' : '' }}"
                        style="transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;">

                        {{-- Image container --}}
                        <div class="relative overflow-hidden {{ $isWide ? 'h-64' : 'h-52' }}">
                            <img src="{{ $item['img'] }}" alt="{{ $item['caption'] }}"
                                class="w-full h-full object-cover
                                    group-hover:scale-105 transition-transform duration-500 ease-out"
                                loading="lazy" />

                            {{-- Dark overlay on hover --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-brand-dark/80 via-transparent to-transparent
                                     opacity-60 group-hover:opacity-80 transition-opacity duration-300">
                            </div>

                            {{-- Tag badge --}}
                            <div class="absolute top-3 left-3">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold"
                                    style="border: 1px solid {{ $color['border'] }};
                                         background: {{ $color['bg'] }};
                                         color: {{ $color['text'] }};
                                         backdrop-filter: blur(8px);">
                                    <i class="fa-solid {{ $item['icon'] }} text-[9px]"></i>
                                    {{ $item['tag'] }}
                                </span>
                            </div>

                            {{-- Zoom icon on hover --}}
                            <div
                                class="absolute top-3 right-3 w-8 h-8 rounded-lg
                                     bg-black/40 backdrop-blur-sm border border-white/10
                                     flex items-center justify-center
                                     opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fa-solid fa-magnifying-glass-plus text-white text-xs"></i>
                            </div>
                        </div>

                        {{-- Caption --}}
                        <div class="p-5 flex flex-col gap-3 flex-1">
                            <p class="text-sm text-brand-text leading-relaxed font-medium">
                                {{ $item['caption'] }}
                            </p>
                            <div
                                class="flex items-center gap-2 mt-auto pt-2
                                     border-t border-brand-border/60">
                                <div class="w-1.5 h-1.5 rounded-full flex-shrink-0"
                                    style="background: {{ $color['text'] }};
                                        box-shadow: 0 0 6px 2px {{ $color['bg'] }};">
                                </div>
                                <p class="text-xs text-brand-muted font-mono">{{ $item['detail'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Bottom CTA --}}
            <div class="mt-12 text-center">
                <p class="text-sm text-brand-muted mb-4">
                    Mau lihat proses servis lebih lengkap? Follow Instagram kami.
                </p>
                <a href="https://www.instagram.com/rapidtech_mrq" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl
                           border border-brand-border text-sm font-semibold text-brand-muted
                           hover:border-pink-500/40 hover:text-pink-400 hover:bg-pink-500/10
                           transition-all duration-200">
                    <i class="fa-brands fa-instagram text-pink-400"></i>
                    @rapidtech_mrq
                </a>
            </div>

        </div>
    </section>
    {{-- /GALERI HASIL KERJA --}}


    {{-- ================================================================ --}}
    {{--  PANDUAN WEBSITE                                                  --}}
    {{-- ================================================================ --}}
    <section id="guide" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8">
        <div
            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r
                 from-transparent via-blue-600/30 to-transparent">
        </div>

        <div class="max-w-5xl mx-auto">

            <div class="text-center mb-14">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full
                         border border-blue-600/30 bg-blue-600/10 text-blue-400
                         text-xs font-mono font-medium tracking-widest uppercase">
                    <i class="fa-solid fa-globe text-[10px]"></i>
                    Panduan Website
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-text tracking-tight">
                    Pesan Layanan Lewat Website
                </h2>
                <p class="mt-3 text-brand-muted text-base max-w-lg mx-auto">
                    Cukup 3 langkah sederhana — dari pilih layanan sampai jadwal servis dikonfirmasi.
                </p>
            </div>

            @php
                $guide = [
                    [
                        'num' => '1',
                        'icon' => 'fa-hand-pointer',
                        'title' => 'Pilih Layanan',
                        'desc' =>
                            'Telusuri daftar layanan di bagian Layanan & Harga. Pilih yang sesuai kebutuhan laptopmu — Install Ulang, Lisensi, Cleaning, atau paket Best Deal.',
                        'detail' =>
                            'Tidak yakin butuh apa? Scroll ke atas dan baca deskripsi tiap layanan, atau langsung konsultasi dulu.',
                    ],
                    [
                        'num' => '2',
                        'icon' => 'fa-brands fa-whatsapp',
                        'title' => 'Klik Pesan & WA Otomatis',
                        'desc' =>
                            'Tekan tombol "Pesan Sekarang" di kartu layanan pilihanmu. Kamu akan diarahkan ke WhatsApp dengan pesan terisi otomatis — tinggal kirim.',
                        'detail' => 'Pastikan WhatsApp sudah terinstal di HP-mu agar proses redirect berjalan lancar.',
                    ],
                    [
                        'num' => '3',
                        'icon' => 'fa-calendar-check',
                        'title' => 'Konfirmasi Jadwal',
                        'desc' =>
                            'Tim kami akan membalas dan mengonfirmasi jadwal servis. Tersedia opsi antar-jemput laptop untuk wilayah Merauke (syarat & ketentuan berlaku).',
                        'detail' => 'Jam operasional: Senin–Minggu, 09.00–22.00 WIT.',
                    ],
                ];
            @endphp

            <div class="relative flex flex-col lg:flex-row gap-6 lg:gap-0 items-stretch">
                @foreach ($guide as $g)
                    <div class="relative flex-1 flex flex-col group">

                        {{-- Horizontal connector (desktop) --}}
                        @if (!$loop->last)
                            <div
                                class="hidden lg:flex absolute top-10 right-0 translate-x-1/2 z-20
                             items-center justify-center w-8">
                                <div class="w-full h-px bg-gradient-to-r from-blue-500/40 to-blue-500/40"></div>
                                <i class="fa-solid fa-chevron-right absolute text-blue-500/50 text-xs"></i>
                            </div>
                        @endif

                        <div
                            class="flex flex-col h-full rounded-2xl border border-brand-border
                             bg-brand-card p-6 lg:mx-3
                             hover:border-blue-600/40 hover:-translate-y-1
                             transition-all duration-300">
                            <div class="flex items-center gap-3 mb-5">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-600/15 flex items-center
                                     justify-center shrink-0
                                     group-hover:bg-blue-600/25 transition-colors duration-300">
                                    <i class="{{ $g['icon'] }} text-blue-400 text-base"></i>
                                </div>
                                <span
                                    class="font-mono text-4xl font-extrabold text-blue-600/20
                                      group-hover:text-blue-600/35 transition-colors duration-300
                                      leading-none select-none">
                                    0{{ $g['num'] }}
                                </span>
                            </div>
                            <h3 class="text-base font-bold text-brand-text mb-2">{{ $g['title'] }}</h3>
                            <p class="text-xs text-brand-muted leading-relaxed flex-1">{{ $g['desc'] }}</p>
                            <div
                                class="mt-5 flex items-start gap-2 p-3 rounded-xl
                                 bg-brand-dark border border-brand-border">
                                <i class="fa-solid fa-circle-info text-blue-400/70 text-xs mt-0.5 shrink-0"></i>
                                <p class="text-[11px] text-brand-muted leading-relaxed">{{ $g['detail'] }}</p>
                            </div>
                        </div>

                        {{-- Vertical connector (mobile) --}}
                        @if (!$loop->last)
                            <div class="lg:hidden flex flex-col items-center py-2">
                                <div class="w-px h-6 bg-gradient-to-b from-blue-500/40 to-transparent"></div>
                                <i class="fa-solid fa-chevron-down text-blue-500/40 text-xs"></i>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

        </div>
    </section>
    {{-- /PANDUAN WEBSITE --}}


    {{-- ================================================================ --}}
    {{--  FAQ                                                              --}}
    {{-- ================================================================ --}}
    <section id="faq" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8">
        <div
            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r
                 from-transparent via-blue-600/30 to-transparent">
        </div>

        <div class="max-w-2xl mx-auto">

            <div class="text-center mb-12">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full
                         border border-blue-600/30 bg-blue-600/10 text-blue-400
                         text-xs font-mono font-medium tracking-widest uppercase">
                    <i class="fa-solid fa-circle-question text-[10px]"></i>
                    FAQ
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-text tracking-tight">
                    Pertanyaan yang Sering Ditanya
                </h2>
                <p class="mt-3 text-brand-muted text-base">
                    Belum ketemu jawaban? Langsung tanya via WhatsApp.
                </p>
            </div>

            @php
                $faqs = [
                    [
                        'id' => 'faq-1',
                        'icon' => 'fa-clock',
                        'q' => 'Berapa lama pengerjaan servis?',
                        'a' =>
                            'Rata-rata sekitar 2–4 jam tergantung jenis layanan dan antrean yang ada. Untuk cleaning biasa bisa lebih cepat, sedangkan install ulang OS bisa memakan waktu sedikit lebih lama. Kamu akan dapat notifikasi via WhatsApp saat laptop sudah siap diambil.',
                    ],
                    [
                        'id' => 'faq-2',
                        'icon' => 'fa-shield-halved',
                        'q' => 'Apakah lisensi Windows yang dijual original?',
                        'a' =>
                            'Tentu, 100% original dan resmi. Lisensi ini berlaku seumur hidup untuk laptop Anda dan tidak akan hilang jika Anda sekadar me-reset laptop. Kalaupun ke depannya Anda butuh install ulang total dari awal, Anda tinggal memasukkan ulang kode lisensi yang sudah kami catat untuk Anda.',
                    ],
                    [
                        'id' => 'faq-3',
                        'icon' => 'fa-location-dot',
                        'q' => 'Di mana lokasi layanan RapidTech.mrq?',
                        'a' =>
                            'Layanan kami khusus melayani wilayah Merauke dan sekitarnya. Tersedia opsi antar-jemput laptop untuk area tertentu — konfirmasi ketersediaan saat menghubungi kami via WhatsApp.',
                    ],
                ];
            @endphp

            <div class="flex flex-col gap-3" id="faq-list">
                @foreach ($faqs as $faq)
                    <div class="faq-item rounded-2xl border border-brand-border bg-brand-card
                         overflow-hidden transition-all duration-300 hover:border-blue-600/30"
                        id="{{ $faq['id'] }}">

                        <button
                            class="faq-trigger w-full flex items-center justify-between
                                gap-4 px-5 py-4 text-left group"
                            aria-expanded="false" aria-controls="{{ $faq['id'] }}-body">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-600/15 flex items-center
                                     justify-center shrink-0">
                                    <i class="fa-solid {{ $faq['icon'] }} text-blue-400 text-xs"></i>
                                </div>
                                <span
                                    class="text-sm font-semibold text-brand-text
                                      group-hover:text-blue-300 transition-colors duration-200">
                                    {{ $faq['q'] }}
                                </span>
                            </div>
                            <div
                                class="faq-chevron shrink-0 w-7 h-7 rounded-lg border border-brand-border
                                 flex items-center justify-center
                                 transition-all duration-300 group-hover:border-blue-600/40">
                                <i
                                    class="fa-solid fa-chevron-down text-brand-muted text-xs
                                   transition-transform duration-300"></i>
                            </div>
                        </button>

                        <div class="faq-body overflow-hidden max-h-0 transition-all duration-300 ease-in-out"
                            id="{{ $faq['id'] }}-body">
                            <div class="px-5 pb-5 pt-1">
                                <div class="flex gap-3">
                                    <div
                                        class="w-px bg-gradient-to-b from-blue-500/50
                                         to-transparent shrink-0 ml-4 rounded-full">
                                    </div>
                                    <p class="text-sm text-brand-muted leading-relaxed pl-2">
                                        {{ $faq['a'] }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <div
                class="mt-10 flex flex-col sm:flex-row items-center justify-between
                     gap-4 p-5 rounded-2xl border border-brand-border bg-brand-card">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-green-500/15 flex items-center
                             justify-center shrink-0">
                        <i class="fa-brands fa-whatsapp text-green-400 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-brand-text">Masih ada pertanyaan?</p>
                        <p class="text-xs text-brand-muted">Kami siap membantu via WhatsApp.</p>
                    </div>
                </div>
                <a href="https://wa.me/6282199547682?text=Halo%20RapidTech,%20saya%20punya%20pertanyaan"
                    target="_blank" rel="noopener noreferrer"
                    class="shrink-0 btn-primary inline-flex items-center gap-2
                       px-5 py-2.5 rounded-xl text-sm font-bold text-white">
                    <i class="fa-brands fa-whatsapp"></i>
                    Tanya Sekarang
                </a>
            </div>

        </div>
    </section>
    {{-- /FAQ --}}


    {{-- ================================================================ --}}
    {{--  LOKASI KAMI                                                      --}}
    {{-- ================================================================ --}}
    <section id="location" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8">
        <div
            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r
                     from-transparent via-blue-600/30 to-transparent">
        </div>

        <div class="max-w-6xl mx-auto">

            {{-- Section Header --}}
            <div class="text-center mb-14">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 mb-4 rounded-full
                             border border-blue-600/30 bg-blue-600/10 text-blue-400
                             text-xs font-mono font-medium tracking-widest uppercase">
                    <i class="fa-solid fa-location-dot text-[10px]"></i>
                    Lokasi Kami
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-text tracking-tight">
                    Kunjungi Tempat Servis Kami
                </h2>
                <p class="mt-3 text-brand-muted text-base max-w-xl mx-auto">
                    Bawa laptop kamu langsung ke workshop kami — kami siap melayani di tempat.
                </p>
            </div>

            {{-- Map + Info grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

                {{-- Map (takes 2/3 width on lg) --}}
                <div class="lg:col-span-2 relative rounded-2xl overflow-hidden border border-brand-border
                             shadow-[0_0_30px_4px_rgba(59,130,246,0.08)]"
                    style="min-height: 380px;">
                    <div id="rapidtech-map" style="width:100%; height:380px; z-index:1;"></div>

                    {{-- Map dark overlay gradient top --}}
                    <div
                        class="absolute top-0 inset-x-0 h-8 pointer-events-none
                                 bg-gradient-to-b from-brand-dark/30 to-transparent z-10">
                    </div>

                    {{-- Live badge --}}
                    <div class="absolute top-3 left-3 z-20">
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full
                                      bg-brand-dark/80 backdrop-blur-sm
                                      border border-green-500/30 text-green-400
                                      text-[11px] font-mono font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                            Live Map
                        </span>
                    </div>
                </div>

                {{-- Info Card (takes 1/3 width on lg) --}}
                <div class="flex flex-col gap-4">

                    {{-- Address card --}}
                    <div
                        class="flex-1 rounded-2xl border border-brand-border bg-brand-card p-6
                                 flex flex-col gap-5">

                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-600/15 flex items-center
                                         justify-center shrink-0">
                                <i class="fa-solid fa-map-pin text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-brand-muted font-mono uppercase tracking-wide">Alamat</p>
                                <p class="text-sm font-semibold text-brand-text leading-snug mt-0.5">
                                    Jalur 2, Bambu Pemali
                                </p>
                            </div>
                        </div>

                        <p
                            class="text-xs text-brand-muted leading-relaxed
                                   border-l-2 border-blue-600/30 pl-3">
                            Kec. Merauke, Kabupaten Merauke,<br />
                            Papua Selatan 99614
                        </p>

                        <div class="h-px bg-brand-border"></div>

                        {{-- Jam operasional --}}
                        <div class="flex items-start gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-600/15 flex items-center
                                         justify-center shrink-0 mt-0.5">
                                <i class="fa-regular fa-clock text-blue-400"></i>
                            </div>
                            <div>
                                <p class="text-xs text-brand-muted font-mono uppercase tracking-wide">Jam Operasional
                                </p>
                                <p class="text-sm font-semibold text-brand-text mt-0.5">Senin – Minggu</p>
                                <p class="text-xs text-brand-muted">09.00 – 22.00 WIT</p>
                                <div class="flex items-center gap-1.5 mt-1.5" id="status-badge-location">
                                    <span id="status-dot-location"
                                        class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                                    <span id="status-text-location" class="text-xs text-green-400 font-medium">Buka
                                        Sekarang</span>
                                </div>
                            </div>
                        </div>

                        <div class="h-px bg-brand-border"></div>

                        {{-- Koordinat --}}
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-600/15 flex items-center
                                         justify-center shrink-0">
                                <i class="fa-solid fa-crosshairs text-blue-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-brand-muted font-mono uppercase tracking-wide">Koordinat</p>
                                <p class="text-xs font-mono text-brand-text mt-0.5">-8.506302, 140.392217</p>
                            </div>
                        </div>

                    </div>

                    {{-- CTA Button --}}
                    <a href="https://www.google.com/maps/place/-8.506302,140.392217/@-8.506302,140.392217,18z"
                        target="_blank" rel="noopener noreferrer" id="btn-gmaps"
                        class="flex items-center justify-center gap-3 px-6 py-4 rounded-2xl
                               bg-gradient-to-r from-blue-600 to-blue-500
                               text-white font-bold text-sm
                               shadow-lg shadow-blue-600/30
                               hover:shadow-blue-500/50 hover:scale-[1.02]
                               transition-all duration-300">
                        <i class="fa-solid fa-map-location-dot text-lg"></i>
                        <span>
                            Cek di Google Maps
                            <span class="block text-xs font-normal opacity-70">Buka & navigasi ke sini</span>
                        </span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs ml-auto opacity-70"></i>
                    </a>

                </div>
            </div>

        </div>
    </section>
    {{-- /LOKASI KAMI --}}

    <script>
        // ── Leaflet Map: RapidTech.mrq Location ──────────────────────────────
        (function() {
            var lat = -8.506294449642962;
            var lng = 140.3921576150726;
            var zoom = 16;

            var map = L.map('rapidtech-map', {
                center: [lat, lng],
                zoom: zoom,
                zoomControl: true,
                scrollWheelZoom: false,
            });

            // OpenStreetMap dark-style tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19,
            }).addTo(map);

            // Custom blue marker icon
            var markerIcon = L.divIcon({
                className: '',
                html: `<div style="
                width: 40px; height: 40px;
                background: linear-gradient(135deg, #3B82F6, #1D4ED8);
                border-radius: 50% 50% 50% 0;
                transform: rotate(-45deg);
                border: 3px solid white;
                box-shadow: 0 4px 16px rgba(59,130,246,0.6);
            "></div>
            <div style="
                position: absolute; top: 8px; left: 8px;
                width: 20px; height: 20px;
                background: white; border-radius: 50%;
                transform: rotate(45deg);
            "></div>`,
                iconSize: [40, 40],
                iconAnchor: [20, 40],
                popupAnchor: [0, -44],
            });

            var marker = L.marker([lat, lng], {
                icon: markerIcon
            }).addTo(map);

            marker.bindPopup(`
            <div style="font-family: Inter, sans-serif; min-width: 180px; padding: 4px 0;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                    <div style="width:28px;height:28px;background:#1D4ED8;border-radius:8px;
                                display:flex;align-items:center;justify-content:center;">
                        <svg width="14" height="14" fill="white" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                        </svg>
                    </div>
                    <strong style="font-size:13px;color:#1e293b;">RapidTech.mrq</strong>
                </div>
                <p style="font-size:11px;color:#64748b;margin:0;line-height:1.5;">
                    Jalur 2, Bambu Pemali<br/>
                    Kec. Merauke, Papua Selatan
                </p>
                <a href="https://www.google.com/maps?q=-8.506294449642962,140.3921576150726"
                   target="_blank"
                   style="display:inline-flex;align-items:center;gap:4px;margin-top:8px;
                          font-size:11px;color:#3B82F6;font-weight:600;text-decoration:none;">
                    Buka Google Maps
                    <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 19H5V5h7V3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                    </svg>
                </a>
            </div>
        `, {
                maxWidth: 240
            }).openPopup();

            // Force re-render setelah section masuk viewport
            var mapObserver = new IntersectionObserver(function(entries) {
                if (entries[0].isIntersecting) {
                    map.invalidateSize();
                    mapObserver.disconnect();
                }
            }, {
                threshold: 0.1
            });
            mapObserver.observe(document.getElementById('rapidtech-map'));
        })();
    </script>


    {{-- ================================================================ --}}
    {{--  BUTUH BANTUAN (CTA)                                              --}}
    {{-- ================================================================ --}}
    <section id="contact" class="relative z-10 py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div
            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r
                 from-transparent via-blue-600/30 to-transparent">
        </div>

        <div class="max-w-4xl mx-auto">
            <div
                class="relative rounded-3xl overflow-hidden border border-blue-500/40
                     bg-gradient-to-br from-blue-700/30 via-blue-600/20 to-brand-card
                     shadow-[0_0_60px_10px_rgba(59,130,246,0.15)] p-10 sm:p-14 text-center">

                <div
                    class="absolute -top-16 -left-16 w-56 h-56 rounded-full
                         bg-blue-500/20 blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute -bottom-16 -right-16 w-56 h-56 rounded-full
                         bg-blue-700/20 blur-3xl pointer-events-none">
                </div>
                <div class="absolute inset-0 pointer-events-none"
                    style="background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
                        background-size: 28px 28px;">
                </div>

                <div class="relative z-10">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 mb-6 rounded-full
                             border border-blue-400/30 bg-blue-500/15 text-blue-300
                             text-xs font-mono font-medium tracking-widest uppercase">
                        <i class="fa-solid fa-headset text-[10px]"></i>
                        Butuh Bantuan
                    </span>

                    <h2
                        class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight
                            leading-tight mb-4">
                        Masih bingung? Konsultasikan<br class="hidden sm:block" />
                        masalah perangkat Anda
                        <span class="relative inline-block">
                            gratis!
                            <svg class="absolute -bottom-1 left-0 w-full" viewBox="0 0 120 8"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M2 6 Q60 1 118 6" stroke="#93C5FD" stroke-width="2" fill="none"
                                    stroke-linecap="round" opacity="0.7" />
                            </svg>
                        </span>
                    </h2>

                    <p class="text-blue-200/70 text-base max-w-lg mx-auto mb-10 leading-relaxed">
                        Tim teknisi kami siap menjawab pertanyaanmu — tidak ada biaya konsultasi,
                        tidak ada kewajiban lanjut servis.
                    </p>

                    <button id="btn-hubungi-tim" onclick="openWaModal()"
                        class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl
                                bg-white text-blue-700 text-base font-extrabold
                                shadow-lg shadow-blue-900/40
                                hover:bg-blue-50 hover:scale-105 hover:shadow-xl
                                hover:shadow-blue-500/30 transition-all duration-300
                                cursor-pointer border-0">
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-xl
                                  bg-green-500 shadow-md shadow-green-500/40">
                            <i class="fa-brands fa-whatsapp text-white text-base"></i>
                        </span>
                        Hubungi Tim Kami
                        <i class="fa-solid fa-arrow-right text-sm opacity-60"></i>
                    </button>

                    <p class="mt-6 text-xs text-blue-300/50 font-mono">
                        <i class="fa-solid fa-lock text-[9px] mr-1"></i>
                        Privasi terjaga — kami tidak menyimpan data pribadimu
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- /BUTUH BANTUAN --}}


    {{-- ================================================================ --}}
    {{--  FOOTER                                                           --}}
    {{-- ================================================================ --}}
    <footer class="relative z-10 border-t border-brand-border bg-brand-dark">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

                {{-- Brand column --}}
                <div class="flex flex-col gap-4">
                    <a href="#" class="flex items-center gap-2 w-fit">
                        <img src="/images/logo.png" alt="RapidTech.mrq Logo"
                            class="w-8 h-8 rounded-lg object-cover ring-1 ring-blue-600/40" />
                        <span class="text-lg font-bold tracking-tight text-brand-text">
                            Rapid<span class="text-brand-blue">Tech</span><span
                                class="text-brand-muted font-light">.mrq</span>
                        </span>
                    </a>
                    <p class="text-xs text-brand-muted leading-relaxed max-w-xs">
                        Jasa servis laptop profesional untuk wilayah Merauke dan sekitarnya.
                        Cepat, tuntas, dan bergaransi.
                    </p>
                    <div class="flex items-center gap-2 mt-1">
                        <a href="https://wa.me/6282199547682" target="_blank" rel="noopener noreferrer"
                            aria-label="WhatsApp"
                            class="w-8 h-8 rounded-lg border border-brand-border flex items-center
                               justify-center text-brand-muted hover:text-green-400
                               hover:border-green-500/40 hover:bg-green-500/10 transition-all duration-200">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                        </a>
                        <a href="https://www.instagram.com/rapidtech_mrq?igsi=ZDNlZDc0MzIxNw==" aria-label="Instagram"
                            class="w-8 h-8 rounded-lg border border-brand-border flex items-center
                               justify-center text-brand-muted hover:text-pink-400
                               hover:border-pink-500/40 hover:bg-pink-500/10 transition-all duration-200">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                    </div>
                </div>

                {{-- Navigasi --}}
                <div>
                    <p
                        class="text-xs font-mono font-semibold text-brand-muted
                           tracking-widest uppercase mb-4">
                        Navigasi</p>
                    <ul class="flex flex-col gap-2">
                        @foreach ([['href' => '#about', 'label' => 'Tentang Kami'], ['href' => '#services', 'label' => 'Layanan & Harga'], ['href' => '#how', 'label' => 'Cara Kerja'], ['href' => '#guide', 'label' => 'Panduan Website'], ['href' => '#faq', 'label' => 'FAQ'], ['href' => '#contact', 'label' => 'Butuh Bantuan']] as $link)
                            <li>
                                <a href="{{ $link['href'] }}"
                                    class="text-sm text-brand-muted hover:text-brand-blue
                                       transition-colors duration-200 flex items-center gap-2 group">
                                    <i
                                        class="fa-solid fa-chevron-right text-[9px] text-brand-border
                                           group-hover:text-brand-blue transition-colors duration-200"></i>
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Layanan + Jam Operasional --}}
                <div>
                    <p
                        class="text-xs font-mono font-semibold text-brand-muted
                           tracking-widest uppercase mb-4">
                        Layanan</p>
                    <ul class="flex flex-col gap-2">
                        @foreach (['Install Ulang OS', 'Lisensi Windows 11 Pro', 'Cleaning Internal', 'Cleaning + Repasta'] as $svc)
                            <li class="text-sm text-brand-muted flex items-center gap-2">
                                <i class="fa-solid fa-circle text-[5px] text-blue-600/60"></i>
                                {{ $svc }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-6 p-3 rounded-xl border border-brand-border bg-brand-card">
                        <p
                            class="text-[11px] font-mono font-semibold text-brand-muted
                               uppercase tracking-wide mb-2">
                            <i class="fa-regular fa-clock text-blue-400 mr-1"></i>
                            Jam Operasional
                        </p>
                        <p class="text-xs text-brand-text">Senin – Minggu</p>
                        <p class="text-xs text-brand-muted">09.00 –22.00 WIT</p>
                        <p class="text-xs text-brand-muted mt-1 flex items-center gap-1" id="status-badge-footer">
                            <span id="status-dot-footer"
                                class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                            <span id="status-text-footer">Melayani area Merauke & sekitarnya</span>
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-brand-border">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5
                     flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-brand-muted text-center sm:text-left">
                    &copy; <span id="footer-year"></span>
                    <span class="text-brand-text font-semibold">
                        Rapid<span class="text-brand-blue">Tech</span>.mrq
                    </span>
                    &mdash; All rights reserved.
                </p>
                <p class="text-xs text-brand-muted font-mono">
                    Merauke, Papua Selatan 🇮🇩
                </p>
            </div>
        </div>

    </footer>
    {{-- /FOOTER --}}


    {{-- ================================================================ --}}
    {{--  WHATSAPP TEAM MODAL                                              --}}
    {{-- ================================================================ --}}
    <div id="wa-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="wa-modal-title"
        onclick="handleOverlayClick(event)">
        <div id="wa-modal">

            {{-- Header --}}
            <div class="relative z-10 flex items-start justify-between mb-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-2.5 py-1 mb-3 rounded-full
                             border border-green-500/25 bg-green-500/10 text-green-400
                             text-[11px] font-mono font-medium tracking-widest uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                        Tim Online
                    </div>
                    <h3 id="wa-modal-title" class="text-lg font-extrabold text-white leading-snug">
                        Pilih Tim yang Ingin<br>Kamu Hubungi
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">Konsultasi gratis — tanpa kewajiban servis</p>
                </div>
                <button id="wa-modal-close" onclick="closeWaModal()" aria-label="Tutup"
                    class="flex items-center justify-center w-8 h-8 rounded-lg
                            border border-gray-700 text-gray-500
                            hover:border-red-500/40 hover:text-red-400 hover:bg-red-500/10
                            transition-all duration-200 flex-shrink-0 mt-1">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            {{-- Contact Cards --}}
            <div class="relative z-10 flex flex-col gap-3">

                @php
                    $team = [
                        ['name' => 'Naufal', 'phone' => '6282199547682', 'display' => '0821-9954-7682'],
                        ['name' => 'Lutfi', 'phone' => '6282190960318', 'display' => '0821-9096-0318'],
                        ['name' => 'Wawan', 'phone' => '6289526504098', 'display' => '0895-2650-4098'],
                        ['name' => 'Erza', 'phone' => '6281248779242', 'display' => '0812-4877-9242'],
                    ];
                @endphp

                @foreach ($team as $member)
                    <a href="https://wa.me/{{ $member['phone'] }}?text=Halo%20RapidTech%2C%20saya%20mau%20konsultasi%20mengenai%20laptop%20saya"
                        target="_blank" rel="noopener noreferrer" class="wa-contact-card">
                        <div class="wa-avatar">{{ strtoupper(substr($member['name'], 0, 1)) }}</div>
                        <div class="wa-info">
                            <div class="wa-name">{{ $member['name'] }}</div>
                            <div class="wa-number">{{ $member['display'] }}</div>
                        </div>
                        <div class="wa-btn-icon">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                    </a>
                @endforeach

            </div>

            {{-- Footer note --}}
            <div class="relative z-10 mt-5 flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-lock text-gray-600 text-[9px]"></i>
                <span class="text-[11px] text-gray-600 font-mono">Privasi terjaga — data tidak disimpan</span>
            </div>

        </div>
    </div>
    {{-- /WHATSAPP TEAM MODAL --}}


    {{-- ================================================================ --}}
    {{--  GLOBAL SCRIPTS                                                   --}}
    {{-- ================================================================ --}}
    <script>
        // ── 0. Dark / Light Mode Toggle ───────────────────────────────
        (function() {
            // Default: dark mode. Only switch to light if explicitly saved.
            const saved = localStorage.getItem('rapidtech-theme');
            if (saved === 'light') {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            }
        })();

        function toggleTheme() {
            const html = document.documentElement;
            const isLight = html.classList.contains('light');
            if (isLight) {
                html.classList.remove('light');
                html.classList.add('dark');
                localStorage.setItem('rapidtech-theme', 'dark');
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
                localStorage.setItem('rapidtech-theme', 'light');
            }
            updateMobileThemeLabel();
        }

        function updateMobileThemeLabel() {
            const isLight = document.documentElement.classList.contains('light');
            const label = document.getElementById('mobile-theme-label');
            if (label) label.textContent = isLight ? 'Mode Gelap' : 'Mode Terang';

            // Sync mobile header icons
            const moonIcon = document.getElementById('mobile-header-icon-moon');
            const sunIcon = document.getElementById('mobile-header-icon-sun');
            if (moonIcon) moonIcon.classList.toggle('hidden', isLight);
            if (sunIcon) sunIcon.classList.toggle('hidden', !isLight);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('theme-toggle');
            if (toggleBtn) toggleBtn.addEventListener('click', toggleTheme);
            updateMobileThemeLabel();
        });

        window.toggleTheme = toggleTheme;

        // ── 1. Navbar mobile menu toggle ──────────────────────────────
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        let menuOpen = false;

        menuBtn.addEventListener('click', () => {
            menuOpen = !menuOpen;
            mobileMenu.style.maxHeight = menuOpen ? mobileMenu.scrollHeight + 'px' : '0';
            mobileMenu.style.opacity = menuOpen ? '1' : '0';
            menuIcon.className = menuOpen ?
                'fa-solid fa-xmark text-base text-brand-blue' :
                'fa-solid fa-bars text-base';
        });

        mobileMenu.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                menuOpen = false;
                mobileMenu.style.maxHeight = '0';
                mobileMenu.style.opacity = '0';
                menuIcon.className = 'fa-solid fa-bars text-base';
            });
        });

        // ── 2. Smooth scroll dengan offset navbar ─────────────────────
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (!target) return;
                e.preventDefault();
                const navbarHeight = document.querySelector('header').offsetHeight;
                const targetTop = target.getBoundingClientRect().top +
                    window.scrollY -
                    navbarHeight -
                    16;
                window.scrollTo({
                    top: targetTop,
                    behavior: 'smooth'
                });
            });
        });

        // ── 3. Navbar shadow on scroll ────────────────────────────────
        const header = document.querySelector('header');
        window.addEventListener('scroll', () => {
            header.classList.toggle('shadow-lg', window.scrollY > 10);
            header.classList.toggle('shadow-black/40', window.scrollY > 10);
        }, {
            passive: true
        });

        // ── 4. Scroll-reveal fade-up tiap section ─────────────────────
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08
        });

        document.querySelectorAll('section').forEach(el => {
            if (el.id === 'hero') return;
            el.style.opacity = '0';
            el.style.transform = 'translateY(28px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            revealObserver.observe(el);
        });

        // ── 5. FAQ accordion ─────────────────────────────────────────
        document.querySelectorAll('.faq-trigger').forEach(trigger => {
            trigger.addEventListener('click', () => {
                const item = trigger.closest('.faq-item');
                const body = item.querySelector('.faq-body');
                const chevron = item.querySelector('.faq-chevron i');
                const isOpen = trigger.getAttribute('aria-expanded') === 'true';

                // Tutup semua lainnya
                document.querySelectorAll('.faq-item').forEach(other => {
                    if (other !== item) {
                        other.querySelector('.faq-body').style.maxHeight = '0';
                        other.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
                        other.querySelector('.faq-chevron i').style.transform = 'rotate(0deg)';
                        other.querySelector('.faq-chevron').classList.remove('border-blue-500/50',
                            'bg-blue-600/10');
                        other.classList.remove('border-blue-600/40');
                    }
                });

                // Toggle item ini
                if (isOpen) {
                    body.style.maxHeight = '0';
                    trigger.setAttribute('aria-expanded', 'false');
                    chevron.style.transform = 'rotate(0deg)';
                    trigger.querySelector('.faq-chevron').classList.remove('border-blue-500/50',
                        'bg-blue-600/10');
                    item.classList.remove('border-blue-600/40');
                } else {
                    body.style.maxHeight = body.scrollHeight + 'px';
                    trigger.setAttribute('aria-expanded', 'true');
                    chevron.style.transform = 'rotate(180deg)';
                    trigger.querySelector('.faq-chevron').classList.add('border-blue-500/50',
                        'bg-blue-600/10');
                    item.classList.add('border-blue-600/40');
                }
            });
        });

        // ── 6. Tahun dinamis footer ───────────────────────────────────
        document.getElementById('footer-year').textContent = new Date().getFullYear();

        // ── 7. WhatsApp Team Modal ────────────────────────────────────
        const waOverlay = document.getElementById('wa-modal-overlay');

        function openWaModal() {
            waOverlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeWaModal() {
            waOverlay.classList.remove('open');
            document.body.style.overflow = '';
        }

        function handleOverlayClick(e) {
            if (e.target === waOverlay) closeWaModal();
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && waOverlay.classList.contains('open')) {
                closeWaModal();
            }
        });

        // Expose to global scope for onclick attributes
        window.openWaModal = openWaModal;
        window.closeWaModal = closeWaModal;
        window.handleOverlayClick = handleOverlayClick;

        // ── Realtime Store Status (WIT UTC+9) ────────────────────────
        function updateStoreStatus() {
            // Get current time in UTC, then add 9 hours for WIT (Waktu Indonesia Timur)
            const now = new Date();
            const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
            const witTime = new Date(utcTime + (3600000 * 9));

            const day = witTime.getDay(); // 0 = Sunday, 1 = Monday ... 6 = Saturday
            const hour = witTime.getHours();

            // Open Mon-Sat (1-6) from 09:00 to 21:59 (sebelum jam 22:00)
            const isOpen = (hour >= 9 && hour < 22);

            const dotLoc = document.getElementById('status-dot-location');
            const textLoc = document.getElementById('status-text-location');

            const dotFoot = document.getElementById('status-dot-footer');
            const textFoot = document.getElementById('status-text-footer');

            if (isOpen) {
                // Update Location
                if (dotLoc) {
                    dotLoc.className = 'w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse';
                }
                if (textLoc) {
                    textLoc.textContent = 'Buka Sekarang';
                    textLoc.className = 'text-xs text-green-400 font-medium';
                }

                // Update Footer
                if (dotFoot) {
                    dotFoot.className = 'w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse';
                }
                if (textFoot) {
                    textFoot.textContent = 'Melayani area Merauke & sekitarnya';
                }
            } else {
                // Update Location
                if (dotLoc) {
                    dotLoc.className = 'w-1.5 h-1.5 rounded-full bg-red-500';
                }
                if (textLoc) {
                    textLoc.textContent = 'Tutup';
                    textLoc.className = 'text-xs text-red-500 font-medium';
                }

                // Update Footer
                if (dotFoot) {
                    dotFoot.className = 'w-1.5 h-1.5 rounded-full bg-red-500';
                }
                if (textFoot) {
                    textFoot.textContent = 'Sedang Tutup';
                }
            }
        }

        // Run immediately and then every minute
        updateStoreStatus();
        setInterval(updateStoreStatus, 60000);
    </script>

</body>

</html>