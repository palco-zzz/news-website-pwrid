<template>
    <Link :href="href" class="block">
        <article class="m3-card group cursor-pointer">
            <div class="relative rounded-[2.5rem] overflow-hidden mb-4 aspect-[16/10] bg-slate-100">
                <img :src="image"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    :alt="title">
            </div>
            <h3
                class="text-xl font-extrabold text-slate-950 leading-tight group-hover:text-indigo-600 transition-colors">
                {{ title }}</h3>
            <div v-if="timestamp" class="mt-2 text-xs font-bold text-slate-400">
                {{ timestamp }}
            </div>
        </article>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    image: {
        type: String,
        required: true
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

const href = computed(() => props.slug ? `/berita/${props.slug}` : '#');
</script>
