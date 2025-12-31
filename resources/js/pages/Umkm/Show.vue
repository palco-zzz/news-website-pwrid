<template>

    <Head :title="umkm.name" />

    <div class="max-w-4xl mx-auto">
        <!-- Header Image -->
        <div class="aspect-video rounded-3xl overflow-hidden bg-slate-100 mb-8">
            <img :src="umkm.image || 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=2070&auto=format&fit=crop'"
                :alt="umkm.name" class="w-full h-full object-cover">
        </div>

        <!-- Info Card -->
        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm -mt-20 relative mx-4 sm:mx-8">
            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold text-green-600 uppercase tracking-wider">{{ umkm.category
                            }}</span>
                        <span v-if="umkm.is_verified"
                            class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                            <i class="fa-solid fa-check mr-1"></i>Terverifikasi
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-950 tracking-tight">
                        {{ umkm.name }}
                    </h1>
                </div>
            </div>

            <p v-if="umkm.description" class="text-slate-600 mb-6">{{ umkm.description }}</p>

            <!-- Contact & Location -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div v-if="umkm.address" class="flex items-start gap-3 p-4 bg-slate-50 rounded-2xl">
                    <i class="fa-solid fa-location-dot text-indigo-500 mt-1"></i>
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase">Alamat</span>
                        <p class="text-sm text-slate-700">{{ umkm.address }}</p>
                    </div>
                </div>
                <div v-if="umkm.phone" class="flex items-start gap-3 p-4 bg-slate-50 rounded-2xl">
                    <i class="fa-solid fa-phone text-indigo-500 mt-1"></i>
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase">Telepon</span>
                        <p class="text-sm text-slate-700">{{ umkm.phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3">
                <a v-if="umkm.whatsapp" :href="'https://wa.me/' + umkm.whatsapp" target="_blank"
                    class="flex-1 min-w-[200px] bg-green-500 text-white text-center py-3 rounded-full font-bold text-sm hover:bg-green-600 transition-colors">
                    <i class="fa-brands fa-whatsapp mr-2"></i>Hubungi via WhatsApp
                </a>
                <a v-if="umkm.instagram" :href="'https://instagram.com/' + umkm.instagram" target="_blank"
                    class="px-6 py-3 rounded-full font-bold text-sm bg-gradient-to-r from-purple-500 to-pink-500 text-white hover:from-purple-600 hover:to-pink-600 transition-colors">
                    <i class="fa-brands fa-instagram mr-2"></i>Instagram
                </a>
                <button
                    class="px-6 py-3 rounded-full font-bold text-sm bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors">
                    <i class="fa-solid fa-share-nodes mr-2"></i>Bagikan
                </button>
            </div>
        </div>

        <!-- Related UMKM -->
        <div v-if="relatedUmkm.length > 0" class="mt-16">
            <h2 class="text-xl font-black text-slate-950 mb-6">UMKM Serupa</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div v-for="related in relatedUmkm" :key="related.id"
                    class="flex gap-4 p-4 bg-white rounded-2xl border border-slate-100">
                    <div class="w-24 h-24 rounded-xl overflow-hidden bg-slate-200 flex-shrink-0">
                        <img :src="related.image || 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=2070&auto=format&fit=crop'"
                            :alt="related.name" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-900 text-sm line-clamp-1">{{ related.name }}</h3>
                        <span class="text-xs text-slate-400">{{ related.category }}</span>
                        <p v-if="related.address" class="text-xs text-slate-400 mt-1 line-clamp-1">
                            <i class="fa-solid fa-location-dot mr-1"></i>{{ related.address }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';

defineOptions({ layout: MainLayout });

defineProps({
    umkm: {
        type: Object,
        required: true,
    },
    relatedUmkm: {
        type: Array,
        default: () => [],
    },
});
</script>
