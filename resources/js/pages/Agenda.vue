<template>

    <Head title="Agenda" />

    <div class="max-w-4xl mx-auto">
        <div class="mb-12 text-center">
            <h1 class="text-3xl sm:text-5xl font-black text-slate-950 tracking-tighter uppercase mb-4">
                Agenda <span class="text-indigo-600">Kota</span>
            </h1>
            <p class="text-slate-500 font-bold text-sm tracking-wide uppercase opacity-60">
                Jadwal kegiatan dan event menarik di Purworejo.
            </p>
        </div>

        <div class="bg-white rounded-[2.5rem] p-12 border border-slate-100 shadow-sm text-center">
            <div
                class="w-20 h-20 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-6">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-950 mb-2">Belum Ada Agenda</h2>
            <p class="text-slate-500 mb-8">Saat ini belum ada agenda kegiatan yang terdaftar.</p>
            <button
                class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 hover:scale-95 transition-transform">
                Ajukan Event
            </button>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';

defineOptions({ layout: MainLayout });
</script>
