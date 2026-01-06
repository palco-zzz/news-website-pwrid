<template>
    <Link :href="href" class="block">
        <article class="m3-card group cursor-pointer flex flex-row items-start gap-3 md:block">
            <div
                class="relative shrink-0 w-24 h-24 rounded-2xl md:w-full md:h-auto md:aspect-[16/10] md:rounded-[2.5rem] overflow-hidden md:mb-4 bg-slate-100">
                <img :src="imageSrc" loading="lazy"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    :alt="title" @error="handleImageError">
            </div>
            <div class="flex-1 min-w-0">
                <h3
                    class="w-[85%] md:w-full text-sm font-extrabold text-slate-950 leading-tight md:text-xl group-hover:text-indigo-600 transition-colors line-clamp-2 md:line-clamp-none">
                    {{ title }}</h3>
                <div v-if="timestamp" class="mt-2 text-xs font-bold text-slate-400">
                    {{ timestamp }}
                </div>
            </div>
        </article>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const FALLBACK_IMAGE = 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=500&fit=crop&q=80';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    imageUrl: {
        type: String,
        default: null
    },
    slug: {
        type: String,
        default: ''
    },
    timestamp: {
        type: String,
        default: ''
    }
});

const imageError = ref(false);

const imageSrc = computed(() => {
    if (imageError.value || !props.imageUrl) {
        return FALLBACK_IMAGE;
    }
    return props.imageUrl;
});

const handleImageError = () => {
    imageError.value = true;
};

const href = computed(() => props.slug ? `/berita/${props.slug}` : '#');
</script>
