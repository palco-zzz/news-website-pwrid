<script setup lang="ts">
import MainLayout from '@/layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    ChevronRight,
    Calendar,
    Eye,
    Clock,
    Facebook,
    Twitter,
    Link as LinkIcon,
    MessageCircle,
    ArrowRight,
    Megaphone,
} from 'lucide-vue-next';
import { computed, ref } from 'vue';

defineOptions({ layout: MainLayout });

interface Author {
    id: number;
    name: string;
    avatar?: string;
}

interface News {
    id: number;
    title: string;
    slug: string;
    excerpt: string;
    content: string;
    image: string | null;
    image_url: string | null;
    image_caption?: string;
    category: string;
    tags?: string[];
    author: Author | null;
    views_count: number;
    published_at: string;
    reading_time?: number;
}

interface RelatedNews {
    id: number;
    title: string;
    slug: string;
    image: string | null;
    image_url: string | null;
    category: string;
    published_at: string;
}

const props = defineProps<{
    news: News;
    relatedNews: RelatedNews[];
}>();

// Format date
const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    }).format(date);
};

const formatShortDate = (dateString: string) => {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(date);
};

// Reading time estimate
const readingTime = computed(() => {
    if (props.news.reading_time) return props.news.reading_time;
    const words = props.news.content.split(/\s+/).length;
    return Math.ceil(words / 200);
});

// Share functionality
const shareUrl = computed(() => {
    if (typeof window !== 'undefined') {
        return window.location.href;
    }
    return '';
});

const shareOnFacebook = () => {
    window.open(
        `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl.value)}`,
        '_blank',
        'width=600,height=400'
    );
};

const shareOnTwitter = () => {
    window.open(
        `https://twitter.com/intent/tweet?url=${encodeURIComponent(shareUrl.value)}&text=${encodeURIComponent(props.news.title)}`,
        '_blank',
        'width=600,height=400'
    );
};

const shareOnWhatsApp = () => {
    window.open(
        `https://wa.me/?text=${encodeURIComponent(props.news.title + ' ' + shareUrl.value)}`,
        '_blank'
    );
};

const copyLink = () => {
    navigator.clipboard.writeText(shareUrl.value);
    linkCopied.value = true;
    setTimeout(() => {
        linkCopied.value = false;
    }, 2000);
};

const linkCopied = ref(false);

// Fallback image
const FALLBACK_IMAGE = 'https://images.unsplash.com/photo-1495020689067-958852a7765e?w=1200&h=800&fit=crop&q=80';
const mainImageError = ref(false);

const mainImageSrc = computed(() => {
    if (mainImageError.value || !props.news.image_url) {
        return FALLBACK_IMAGE;
    }
    return props.news.image_url;
});

const handleMainImageError = () => {
    mainImageError.value = true;
};

const getRelatedImageSrc = (related: RelatedNews, hasError: boolean) => {
    if (hasError || !related.image_url) {
        return FALLBACK_IMAGE;
    }
    return related.image_url;
};

