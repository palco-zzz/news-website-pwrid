<template>
    <article class="m3-card group cursor-pointer">
        <div class="relative rounded-[2.5rem] overflow-hidden mb-4 aspect-[16/10] bg-slate-100">
            <img :src="image" class="w-full h-full object-cover" :alt="title">
        </div>
        <h3 class="text-xl font-extrabold text-slate-950 leading-tight">{{ title }}</h3>
        <div v-if="timestamp" class="mt-2 text-xs font-bold text-slate-400">
            {{ timestamp }}
        </div>
    </article>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true
    },
    image: {
        type: String,
        required: true
    },
    timestamp: {
        type: String,
        default: ''
    }
});
</script>
