<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Purworejonya.id — Inspirasi & Kabar Purworejo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        
        :root {
            --md-sys-color-primary: #4f46e5;
            --surface: #fdfcff;
            --surface-container: #f3f3fe;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--surface);
            letter-spacing: -0.01em;
            -webkit-tap-highlight-color: transparent;
        }

        .m3-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (min-width: 1024px) {
            .m3-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 25px 30px -5px rgb(0 0 0 / 0.04), 0 12px 15px -6px rgb(0 0 0 / 0.04);
            }
        }

        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .text-fluid-h1 {
            font-size: clamp(1.75rem, 5vw, 3rem);
            line-height: 1.1;
        }

        a, button {
            min-height: 44px;
            min-width: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .page-view {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-out;
        }
        .page-view.hidden {
            display: none;
            opacity: 0;
            transform: translateY(10px);
        }
    </style>
</head>
<body class="text-slate-900 overflow-x-hidden">

    <!-- Top Info Bar (Desktop Only) -->
    <div class="hidden lg:block bg-slate-950 text-white py-2.5 text-[10px] font-bold tracking-[0.15em] uppercase border-b border-white/5">
        <div class="container mx-auto px-8 flex justify-between items-center">
            <div class="flex gap-8">
                <span class="flex items-center gap-2"><i class="fa-solid fa-calendar-day text-indigo-400"></i> Rabu, 22 Mei 2024</span>
                <span class="flex items-center gap-2"><i class="fa-solid fa-temperature-three-quarters text-indigo-400"></i> Purworejo, 32°C</span>
            </div>
            <div class="flex gap-6 items-center">
                <a href="#" class="hover:text-indigo-400 transition-colors">E-Paper</a>
                <span class="w-1 h-1 bg-slate-700 rounded-full"></span>
                <a href="#" class="hover:text-indigo-400 transition-colors">Redaksi</a>
                <span class="w-1 h-1 bg-slate-700 rounded-full"></span>
                <a href="#" class="hover:text-indigo-400 transition-colors">Iklan</a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <header class="glass-nav sticky top-0 z-50 border-b border-slate-100/50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Brand & Mobile Toggle -->
                <div class="flex items-center gap-1 sm:gap-4">
                    <button id="mobile-menu-btn" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-full active:bg-slate-200 transition-colors" aria-label="Menu">
                        <i class="fa-solid fa-bars-staggered text-lg"></i>
                    </button>
                    <a href="javascript:void(0)" onclick="navigateTo('home')" class="flex items-center gap-2 sm:gap-3 group">
                        <div class="w-9 h-9 sm:w-11 sm:h-11 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:rotate-3 transition-transform">
                            <span class="text-white font-black text-lg sm:text-xl">P</span>
                        </div>
                        <div class="flex flex-col leading-none">
                            <span class="text-lg sm:text-2xl font-black tracking-tighter text-slate-950">Purworejonya<span class="text-indigo-600">.id</span></span>
                            <span class="hidden sm:block text-[8px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-0.5">Media Digital Warga</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation (Pill Style) -->
                <nav class="hidden lg:flex items-center bg-slate-100/80 rounded-full px-1.5 py-1 border border-slate-200/40 backdrop-blur-sm">
                    <button onclick="navigateTo('home')" id="nav-home" class="nav-pill px-6 py-2 rounded-full text-xs font-bold transition-all">Beranda</button>
                    <button onclick="navigateTo('trending')" id="nav-trending" class="nav-pill px-6 py-2 rounded-full text-xs font-bold transition-all">Trending</button>
                    <button onclick="navigateTo('info-warga')" id="nav-info-warga" class="nav-pill px-6 py-2 rounded-full text-xs font-bold transition-all">Info Warga</button>
                    <button onclick="navigateTo('umkm')" id="nav-umkm" class="nav-pill px-6 py-2 rounded-full text-xs font-bold transition-all">UMKM</button>
                    <button class="px-6 py-2 rounded-full text-xs font-bold text-slate-600 hover:text-indigo-600 transition-all">Agenda</button>
                </nav>

                <!-- Search & Actions -->
                <div class="flex items-center gap-1 sm:gap-3">
                    <button class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 transition-colors" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>
                    <a href="javascript:void(0)" onclick="navigateTo('info-warga')" class="hidden sm:flex bg-indigo-600 text-white px-5 sm:px-7 py-2.5 rounded-full font-bold text-xs sm:text-sm shadow-xl shadow-indigo-100 hover:shadow-indigo-200 active:scale-95 transition-all items-center gap-2">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span>Lapor Lur!</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- VIEWS CONTAINER -->
    <main id="main-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8 min-h-screen">
        
        <!-- HOME VIEW -->
        <div id="view-home" class="page-view">
            <!-- Hero Bento Grid -->
            <section class="grid grid-cols-12 gap-4 sm:gap-6 mb-12 sm:mb-20">
                <div class="col-span-12 lg:col-span-8 group relative overflow-hidden rounded-[2rem] sm:rounded-[3rem] bg-slate-900 shadow-2xl h-[450px] sm:h-[550px] lg:h-[650px]">
                    <img src="https://images.unsplash.com/photo-1596464716127-f2a82984de30?q=80&w=2070&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-[2s]" alt="News">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                    <div class="absolute top-4 sm:top-8 left-4 sm:left-8 flex flex-wrap gap-2">
                        <span class="px-3 sm:px-4 py-1.5 bg-indigo-600 text-white text-[9px] sm:text-[10px] font-black rounded-full uppercase tracking-widest shadow-lg">Headline</span>
                    </div>
                    <div class="absolute bottom-6 sm:bottom-12 left-6 right-6 sm:left-12 sm:right-12">
                        <h1 class="text-fluid-h1 font-black text-white tracking-tight mb-4 sm:mb-8 drop-shadow-2xl">
                            Jalur Utama Kutoarjo-Kebumen Siap Digunakan Menjelang Mudik Lebaran
                        </h1>
                        <button class="bg-white text-slate-950 px-6 sm:px-10 py-3 sm:py-4 rounded-full font-black text-xs sm:text-sm hover:bg-indigo-50 active:scale-95 transition-all shadow-xl">
                            Baca Berita Lengkap
                        </button>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4 sm:gap-6">
                    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 border border-slate-100 shadow-sm flex flex-col justify-between group hover:border-indigo-100 transition-all overflow-hidden relative">
                        <div class="relative z-10">
                            <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest mb-4 block">Info Viral</span>
                            <h3 class="text-lg sm:text-xl font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">
                                Kreatif! Siswa SMKN 1 Purworejo Ciptakan Alat Siram Tanaman Otomatis
                            </h3>
                        </div>
                    </div>
                    <div class="bg-indigo-50 rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 border border-indigo-100 flex flex-col justify-between relative overflow-hidden">
                        <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest block mb-4">Cuaca Lokal</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl sm:text-5xl font-black text-indigo-950">32°C</span>
                        </div>
                        <p class="text-indigo-900/60 text-xs font-bold mt-1 uppercase tracking-wider">Cerah Berawan</p>
                    </div>
                </div>
            </section>

            <!-- Feed Layout -->
            <div class="grid grid-cols-12 gap-10">
                <div class="col-span-12 lg:col-span-8 space-y-12">
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-950 tracking-tight">Terbaru di Kota</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <article class="m3-card group cursor-pointer">
                            <div class="relative rounded-[2rem] overflow-hidden mb-4 aspect-[16/10] bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1517404212328-3c662c1e677c?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover">
                            </div>
                            <h3 class="text-xl font-extrabold text-slate-950 leading-tight">Harga Beras di Pasar Baledono Mulai Turun</h3>
                        </article>
                        <article class="m3-card group cursor-pointer">
                            <div class="relative rounded-[2rem] overflow-hidden mb-4 aspect-[16/10] bg-slate-100">
                                <img src="https://images.unsplash.com/photo-1542362567-b05503f3f746?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover">
                            </div>
                            <h3 class="text-xl font-extrabold text-slate-950 leading-tight">Mempelajari Sejarah Bedug Pendowo Purworejo</h3>
                        </article>
                    </div>
                </div>
                <aside class="col-span-12 lg:col-span-4">
                    <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                        <h3 class="text-lg font-black mb-6">Partner UMKM</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-sm">Soto Winong Legendaris</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <!-- TRENDING VIEW -->
        <div id="view-trending" class="page-view hidden">
            <div class="mb-12">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                        <i class="fa-solid fa-fire"></i>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-950 tracking-tighter italic uppercase">Trending <span class="text-indigo-600">Sekarang</span></h2>
                </div>
                <p class="text-slate-500 font-bold text-sm tracking-wide uppercase opacity-60">Paling banyak dibicarakan warga Purworejo hari ini.</p>
            </div>

            <div class="flex items-center gap-3 overflow-x-auto hide-scroll mb-10 pb-2">
                <button class="flex-none px-6 py-2.5 bg-indigo-600 text-white rounded-full text-xs font-black shadow-lg shadow-indigo-100">Hari Ini</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 hover:text-indigo-600 transition-all">Pekan Ini</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 hover:text-indigo-600 transition-all">Bulan Ini</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="m3-card relative bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden p-2 group shadow-sm hover:shadow-xl">
                    <div class="relative rounded-[2rem] overflow-hidden aspect-video">
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 left-4 flex items-center gap-2">
                            <span class="bg-indigo-600 text-white w-10 h-10 flex items-center justify-center rounded-2xl font-black text-xl shadow-lg">01</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-black text-slate-950 leading-tight mb-4 group-hover:text-indigo-600 transition-colors">Hasil Lengkap Seleksi Terbuka JPT Pratama Kabupaten Purworejo</h3>
                        <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                            <span class="text-xs font-bold text-slate-400">3 Jam Lalu</span>
                            <button class="text-indigo-600 font-black text-xs uppercase tracking-widest flex items-center gap-2">Baca <i class="fa-solid fa-arrow-right-long"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- INFO WARGA VIEW -->
        <div id="view-info-warga" class="page-view hidden">
            <!-- Header Info Warga -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center text-lg">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h2 class="text-3xl font-black text-slate-950 tracking-tighter uppercase">Info <span class="text-indigo-600">Warga</span></h2>
                    </div>
                    <p class="text-slate-500 font-bold text-sm">Kabar tercepat dari setiap sudut Kabupaten Purworejo.</p>
                </div>
                <button class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-100 hover:scale-95 transition-transform flex items-center gap-3">
                    <i class="fa-solid fa-camera"></i> Kirim Info/Laporan
                </button>
            </div>

            <!-- Chips Filters -->
            <div class="flex items-center gap-3 overflow-x-auto hide-scroll mb-10 pb-2">
                <button class="flex-none px-6 py-2.5 bg-slate-900 text-white rounded-full text-xs font-black">Semua</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">Kehilangan</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">Infrastruktur</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">Kecelakaan</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">Aspirasi</button>
            </div>

            <!-- Reports Feed Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Report Items (Previous version content) -->
                <div class="m3-card bg-white border border-slate-100 rounded-[2.5rem] p-6 shadow-sm flex flex-col group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden">
                                <img src="https://i.pravatar.cc/100?u=warga1" alt="Avatar">
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-slate-900 leading-none">@lur_adi_pwr</span>
                                <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-wider">Kutoarjo</span>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-full uppercase tracking-widest">Kehilangan</span>
                    </div>
                    <div class="rounded-2xl overflow-hidden mb-4 aspect-video bg-slate-50">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">Ditemukan Kunci Motor Honda di Depan Stasiun</h3>
                    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between text-[10px] font-bold text-slate-300">
                        <span>1 Jam Lalu</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- UMKM VIEW -->
        <div id="view-umkm" class="page-view hidden">
            <!-- Header UMKM -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-indigo-100">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black text-slate-950 tracking-tighter uppercase">Lapak <span class="text-indigo-600">Purworejo</span></h2>
                    </div>
                    <p class="text-slate-500 font-bold text-sm">Dukung produk lokal, majukan ekonomi warga Purworejo.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative group">
                        <input type="text" placeholder="Cari produk atau toko..." class="w-full sm:w-64 pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-2xl text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-600 transition-all">
                        <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
                    </div>
                    <button class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-100 active:scale-95 transition-all">
                        Daftarkan Usahamu
                    </button>
                </div>
            </div>

            <!-- Category Chips -->
            <div class="flex items-center gap-3 overflow-x-auto hide-scroll mb-10 pb-2">
                <button class="flex-none px-6 py-2.5 bg-slate-900 text-white rounded-full text-xs font-black">Semua Bisnis</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">Kuliner</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">Fashion & Tekstil</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">Kerajinan</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">Jasa & Service</button>
                <button class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">Pertanian</button>
            </div>

            <!-- UMKM Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                <!-- UMKM Item 1 -->
                <div class="m3-card bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden group shadow-sm hover:shadow-xl">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[9px] font-black text-indigo-600 shadow-sm uppercase">KULINER</div>
                        <div class="absolute bottom-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-[9px] font-black flex items-center gap-1 shadow-lg">
                            <i class="fa-solid fa-star text-[8px]"></i> 4.8
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-black text-slate-950 mb-1 group-hover:text-indigo-600 transition-colors">Soto Winong Legendaris</h3>
                        <p class="text-slate-500 text-[11px] font-bold flex items-center gap-2 mb-4 uppercase tracking-wider">
                            <i class="fa-solid fa-location-dot text-indigo-400"></i> Kec. Kemiri, Purworejo
                        </p>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6 line-clamp-2 italic">"Cita rasa otentik bumbu rempah asli Purworejo sejak 1985."</p>
                        <div class="flex gap-2">
                            <a href="https://wa.me/628123456789" target="_blank" class="flex-1 bg-green-50 text-green-600 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-green-600 hover:text-white transition-all">
                                <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                            </a>
                            <button class="w-12 h-12 bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                                <i class="fa-solid fa-share-nodes"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- UMKM Item 2 -->
                <div class="m3-card bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden group shadow-sm hover:shadow-xl">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[9px] font-black text-indigo-600 shadow-sm uppercase">FASHION</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-black text-slate-950 mb-1 group-hover:text-indigo-600 transition-colors">Batik Purworejo Canting</h3>
                        <p class="text-slate-500 text-[11px] font-bold flex items-center gap-2 mb-4 uppercase tracking-wider">
                            <i class="fa-solid fa-location-dot text-indigo-400"></i> Alun-alun Purworejo
                        </p>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6 line-clamp-2 italic">"Motif eksklusif khas daerah, bahan katun primisima premium."</p>
                        <div class="flex gap-2">
                            <a href="#" class="flex-1 bg-green-50 text-green-600 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-green-600 hover:text-white transition-all">
                                <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                            </a>
                            <button class="w-12 h-12 bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                                <i class="fa-solid fa-share-nodes"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- UMKM Item 3 -->
                <div class="m3-card bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden group shadow-sm hover:shadow-xl">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1541829081-f3f94bb44ecb?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[9px] font-black text-indigo-600 shadow-sm uppercase">KERAJINAN</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-black text-slate-950 mb-1 group-hover:text-indigo-600 transition-colors">Anyaman Bambu Grabag</h3>
                        <p class="text-slate-500 text-[11px] font-bold flex items-center gap-2 mb-4 uppercase tracking-wider">
                            <i class="fa-solid fa-location-dot text-indigo-400"></i> Kec. Grabag, Purworejo
                        </p>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6 line-clamp-2 italic">"Produk ramah lingkungan untuk hiasan rumah & souvenir."</p>
                        <div class="flex gap-2">
                            <a href="#" class="flex-1 bg-green-50 text-green-600 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-green-600 hover:text-white transition-all">
                                <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                            </a>
                            <button class="w-12 h-12 bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                                <i class="fa-solid fa-share-nodes"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- UMKM Item 4 -->
                <div class="m3-card bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden group shadow-sm hover:shadow-xl">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1563911302283-d2bc129e7570?q=80&w=1935&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[9px] font-black text-indigo-600 shadow-sm uppercase">PERTANIAN</div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-black text-slate-950 mb-1 group-hover:text-indigo-600 transition-colors">Beras Mentik Wangi Asli</h3>
                        <p class="text-slate-500 text-[11px] font-bold flex items-center gap-2 mb-4 uppercase tracking-wider">
                            <i class="fa-solid fa-location-dot text-indigo-400"></i> Kec. Bagelen, Purworejo
                        </p>
                        <p class="text-slate-500 text-xs leading-relaxed mb-6 line-clamp-2 italic">"Beras organik kualitas super langsung dari petani Bagelen."</p>
                        <div class="flex gap-2">
                            <a href="#" class="flex-1 bg-green-50 text-green-600 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-green-600 hover:text-white transition-all">
                                <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                            </a>
                            <button class="w-12 h-12 bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                                <i class="fa-solid fa-share-nodes"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-50 border-t border-slate-200 mt-20 pt-20 pb-24 lg:pb-12 text-center sm:text-left">
        <div class="container mx-auto px-4 sm:px-8 flex flex-col sm:flex-row justify-between items-center gap-6">
            <p class="text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                &copy; 2024 Purworejonya.id — Jembatan Informasi Warga.
            </p>
            <div class="flex gap-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                <a href="#" class="hover:text-indigo-600">Privasi</a>
                <a href="#" class="hover:text-indigo-600">Kontak</a>
            </div>
        </div>
    </footer>

    <!-- Bottom Navigation (Mobile Only) -->
    <div class="lg:hidden fixed bottom-4 left-4 right-4 z-50">
        <div class="bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl rounded-full px-8 py-3.5 flex justify-between items-center">
            <button onclick="navigateTo('home')" class="flex flex-col items-center gap-1 nav-bottom" data-page="home">
                <i class="fa-solid fa-house text-lg"></i>
                <span class="text-[8px] font-black uppercase">Home</span>
            </button>
            <button onclick="navigateTo('trending')" class="flex flex-col items-center gap-1 nav-bottom" data-page="trending">
                <i class="fa-solid fa-fire text-lg"></i>
                <span class="text-[8px] font-black uppercase">Trending</span>
            </button>
            <div onclick="navigateTo('info-warga')" class="w-14 h-14 bg-indigo-600 rounded-[1.5rem] flex items-center justify-center text-white shadow-2xl shadow-indigo-300 -mt-12 border-[6px] border-[var(--surface)] active:scale-90 transition-transform cursor-pointer">
                <i class="fa-solid fa-plus text-xl"></i>
            </div>
            <button onclick="navigateTo('umkm')" class="flex flex-col items-center gap-1 nav-bottom" data-page="umkm">
                <i class="fa-solid fa-store text-lg"></i>
                <span class="text-[8px] font-black uppercase">UMKM</span>
            </button>
            <button class="flex flex-col items-center gap-1 text-slate-400">
                <i class="fa-solid fa-user text-lg"></i>
                <span class="text-[8px] font-black uppercase">Profil</span>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer -->
    <div id="drawer-overlay" class="fixed inset-0 bg-slate-950/40 backdrop-blur-md z-[60] hidden transition-opacity duration-300">
        <div id="drawer-panel" class="bg-white w-[85%] max-w-sm h-full shadow-2xl translate-x-[-100%] transition-transform duration-500 ease-out flex flex-col">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                <span class="font-black text-slate-900 uppercase tracking-tighter">Menu Utama</span>
                <button id="close-drawer" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <nav class="flex flex-col gap-6 font-black text-xl text-slate-900 tracking-tighter text-left">
                    <button onclick="navigateTo('home'); toggleDrawer(false)" class="text-left hover:text-indigo-600">Beranda</button>
                    <button onclick="navigateTo('trending'); toggleDrawer(false)" class="text-left hover:text-indigo-600">Trending Viral</button>
                    <button onclick="navigateTo('info-warga'); toggleDrawer(false)" class="text-left hover:text-indigo-600">Info Warga</button>
                    <button onclick="navigateTo('umkm'); toggleDrawer(false)" class="text-left hover:text-indigo-600">UMKM Lokal</button>
                </nav>
            </div>
        </div>
    </div>

    <script>
        const openBtn = document.getElementById('mobile-menu-btn');
        const closeBtn = document.getElementById('close-drawer');
        const overlay = document.getElementById('drawer-overlay');
        const panel = document.getElementById('drawer-panel');

        function navigateTo(view) {
            const views = document.querySelectorAll('.page-view');
            views.forEach(v => v.classList.add('hidden'));
            
            const target = document.getElementById(`view-${view}`);
            if(target) {
                target.classList.remove('hidden');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            updateNavUI(view);
        }

        function updateNavUI(activePage) {
            // Desktop Nav
            const navPills = document.querySelectorAll('.nav-pill');
            navPills.forEach(p => {
                p.classList.remove('bg-white', 'shadow-sm', 'ring-1', 'ring-slate-200/50', 'text-indigo-700');
                p.classList.add('text-slate-600');
            });
            const activePill = document.getElementById(`nav-${activePage}`);
            if(activePill) {
                activePill.classList.add('bg-white', 'shadow-sm', 'ring-1', 'ring-slate-200/50', 'text-indigo-700');
                activePill.classList.remove('text-slate-600');
            }

            // Bottom Nav Mobile
            const bottomIcons = document.querySelectorAll('.nav-bottom');
            bottomIcons.forEach(icon => {
                const iconPage = icon.getAttribute('data-page');
                if(iconPage === activePage) {
                    icon.classList.add('text-indigo-600');
                    icon.classList.remove('text-slate-400');
                } else {
                    icon.classList.add('text-slate-400');
                    icon.classList.remove('text-indigo-600');
                }
            });
        }

        function toggleDrawer(isOpen) {
            if (isOpen) {
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.add('opacity-100');
                    panel.classList.remove('translate-x-[-100%]');
                }, 10);
            } else {
                overlay.classList.remove('opacity-100');
                panel.classList.add('translate-x-[-100%]');
                setTimeout(() => overlay.classList.add('hidden'), 500);
            }
        }

        openBtn.addEventListener('click', () => toggleDrawer(true));
        closeBtn.addEventListener('click', () => toggleDrawer(false));
        overlay.addEventListener('click', (e) => { if(e.target === overlay) toggleDrawer(false); });

        // Default state
        navigateTo('home');
    </script>
</body>
</html>