<template>

    <Head :title="report.title" />

    <article class="max-w-4xl mx-auto">
        <!-- Category & Status -->
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">{{ report.category }}</span>
            <span :class="[
                'text-xs font-bold uppercase px-3 py-1.5 rounded-full',
                statusClasses[report.status] || 'bg-slate-100 text-slate-600'
            ]">
                {{ statusLabels[report.status] || report.status }}
            </span>
        </div>

        <!-- Title -->
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-950 tracking-tight leading-tight mb-6">
            {{ report.title }}
        </h1>

        <!-- Meta Info -->
        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 mb-8">
            <span>
                <i class="fa-solid fa-user mr-1"></i>
                {{ report.is_anonymous ? 'Anonim' : (report.reporter?.name || report.reporter_name) }}
            </span>
            <span>
                <i class="fa-solid fa-calendar mr-1"></i>
                {{ formatDate(report.published_at) }}
            </span>
            <span v-if="report.location">
                <i class="fa-solid fa-location-dot mr-1"></i>
                {{ report.location }}
            </span>
            <span class="text-indigo-600 font-bold">
                <i class="fa-solid fa-arrow-up mr-1"></i>
                {{ report.upvotes_count }} dukungan
            </span>
        </div>

        <!-- Featured Image -->
        <div v-if="report.image" class="aspect-video rounded-3xl overflow-hidden bg-slate-100 mb-8">
            <img :src="report.image" :alt="report.title" class="w-full h-full object-cover">
        </div>

        <!-- Content -->
        <div class="prose prose-lg prose-slate max-w-none" v-html="report.content"></div>

        <!-- Action Buttons -->
        <div class="flex gap-4 mt-8 pt-8 border-t border-slate-100">
            <button
                class="flex-1 bg-indigo-600 text-white py-3 rounded-full font-bold text-sm hover:bg-indigo-700 transition-colors">
                <i class="fa-solid fa-arrow-up mr-2"></i>Dukung Laporan Ini
            </button>
            <button
                class="px-6 py-3 rounded-full font-bold text-sm bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors">
                <i class="fa-solid fa-share-nodes"></i>
            </button>
        </div>

        <!-- Related Reports -->
        <div v-if="relatedReports.length > 0" class="mt-16 pt-8 border-t border-slate-100">
            <h2 class="text-xl font-black text-slate-950 mb-6">Laporan Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div v-for="related in relatedReports" :key="related.id" class="flex gap-4 p-4 bg-slate-50 rounded-2xl">
                    <div v-if="related.image" class="w-24 h-24 rounded-xl overflow-hidden bg-slate-200 flex-shrink-0">
                        <img :src="related.image" :alt="related.title" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-900 text-sm line-clamp-2">{{ related.title }}</h3>
                        <span class="text-xs text-slate-400">{{ related.location }}</span>
                    </div>
                </div>
            </div>
        </div>
    </article>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';

defineOptions({ layout: MainLayout });

defineProps({
    report: {
        type: Object,
        required: true,
    },
    relatedReports: {
        type: Array,
        default: () => [],
    },
});

const statusLabels = {
    pending: 'Menunggu Verifikasi',
    verified: 'Terverifikasi',
    in_progress: 'Sedang Diproses',
    resolved: 'Selesai',
    rejected: 'Ditolak',
};

const statusClasses = {
    pending: 'bg-amber-100 text-amber-700',
    verified: 'bg-blue-100 text-blue-700',
    in_progress: 'bg-purple-100 text-purple-700',
    resolved: 'bg-green-100 text-green-700',
    rejected: 'bg-red-100 text-red-700',
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>
