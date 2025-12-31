<template>
    <div class="text-slate-900 overflow-x-hidden font-sans bg-[var(--surface)] min-h-screen flex flex-col">
        <!-- Top Info Bar (Desktop Only) -->
        <div
            class="hidden lg:block bg-slate-950 text-white py-2.5 text-[10px] font-bold tracking-[0.15em] uppercase border-b border-white/5">
            <div class="container mx-auto px-8 flex justify-between items-center">
                <div class="flex gap-8">
                    <span class="flex items-center gap-2"><i class="fa-solid fa-calendar-day text-indigo-400"></i> Rabu,
                        22 Mei
                        2024</span>
                    <span class="flex items-center gap-2"><i
                            class="fa-solid fa-temperature-three-quarters text-indigo-400"></i>
                        Purworejo, 32°C</span>
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
                        <button @click="toggleDrawer(true)"
                            class="lg:hidden w-10 h-10 flex items-center justify-center rounded-full active:bg-slate-200 transition-colors"
                            aria-label="Menu">
                            <i class="fa-solid fa-bars-staggered text-lg"></i>
                        </button>
                        <Link href="/" class="flex items-center gap-2 sm:gap-3 group">
                            <div
                                class="w-9 h-9 sm:w-11 sm:h-11 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:rotate-3 transition-transform">
                                <span class="text-white font-black text-lg sm:text-xl">P</span>
                            </div>
                            <div class="flex flex-col leading-none">
                                <span
                                    class="text-lg sm:text-2xl font-black tracking-tighter text-slate-950">Purworejonya<span
                                        class="text-indigo-600">.id</span></span>
                                <span
                                    class="hidden sm:block text-[8px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-0.5">Media
                                    Digital Warga</span>
                            </div>
                        </Link>
                    </div>

                    <!-- Desktop Navigation (Pill Style) -->
                    <nav
                        class="hidden lg:flex items-center bg-slate-100/80 rounded-full px-1.5 py-1 border border-slate-200/40 backdrop-blur-sm">
                        <Link href="/" :class="[
                            'nav-pill px-6 py-2 rounded-full text-xs font-bold transition-all',
                            isActive('Home')
                                ? 'bg-white shadow-sm ring-1 ring-slate-200/50 text-indigo-700'
                                : 'text-slate-600 hover:text-indigo-600',
                        ]">Beranda</Link>
                        <Link href="/trending" :class="[
                            'nav-pill px-6 py-2 rounded-full text-xs font-bold transition-all',
                            isActive('News/Trending')
                                ? 'bg-white shadow-sm ring-1 ring-slate-200/50 text-indigo-700'
                                : 'text-slate-600 hover:text-indigo-600',
                        ]">Trending</Link>
                        <Link href="/info-warga" :class="[
                            'nav-pill px-6 py-2 rounded-full text-xs font-bold transition-all',
                            isActive('CitizenReport')
                                ? 'bg-white shadow-sm ring-1 ring-slate-200/50 text-indigo-700'
                                : 'text-slate-600 hover:text-indigo-600',
                        ]">Info Warga</Link>
                        <Link href="/umkm" :class="[
                            'nav-pill px-6 py-2 rounded-full text-xs font-bold transition-all',
                            isActive('Umkm')
                                ? 'bg-white shadow-sm ring-1 ring-slate-200/50 text-indigo-700'
                                : 'text-slate-600 hover:text-indigo-600',
                        ]">UMKM</Link>
                        <Link href="/agenda" :class="[
                            'nav-pill px-6 py-2 rounded-full text-xs font-bold transition-all',
                            isActive('Agenda')
                                ? 'bg-white shadow-sm ring-1 ring-slate-200/50 text-indigo-700'
                                : 'text-slate-600 hover:text-indigo-600',
                        ]">Agenda</Link>
                    </nav>

                    <!-- Search & Actions -->
                    <div class="flex items-center gap-1 sm:gap-3">
                        <button
                            class="w-10 h-10 flex items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 transition-colors"
                            aria-label="Search">
                            <i class="fa-solid fa-magnifying-glass text-lg"></i>
                        </button>
                        <Link href="/info-warga"
                            class="hidden sm:flex bg-indigo-600 text-white px-5 sm:px-7 py-2.5 rounded-full font-bold text-xs sm:text-sm shadow-xl shadow-indigo-100 hover:shadow-indigo-200 active:scale-95 transition-all items-center gap-2">
                            <i class="fa-solid fa-plus-circle"></i>
                            <span>Lapor Lur!</span>
                        </Link>
                    </div>
                </div>
            </div>
        </header>

        <!-- VIEWS CONTAINER -->
        <main id="main-content" class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8 flex-grow">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-slate-50 border-t border-slate-200 mt-auto pt-20 pb-24 lg:pb-12 text-center sm:text-left">
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
            <div
                class="bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl rounded-full px-8 py-3.5 flex justify-between items-center">
                <Link href="/" :class="[
                    'flex flex-col items-center gap-1 nav-bottom',
                    isActive('Home') ? 'text-indigo-600' : 'text-slate-400',
                ]">
                    <i class="fa-solid fa-house text-lg"></i>
                    <span class="text-[8px] font-black uppercase">Home</span>
                </Link>
                <Link href="/trending" :class="[
                    'flex flex-col items-center gap-1 nav-bottom',
                    isActive('News/Trending') ? 'text-indigo-600' : 'text-slate-400',
                ]">
                    <i class="fa-solid fa-fire text-lg"></i>
                    <span class="text-[8px] font-black uppercase">Trending</span>
                </Link>
                <Link href="/info-warga"
                    class="w-14 h-14 bg-indigo-600 rounded-[1.5rem] flex items-center justify-center text-white shadow-2xl shadow-indigo-300 -mt-12 border-[6px] border-[var(--surface)] active:scale-90 transition-transform cursor-pointer">
                    <i class="fa-solid fa-plus text-xl"></i>
                </Link>
                <Link href="/umkm" :class="[
                    'flex flex-col items-center gap-1 nav-bottom',
                    isActive('Umkm') ? 'text-indigo-600' : 'text-slate-400',
                ]">
                    <i class="fa-solid fa-store text-lg"></i>
                    <span class="text-[8px] font-black uppercase">UMKM</span>
                </Link>
                <button class="flex flex-col items-center gap-1 text-slate-400">
                    <i class="fa-solid fa-user text-lg"></i>
                    <span class="text-[8px] font-black uppercase">Profil</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div :class="[
            'fixed inset-0 bg-slate-950/40 backdrop-blur-md z-[60] transition-opacity duration-300',
            isDrawerOpen ? 'opacity-100' : 'opacity-0 pointer-events-none',
        ]" @click="toggleDrawer(false)">
            <div :class="[
                'bg-white w-[85%] max-w-sm h-full shadow-2xl transition-transform duration-500 ease-out flex flex-col',
                isDrawerOpen ? 'translate-x-0' : '-translate-x-full',
            ]" @click.stop>
                <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                    <span class="font-black text-slate-900 uppercase tracking-tighter">Menu Utama</span>
                    <button @click="toggleDrawer(false)"
                        class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-8 space-y-8">
                    <nav class="flex flex-col gap-6 font-black text-xl text-slate-900 tracking-tighter text-left">
                        <Link href="/" @click="toggleDrawer(false)" class="text-left hover:text-indigo-600">Beranda
                        </Link>
                        <Link href="/trending" @click="toggleDrawer(false)" class="text-left hover:text-indigo-600">
                            Trending Viral</Link>
                        <Link href="/info-warga" @click="toggleDrawer(false)" class="text-left hover:text-indigo-600">
                            Info Warga</Link>
                        <Link href="/umkm" @click="toggleDrawer(false)" class="text-left hover:text-indigo-600">UMKM
                            Lokal</Link>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();
const isDrawerOpen = ref(false);

const toggleDrawer = (value) => {
    isDrawerOpen.value = value;
};

// Helper to check if current component matches a pattern
const isActive = (componentPattern) => {
    const component = page.component;
    if (Array.isArray(componentPattern)) {
        return componentPattern.some(p => component.startsWith(p));
    }
    return component.startsWith(componentPattern);
};
</script>

<style>
:root {
    --md-sys-color-primary: #4f46e5;
    --surface: #fdfcff;
    --surface-container: #f3f3fe;
}

body {
    font-family: "Plus Jakarta Sans", sans-serif;
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

.hide-scroll::-webkit-scrollbar {
    display: none;
}

.hide-scroll {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.glass-nav {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}

.text-fluid-h1 {
    font-size: clamp(1.75rem, 5vw, 3rem);
    line-height: 1.1;
}
</style>
