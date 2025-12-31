<template>

    <Head title="Info Warga" />

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div
                        class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center text-lg">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h2 class="text-3xl font-black text-slate-950 tracking-tighter uppercase">Info <span
                            class="text-indigo-600">Warga</span></h2>
                </div>
                <p class="text-slate-500 font-bold text-sm">Kabar tercepat dari setiap sudut Kabupaten Purworejo.</p>
            </div>
            <button
                class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-100 hover:scale-95 transition-transform flex items-center gap-3">
                <i class="fa-solid fa-camera"></i> Kirim Info/Laporan
            </button>
        </div>

        <!-- Categories -->
        <div class="flex items-center gap-3 overflow-x-auto hide-scroll mb-10 pb-2">
            <button v-for="category in categories" :key="category"
                class="flex-none px-6 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-full text-xs font-bold hover:border-indigo-600 transition-all">
                {{ category }}
            </button>
        </div>

        <!-- Empty State -->
        <EmptyState v-if="!reports.data.length" title="Belum Ada Laporan"
            description="Jadilah warga yang aktif! Laporkan kejadian di sekitarmu agar warga lain tahu."
            icon="fa-solid fa-bullhorn" action-label="Buat Laporan" @action="createReport" />

        <div v-else>
            <!-- Popular Reports -->
            <div v-if="popularReports.length > 0"
                class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl p-6 border border-indigo-100 mb-8">
                <h2 class="text-sm font-black text-indigo-600 uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-arrow-trend-up mr-2"></i>Paling Banyak Didukung
                </h2>
                <div class="space-y-3">
                    <div v-for="report in popularReports" :key="report.id"
                        class="flex items-center gap-4 p-3 bg-white/60 rounded-xl">
                        <div class="flex items-center gap-1 text-indigo-600">
                            <i class="fa-solid fa-arrow-up"></i>
                            <span class="font-bold text-sm">{{ report.upvotes_count }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 text-sm">{{ report.title }}</h3>
                            <span class="text-xs text-slate-400">{{ report.location }}</span>
                        </div>
                        <StatusBadge :status="report.status" />
                    </div>
                </div>
            </div>

            <!-- Reports Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="report in reports.data" :key="report.id"
                    class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-shadow">
                    <div v-if="report.image" class="aspect-video bg-slate-100 overflow-hidden">
                        <img :src="report.image" :alt="report.title" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-indigo-600 uppercase">{{ report.category }}</span>
                            <StatusBadge :status="report.status" />
                        </div>
                        <h3 class="font-bold text-slate-900 line-clamp-2">{{ report.title }}</h3>
                        <p v-if="report.location" class="text-sm text-slate-500 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-xs"></i>
                            {{ report.location }}
                        </p>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                            <span class="text-xs text-slate-400">
                                {{ report.is_anonymous ? 'Anonim' : report.reporter_name }}
                            </span>
                            <span class="text-xs font-bold text-indigo-600">
                                <i class="fa-solid fa-arrow-up mr-1"></i>{{ report.upvotes_count }}
                            </span>
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
import StatusBadge from '@/Components/StatusBadge.vue';

defineOptions({ layout: MainLayout });

defineProps({
    reports: {
        type: Object,
        default: () => ({ data: [] }),
    },
    popularReports: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => ['Semua', 'Kehilangan', 'Infrastruktur', 'Kecelakaan', 'Aspirasi'],
    }
});

const createReport = () => {
    // Logic to open create report modal or navigate to create page
    console.log('Create report clicked');
};
</script>
