<template>

    <Head :title="news.title" />

    <article class="max-w-4xl mx-auto">
        <!-- Category Badge -->
        <div class="mb-4">
            <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">{{ news.category }}</span>
        </div>

        <!-- Title -->
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-950 tracking-tight leading-tight mb-6">
            {{ news.title }}
        </h1>

        <!-- Meta Info -->
        <div class="flex items-center gap-4 text-sm text-slate-500 mb-8">
            <span v-if="news.author">
                <i class="fa-solid fa-user mr-1"></i>
                {{ news.author.name }}
            </span>
            <span>
                <i class="fa-solid fa-calendar mr-1"></i>
                {{ formatDate(news.published_at) }}
            </span>
            <span>
                <i class="fa-solid fa-eye mr-1"></i>
                {{ news.views_count }} views
            </span>
        </div>

        <!-- Featured Image -->
        <div v-if="news.image" class="aspect-video rounded-3xl overflow-hidden bg-slate-100 mb-8">
            <img :src="news.image" :alt="news.title" class="w-full h-full object-cover">
        </div>

        <!-- Content -->
        <div class="prose prose-lg prose-slate max-w-none" v-html="news.content"></div>

        <!-- Related News -->
        <div v-if="relatedNews.length > 0" class="mt-16 pt-8 border-t border-slate-100">
            <h2 class="text-xl font-black text-slate-950 mb-6">Berita Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div v-for="related in relatedNews" :key="related.id" class="flex gap-4 p-4 bg-slate-50 rounded-2xl">
                    <div class="w-24 h-24 rounded-xl overflow-hidden bg-slate-200 flex-shrink-0">
                        <img :src="related.image || 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=2069&auto=format&fit=crop'"
                            :alt="related.title" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-900 text-sm line-clamp-2">{{ related.title }}</h3>
                        <span class="text-xs text-slate-400">{{ related.category }}</span>
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
    news: {
        type: Object,
        required: true,
    },
    relatedNews: {
        type: Array,
        default: () => [],
    },
});

const formatDate = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>
