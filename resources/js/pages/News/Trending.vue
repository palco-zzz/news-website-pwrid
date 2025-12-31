<template>

    <Head title="Trending" />

    <div class="space-y-8">
        <!-- Page Header -->
        <div class="mb-12">
            <div class="flex items-center gap-4 mb-4">
                <div
                    class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <h2 class="text-3xl sm:text-5xl font-black text-slate-950 tracking-tighter italic uppercase">Trending
                    <span class="text-indigo-600">Sekarang</span>
                </h2>
            </div>
            <p class="text-slate-500 font-bold text-sm tracking-wide uppercase opacity-60">Paling banyak dibicarakan
                warga Purworejo hari ini.</p>
        </div>

        <!-- Empty State -->
        <EmptyState v-if="!trendingNews.data.length" title="Belum Ada yang Viral"
            description="Sepertinya hari ini Purworejo sedang adem ayem. Belum ada berita yang meledak."
            :lucide-icon="Flame" action-label="Jelajahi Beranda" action-link="/" :show-action-for-all="true" />

        <div v-else>
            <!-- Top Stories -->
            <div v-if="topStories.length > 0"
                class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-3xl p-6 border border-orange-100 mb-8">
                <h2 class="text-sm font-black text-orange-600 uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-trophy mr-2"></i>Top Stories
                </h2>
                <div class="space-y-3">
                    <div v-for="(story, index) in topStories" :key="story.id"
                        class="flex items-center gap-4 p-3 bg-white/60 rounded-xl">
                        <span class="text-2xl font-black text-orange-400">{{ index + 1 }}</span>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 text-sm">{{ story.title }}</h3>
                            <span class="text-xs text-slate-400">{{ story.views_count }} views</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trending News Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="news in trendingNews.data" :key="news.id"
                    class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-shadow">
                    <div class="aspect-video bg-slate-100 overflow-hidden">
                        <img :src="news.image || 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=2069&auto=format&fit=crop'"
                            :alt="news.title" class="w-full h-full object-cover">
                    </div>
                    <div class="p-5 space-y-3">
                        <span class="text-xs font-bold text-indigo-600 uppercase">{{ news.category }}</span>
                        <h3 class="font-bold text-slate-900 line-clamp-2">{{ news.title }}</h3>
                        <p v-if="news.excerpt" class="text-sm text-slate-500 line-clamp-2">{{ news.excerpt }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { Flame, Home } from 'lucide-vue-next';
import MainLayout from '@/layouts/MainLayout.vue';
import EmptyState from '@/components/EmptyState.vue';

defineOptions({ layout: MainLayout });

defineProps({
    trendingNews: {
        type: Object,
        default: () => ({ data: [] }),
    },
    topStories: {
        type: Array,
        default: () => [],
    },
});

const goToHome = () => {
    router.visit('/');
};
</script>