// Author initials
const authorInitials = computed(() => {
    if (!props.news.author?.name) return '?';
    return props.news.author.name
        .split(' ')
        .map((n) => n[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
});
</script>

<template>

    <Head>
        <title>{{ news.title }} - Purworejonya.id</title>
        <meta name="description" :content="news.excerpt" />
        <meta property="og:title" :content="news.title" />
        <meta property="og:description" :content="news.excerpt" />
        <meta property="og:image" :content="news.image_url ?? ''" />
        <meta property="og:type" content="article" />
    </Head>

    <div class="min-h-screen bg-slate-50 font-['Plus_Jakarta_Sans']">
        <!-- Breadcrumb -->
        <div class="bg-white border-b border-slate-100">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center gap-2 text-sm">
                    <Link href="/" class="text-slate-500 hover:text-indigo-600 transition-colors">
                        Beranda
                    </Link>
                    <ChevronRight class="h-4 w-4 text-slate-300" />
                    <Link href="/trending" class="text-slate-500 hover:text-indigo-600 transition-colors">
                        Berita
                    </Link>
                    <ChevronRight class="h-4 w-4 text-slate-300" />
                    <span class="text-slate-900 font-medium truncate max-w-[200px] sm:max-w-md">
                        {{ news.title }}
                    </span>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Article Content (Left - 2 columns) -->
                <article class="lg:col-span-2">
                    <!-- Category Badge -->
                    <div class="mb-4">
                        <span
                            class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700">
                            {{ news.category }}
                        </span>
                    </div>

                    <!-- Headline -->
                    <h1
                        class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-tight tracking-tight mb-6">
                        {{ news.title }}
                    </h1>

                    <!-- Excerpt -->
                    <p class="text-lg sm:text-xl text-slate-600 leading-relaxed mb-8 font-medium">
                        {{ news.excerpt }}
                    </p>

                    <!-- Meta Bar -->
                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-6 border-y border-slate-200 mb-8">
                        <!-- Author & Date -->
                        <div class="flex items-center gap-4">
                            <!-- Author Avatar -->
                            <div v-if="news.author?.avatar" class="w-12 h-12 rounded-full overflow-hidden">
                                <img :src="news.author.avatar" :alt="news.author.name"
                                    class="w-full h-full object-cover" />
                            </div>
                            <div v-else
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ authorInitials }}
                            </div>

                            <div>
                                <p class="font-bold text-slate-900">
                                    {{ news.author?.name ?? 'Redaksi' }}
                                </p>
                                <div class="flex items-center gap-3 text-sm text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <Calendar class="h-3.5 w-3.5" />
                                        {{ formatDate(news.published_at) }}
                                    </span>
                                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                    <span class="flex items-center gap-1">
                                        <Clock class="h-3.5 w-3.5" />
                                        {{ readingTime }} menit baca
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Share Buttons -->
                        <div class="flex items-center gap-2">
                            <span
                                class="text-xs font-semibold text-slate-400 uppercase tracking-wider mr-2">Share</span>
                            <button @click="shareOnFacebook"
                                class="w-9 h-9 rounded-full bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition-colors"
                                title="Share on Facebook">
                                <Facebook class="h-4 w-4" />
                            </button>
                            <button @click="shareOnTwitter"
                                class="w-9 h-9 rounded-full bg-slate-900 hover:bg-slate-800 text-white flex items-center justify-center transition-colors"
                                title="Share on X">
                                <Twitter class="h-4 w-4" />
                            </button>
                            <button @click="shareOnWhatsApp"
                                class="w-9 h-9 rounded-full bg-green-500 hover:bg-green-600 text-white flex items-center justify-center transition-colors"
                                title="Share on WhatsApp">
                                <MessageCircle class="h-4 w-4" />
                            </button>
                            <button @click="copyLink"
                                class="w-9 h-9 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-700 flex items-center justify-center transition-colors relative"
                                title="Copy Link">
                                <LinkIcon class="h-4 w-4" />
                                <span v-if="linkCopied"
                                    class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                    Tersalin!
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <figure class="mb-10">
                        <div
                            class="relative rounded-[2rem] overflow-hidden shadow-2xl shadow-slate-300/50 aspect-video bg-slate-100">
                            <img :src="mainImageSrc" :alt="news.title" loading="lazy" class="w-full h-full object-cover"
                                @error="handleMainImageError" />
                        </div>
                        <figcaption v-if="news.image_caption" class="mt-4 text-center text-sm text-slate-500 italic">
                            {{ news.image_caption }}
                        </figcaption>
                    </figure>

                    <!-- Article Body with Typography -->
                    <div class="prose prose-slate lg:prose-xl max-w-none
                               prose-headings:font-black prose-headings:tracking-tight prose-headings:text-slate-900
                               prose-h2:text-2xl prose-h2:sm:text-3xl prose-h2:lg:text-4xl prose-h2:mt-12 prose-h2:mb-6
                               prose-h3:text-xl prose-h3:sm:text-2xl prose-h3:lg:text-3xl prose-h3:mt-10 prose-h3:mb-4
                               prose-h4:text-lg prose-h4:lg:text-xl prose-h4:mt-8 prose-h4:mb-3
                               prose-p:text-slate-700 prose-p:leading-[1.85] prose-p:text-base prose-p:sm:text-lg prose-p:lg:text-xl prose-p:mb-6
                               prose-a:text-indigo-600 prose-a:font-bold prose-a:no-underline hover:prose-a:underline hover:prose-a:text-indigo-700
                               prose-strong:text-slate-900 prose-strong:font-bold
                               prose-blockquote:border-l-4 prose-blockquote:border-indigo-500 prose-blockquote:bg-indigo-50/50 prose-blockquote:rounded-r-2xl prose-blockquote:py-4 prose-blockquote:px-6 prose-blockquote:not-italic prose-blockquote:text-slate-700
                               prose-img:rounded-[2rem] prose-img:shadow-lg prose-img:shadow-slate-300/50 prose-img:my-8
                               prose-figure:my-10
                               prose-figcaption:text-center prose-figcaption:text-sm prose-figcaption:text-slate-500 prose-figcaption:mt-4
                               prose-ul:my-8 prose-ol:my-8 prose-ul:space-y-2 prose-ol:space-y-2
                               prose-li:text-slate-700 prose-li:leading-relaxed prose-li:marker:text-indigo-500
                               prose-hr:border-slate-200 prose-hr:my-12
                               prose-code:bg-slate-100 prose-code:px-2 prose-code:py-1 prose-code:rounded-lg prose-code:text-indigo-600 prose-code:font-semibold prose-code:before:content-none prose-code:after:content-none
                               prose-pre:bg-slate-900 prose-pre:rounded-2xl prose-pre:shadow-xl prose-pre:my-8
                               prose-video:rounded-[2rem] prose-video:shadow-lg prose-video:aspect-video
                               [&_iframe]:rounded-[2rem] [&_iframe]:shadow-lg [&_iframe]:aspect-video [&_iframe]:w-full [&_iframe]:my-8"
                        v-html="news.content">
                    </div>

                    <!-- Tags -->
                    <div v-if="news.tags && news.tags.length > 0" class="mt-10 pt-8 border-t border-slate-200">
                        <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Tags</h4>
                        <div class="flex flex-wrap gap-2">
                            <span v-for="tag in news.tags" :key="tag"
                                class="px-4 py-2 rounded-full bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200 transition-colors cursor-pointer">
                                #{{ tag }}
                            </span>
                        </div>
                    </div>

                    <!-- Article Footer -->
                    <div class="mt-10 p-6 rounded-[2rem] bg-slate-100 border border-slate-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-sm text-slate-500">
                                <Eye class="h-4 w-4" />
                                <span>{{ news.views_count.toLocaleString('id-ID') }} kali dibaca</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-slate-500">Bagikan:</span>
                                <button @click="shareOnFacebook"
                                    class="p-2 rounded-lg hover:bg-slate-200 transition-colors text-slate-600">
                                    <Facebook class="h-4 w-4" />
                                </button>
                                <button @click="shareOnTwitter"
                                    class="p-2 rounded-lg hover:bg-slate-200 transition-colors text-slate-600">
                                    <Twitter class="h-4 w-4" />
                                </button>
                                <button @click="shareOnWhatsApp"
                                    class="p-2 rounded-lg hover:bg-slate-200 transition-colors text-slate-600">
                                    <MessageCircle class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Sidebar (Right - 1 column) -->
                <aside class="space-y-8">
                    <!-- Lapor Lur! CTA -->
                    <div class="rounded-[2rem] bg-indigo-600 p-8 text-white relative overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <svg class="w-full h-full" viewBox="0 0 100 100" fill="none">
                                <circle cx="80" cy="20" r="40" fill="currentColor" />
                                <circle cx="20" cy="80" r="30" fill="currentColor" />
                            </svg>
                        </div>

                        <div class="relative z-10">
                            <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center mb-5">
                                <Megaphone class="h-7 w-7" />
                            </div>
                            <h3 class="text-xl font-black mb-2">Lapor Lur!</h3>
                            <p class="text-indigo-100 text-sm leading-relaxed mb-6">
                                Punya informasi atau keluhan? Laporkan sekarang dan jadilah bagian dari perubahan
                                Purworejo!
                            </p>
                            <Link href="/laporan-warga"
                                class="inline-flex items-center gap-2 bg-white text-indigo-600 px-6 py-3 rounded-full font-bold text-sm hover:bg-indigo-50 transition-colors">
                                Buat Laporan
                                <ArrowRight class="h-4 w-4" />
                            </Link>
                        </div>
                    </div>

                    <!-- Related News -->
                    <div class="rounded-[2rem] bg-white border border-slate-200 p-6">
                        <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                            Berita Terkait
                        </h3>

                        <div v-if="relatedNews.length > 0" class="space-y-5">
                            <Link v-for="related in relatedNews" :key="related.id" :href="`/berita/${related.slug}`"
                                class="group flex gap-4 p-3 -mx-3 rounded-xl hover:bg-slate-50 transition-colors">
                                <!-- Thumbnail -->
                                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100">
                                    <img :src="related.image_url || FALLBACK_IMAGE" :alt="related.title" loading="lazy"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                                        {{ related.category }}
                                    </span>
                                    <h4
                                        class="text-sm font-bold text-slate-900 leading-snug mt-1 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                        {{ related.title }}
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-2">
                                        {{ formatShortDate(related.published_at) }}
                                    </p>
                                </div>
                            </Link>
                        </div>

                        <div v-else class="text-center py-8 text-slate-500">
                            <p class="text-sm">Belum ada berita terkait</p>
                        </div>

                        <!-- View All Link -->
                        <Link href="/trending"
                            class="mt-6 flex items-center justify-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-700 transition-colors">
                            Lihat Semua Berita
                            <ArrowRight class="h-4 w-4" />
                        </Link>
                    </div>

                    <!-- Newsletter (Optional) -->
                    <div class="rounded-[2rem] bg-gradient-to-br from-slate-900 to-slate-800 p-6 text-white">
                        <h3 class="text-lg font-black mb-2">Berlangganan Newsletter</h3>
                        <p class="text-slate-400 text-sm mb-5">
                            Dapatkan berita terbaru langsung ke inbox Anda
                        </p>
                        <form @submit.prevent class="space-y-3">
                            <input type="email" placeholder="Email Anda"
                                class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" />
                            <button type="submit"
                                class="w-full px-4 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 font-bold text-sm transition-colors">
                                Berlangganan
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Plus Jakarta Sans styling */
.font-\[\'Plus_Jakarta_Sans\'\] {
    font-family: 'Plus Jakarta Sans', 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
}

/* Line clamp utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
