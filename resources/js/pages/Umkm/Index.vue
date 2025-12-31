<template>

    <Head title="UMKM Lokal" />

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-indigo-100">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-950 tracking-tighter uppercase">Lapak <span
                            class="text-indigo-600">Purworejo</span></h2>
                </div>
                <p class="text-slate-500 font-bold text-sm">Dukung produk lokal, majukan ekonomi warga Purworejo.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="relative group">
                    <input type="text" placeholder="Cari produk atau toko..."
                        class="w-full sm:w-64 pl-12 pr-6 py-4 bg-white border border-slate-200 rounded-2xl text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-600 transition-all">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors"></i>
                </div>
                <button
                    class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-100 active:scale-95 transition-all">
                    Daftarkan Usahamu
                </button>
            </div>
        </div>

        <!-- Categories -->
        <div class="flex items-center gap-3 overflow-x-auto hide-scroll mb-10 pb-2">
            <button v-for="category in categories" :key="category"
                class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">
                {{ category }}
            </button>
        </div>

        <!-- Empty State -->
        <EmptyState v-if="!umkmList.data.length" title="Belum Ada Lapak"
            description="Peluang emas! Jadilah pengusaha pertama yang mempromosikan produkmu di sini."
            icon="fa-solid fa-store" action-label="Buka Lapak" @action="registerUmkm" />

        <div v-else>
            <!-- Featured UMKM -->
            <div v-if="featuredUmkm.length > 0"
                class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-3xl p-6 border border-green-100 mb-8">
                <h2 class="text-sm font-black text-green-600 uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-star mr-2"></i>UMKM Unggulan
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div v-for="umkm in featuredUmkm" :key="umkm.id"
                        class="bg-white/80 rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                            <img :src="umkm.image || 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=2070&auto=format&fit=crop'"
                                :alt="umkm.name" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 text-sm">{{ umkm.name }}</h3>
                            <span class="text-xs text-slate-400">{{ umkm.category }}</span>
                            <div v-if="umkm.is_verified" class="mt-1">
                                <span
                                    class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                    <i class="fa-solid fa-check mr-1"></i>Terverifikasi
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- UMKM Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="umkm in umkmList.data" :key="umkm.id"
                    class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-shadow">
                    <div class="aspect-video bg-slate-100 overflow-hidden">
                        <img :src="umkm.image || 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=2070&auto=format&fit=crop'"
                            :alt="umkm.name" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-green-600 uppercase">{{ umkm.category }}</span>
                            <span v-if="umkm.is_verified"
                                class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                <i class="fa-solid fa-check mr-1"></i>Verified
                            </span>
                        </div>
                        <h3 class="font-bold text-slate-900 line-clamp-1">{{ umkm.name }}</h3>
                        <p v-if="umkm.description" class="text-sm text-slate-500 line-clamp-2">{{ umkm.description }}
                        </p>
                        <p v-if="umkm.address" class="text-sm text-slate-400 flex items-start gap-1">
                            <i class="fa-solid fa-location-dot text-xs mt-1"></i>
                            <span class="line-clamp-1">{{ umkm.address }}</span>
                        </p>
                        <div class="flex gap-2 pt-2">
                            <a v-if="umkm.whatsapp" :href="'https://wa.me/' + umkm.whatsapp" target="_blank"
                                class="flex-1 bg-green-500 text-white text-center py-2 rounded-xl text-xs font-bold hover:bg-green-600 transition-colors">
                                <i class="fa-brands fa-whatsapp mr-1"></i>WhatsApp
                            </a>
                            <a v-if="umkm.instagram" :href="'https://instagram.com/' + umkm.instagram" target="_blank"
                                class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import EmptyState from '@/Components/EmptyState.vue';

defineOptions({ layout: MainLayout });

defineProps({
    umkmList: {
        type: Object,
        default: () => ({ data: [] }),
    },
    featuredUmkm: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => ['Semua Bisnis', 'Kuliner', 'Fashion & Tekstil', 'Kerajinan', 'Jasa & Service', 'Pertanian'],
    }
});

const registerUmkm = () => {
    console.log('Register UMKM clicked');
};
</script>
