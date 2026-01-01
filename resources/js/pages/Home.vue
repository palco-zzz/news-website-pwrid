<template>

    <Head title="Beranda" />

    <BentoHero :headline-title="computedHeadline.title" :image-url="computedHeadline.imageUrl"
        :category="computedHeadline.category" :slug="computedHeadline.slug" />

    <!-- Feed Layout -->
    <div class="grid grid-cols-12 gap-10">
        <div class="col-span-12 lg:col-span-8 space-y-12">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-950 tracking-tight">Terbaru di Kota</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <NewsCard v-for="(article, index) in computedArticles" :key="index" :title="article.title"
                    :image-url="article.imageUrl" :slug="article.slug" />
            </div>
        </div>
        <aside class="col-span-12 lg:col-span-4">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm">
                <h3 class="text-lg font-black mb-6">Partner UMKM</h3>
                <div class="space-y-4">
                    <div v-for="(umkm, index) in computedFeaturedUmkm" :key="index" class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden">
                            <img :src="umkm.imageUrl" loading="lazy" class="w-full h-full object-cover"
                                :alt="umkm.name">
                        </div>
                        <span class="font-bold text-sm">{{ umkm.name }}</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import BentoHero from '@/components/BentoHero.vue';
import NewsCard from '@/components/NewsCard.vue';

defineOptions({ layout: MainLayout });

// Props from the controller
const props = defineProps({
    headline: {
        type: Object,
        default: null,
    },
    articles: {
        type: Array,
        default: () => [],
    },
    featuredUmkm: {
        type: Array,
        default: () => [],
    },
    citizenReports: {
        type: Array,
        default: () => [],
    },
});

// Fallback data for when database is empty
const fallbackHeadline = {
    title: "Jalur Utama Kutoarjo-Kebumen Siap Digunakan Menjelang Mudik Lebaran",
    imageUrl: "https://images.unsplash.com/photo-1596464716127-f2a82984de30?q=80&w=2070&auto=format&fit=crop",
    category: "Headline",
    slug: ""
};

const fallbackArticles = [
    {
        title: "Harga Beras di Pasar Baledono Mulai Turun",
        imageUrl: "https://images.unsplash.com/photo-1517404212328-3c662c1e677c?q=80&w=2070&auto=format&fit=crop",
        slug: ""
    },
    {
        title: "Mempelajari Sejarah Bedug Pendowo Purworejo",
        imageUrl: "https://images.unsplash.com/photo-1542362567-b05503f3f746?q=80&w=2070&auto=format&fit=crop",
        slug: ""
    }
];

const fallbackUmkm = [
    {
        name: "Soto Winong Legendaris",
        imageUrl: "https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop"
    }
];

// Computed properties that use real data or fallback
const computedHeadline = computed(() => {
    if (props.headline) {
        return {
            title: props.headline.title,
            imageUrl: props.headline.image_url || fallbackHeadline.imageUrl,
            category: props.headline.category || 'Headline',
            slug: props.headline.slug || ''
        };
    }
    return fallbackHeadline;
});

const computedArticles = computed(() => {
    if (props.articles && props.articles.length > 0) {
        return props.articles.map(article => ({
            title: article.title,
            imageUrl: article.image_url || 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=500&fit=crop&q=80',
            slug: article.slug || ''
        }));
    }
    return fallbackArticles;
});

const computedFeaturedUmkm = computed(() => {
    if (props.featuredUmkm && props.featuredUmkm.length > 0) {
        return props.featuredUmkm.map(umkm => ({
            name: umkm.name,
            imageUrl: umkm.image_url || 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop'
        }));
    }
    return fallbackUmkm;
});
</script>
