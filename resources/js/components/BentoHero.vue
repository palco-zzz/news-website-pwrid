<template>
    <section class="grid grid-cols-12 gap-4 sm:gap-6 mb-12 sm:mb-20">
        <Link :href="headlineHref"
            class="col-span-12 lg:col-span-8 group relative overflow-hidden rounded-[2.5rem] bg-slate-900 shadow-2xl h-[450px] sm:h-[550px] lg:h-[650px]">
            <img :src="imageUrl"
                class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-[2s]"
                :alt="headlineTitle">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
            <div class="absolute top-4 sm:top-8 left-4 sm:left-8 flex flex-wrap gap-2">
                <span
                    class="px-3 sm:px-4 py-1.5 bg-indigo-600/80 backdrop-blur-md text-white text-[9px] sm:text-[10px] font-black rounded-full uppercase tracking-widest shadow-lg">{{
                        category }}</span>
            </div>
            <div class="absolute bottom-6 sm:bottom-12 left-6 right-6 sm:left-12 sm:right-12">
                <h1 class="text-fluid-h1 font-black text-white tracking-tight mb-4 sm:mb-8 drop-shadow-2xl">
                    {{ headlineTitle }}
                </h1>
                <span
                    class="inline-block bg-white text-slate-950 px-6 sm:px-10 py-3 sm:py-4 rounded-full font-black text-xs sm:text-sm group-hover:bg-indigo-50 transition-all shadow-xl">
                    Baca Berita Lengkap
                </span>
            </div>
        </Link>

        <div class="col-span-12 lg:col-span-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4 sm:gap-6">
            <div
                class="bg-white rounded-[2.5rem] p-6 sm:p-8 border border-slate-100 shadow-sm flex flex-col justify-between group hover:border-indigo-100 transition-all overflow-hidden relative">
                <div class="relative z-10">
                    <span class="text-[10px] font-black text-orange-600 uppercase tracking-widest mb-4 block">Info
                        Viral</span>
                    <h3
                        class="text-lg sm:text-xl font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">
                        Kreatif! Siswa SMKN 1 Purworejo Ciptakan Alat Siram Tanaman Otomatis
                    </h3>
                </div>
            </div>
            <div
                class="bg-indigo-50 rounded-[2.5rem] p-6 sm:p-8 border border-indigo-100 flex flex-col justify-between relative overflow-hidden">
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest block mb-4">Cuaca
                    Lokal</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl sm:text-5xl font-black text-indigo-950">32°C</span>
                </div>
                <p class="text-indigo-900/60 text-xs font-bold mt-1 uppercase tracking-wider">Cerah Berawan</p>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    headlineTitle: {
        type: String,
        required: true
    },
    imageUrl: {
        type: String,
        required: true
    },
    category: {
        type: String,
        default: 'Headline'
    },
    slug: {
        type: String,
        default: ''
    }
});

const headlineHref = computed(() => props.slug ? `/berita/${props.slug}` : '#');
</script>
