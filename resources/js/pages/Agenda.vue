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
        <EmptyState v-if="!agendas || agendas.length === 0" title="Belum Ada Agenda"
            description="Saat ini belum ada agenda kegiatan yang terdaftar. Pantau terus halaman ini untuk info event terbaru!"
            :lucide-icon="CalendarDays" action-label="Ajukan Event" action-link="/admin/agenda"
            secondary-label="Kembali ke Beranda" :secondary-icon="Home" @secondary="goToHome" />

        <!-- Agenda List (when data exists) -->
        <div v-else class="space-y-6">
            <div v-for="agenda in agendas" :key="agenda.id"
                class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-lg transition-shadow">
                <div class="flex items-start gap-4">
                    <div
                        class="flex-shrink-0 w-16 h-16 bg-indigo-50 rounded-xl flex flex-col items-center justify-center">
                        <span class="text-2xl font-black text-indigo-600">{{ formatDay(agenda.date) }}</span>
                        <span class="text-xs font-bold text-indigo-400 uppercase">{{ formatMonth(agenda.date) }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-lg text-slate-900 mb-1">{{ agenda.title }}</h3>
                        <div class="flex items-center gap-4 text-sm text-slate-500">
                            <span class="flex items-center gap-1">
                                <Clock class="w-4 h-4" />
                                {{ agenda.time }}
                            </span>
                            <span class="flex items-center gap-1">
                                <MapPin class="w-4 h-4" />
                                {{ agenda.location }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { Calendar, CalendarDays, Clock, Home, MapPin } from 'lucide-vue-next';
import MainLayout from '@/layouts/MainLayout.vue';
import EmptyState from '@/components/EmptyState.vue';

defineOptions({ layout: MainLayout });

defineProps({
    agendas: {
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
</script>
