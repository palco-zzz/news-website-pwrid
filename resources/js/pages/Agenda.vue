<template>

    <Head title="Agenda" />

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-4">
                <div
                    class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center shadow-inner">
                    <Calendar class="w-6 h-6" />
                </div>
                <h1 class="text-3xl sm:text-5xl font-black text-slate-950 tracking-tighter uppercase">
                    Agenda <span class="text-indigo-600">Kota</span>
                </h1>
            </div>
            <p class="text-slate-500 font-bold text-sm tracking-wide uppercase opacity-60">
                Jadwal kegiatan dan event menarik di Purworejo.
            </p>
        </div>

        <!-- Empty State -->
        <EmptyState v-if="upcomingAgendas.length === 0 && pastAgendas.length === 0" title="Belum Ada Agenda"
            description="Saat ini belum ada agenda kegiatan yang terdaftar. Pantau terus halaman ini untuk info event terbaru!"
            :lucide-icon="CalendarDays" action-label="Ajukan Event" action-link="/admin/agenda"
            secondary-label="Kembali ke Beranda" :secondary-icon="Home" @secondary="goToHome" />

        <!-- Agenda List (when data exists) -->
        <div v-else class="space-y-10">
            <!-- Upcoming Agendas -->
            <div v-if="upcomingAgendas.length > 0">
                <h2 class="text-lg font-black text-slate-900 mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                    Agenda Mendatang
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <Link v-for="agenda in upcomingAgendas" :key="agenda.id" :href="`/agenda/${agenda.slug}`"
                        class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all cursor-pointer block">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 w-16 h-16 bg-indigo-50 rounded-xl flex flex-col items-center justify-center">
                                <span class="text-2xl font-black text-indigo-600">{{ formatDay(agenda.date) }}</span>
                                <span class="text-xs font-bold text-indigo-400 uppercase">{{ formatMonth(agenda.date)
                                    }}</span>
                            </div>
                            <div class="flex-1">
                                <span class="text-xs font-bold text-indigo-600 uppercase mb-1 inline-block">{{
                                    agenda.category }}</span>
                                <h3 class="font-bold text-lg text-slate-900 mb-2">{{ agenda.title }}</h3>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500">
                                    <span v-if="agenda.time" class="flex items-center gap-1">
                                        <Clock class="w-4 h-4" />
                                        {{ formatTime(agenda.time) }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <MapPin class="w-4 h-4" />
                                        {{ agenda.location }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>

            <!-- Past Agendas -->
            <div v-if="pastAgendas.length > 0">
                <h2 class="text-lg font-black text-slate-500 mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 bg-slate-400 rounded-full"></span>
                    Agenda Selesai
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="agenda in pastAgendas" :key="agenda.id"
                        class="bg-slate-50 rounded-xl p-4 border border-slate-100 opacity-70 hover:opacity-100 transition-opacity">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-slate-200 rounded-lg flex flex-col items-center justify-center">
                                <span class="text-lg font-bold text-slate-600">{{ formatDay(agenda.date) }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase">{{ formatMonth(agenda.date)
                                    }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-slate-700 text-sm truncate">{{ agenda.title }}</h4>
                                <p class="text-xs text-slate-400">{{ agenda.location }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { Calendar, CalendarDays, Clock, Home, MapPin } from 'lucide-vue-next';
import MainLayout from '@/layouts/MainLayout.vue';
import EmptyState from '@/components/EmptyState.vue';

defineOptions({ layout: MainLayout });

defineProps({
    upcomingAgendas: {
        type: Array,
        default: () => [],
    },
    pastAgendas: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
});

const goToHome = () => {
    router.visit('/');
};

const formatDay = (date) => {
    return new Date(date).getDate();
};

const formatMonth = (date) => {
    return new Date(date).toLocaleDateString('id-ID', { month: 'short' });
};

const formatTime = (time) => {
    if (!time) return '';
    // Handle time string format (HH:mm:ss or HH:mm)
    const parts = time.split(':');
    return `${parts[0]}:${parts[1]} WIB`;
};
</script>
