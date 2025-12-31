<template>
    <div
        class="m3-card bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden group shadow-sm hover:shadow-xl">
        <div class="relative h-48 overflow-hidden">
            <img :src="image" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                :alt="title">
            <div
                class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[9px] font-black text-indigo-600 shadow-sm uppercase">
                {{ category }}
            </div>
            <div v-if="rating"
                class="absolute bottom-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-[9px] font-black flex items-center gap-1 shadow-lg">
                <i class="fa-solid fa-star text-[8px]"></i> {{ rating }}
            </div>
        </div>
        <div class="p-6">
            <h3 class="text-lg font-black text-slate-950 mb-1 group-hover:text-indigo-600 transition-colors">{{ title }}
            </h3>
            <p class="text-slate-500 text-[11px] font-bold flex items-center gap-2 mb-4 uppercase tracking-wider">
                <i class="fa-solid fa-location-dot text-indigo-400"></i> {{ location }}
            </p>
            <p class="text-slate-500 text-xs leading-relaxed mb-6 line-clamp-2 italic">"{{ description }}"</p>
            <div class="flex gap-2">
                <a :href="whatsappLink" target="_blank"
                    class="flex-1 bg-green-50 text-green-600 px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-green-600 hover:text-white transition-all">
                    <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                </a>
                <button
                    class="w-12 h-12 bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                    <i class="fa-solid fa-share-nodes"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
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
    category: {
        type: String,
        required: true
    },
    location: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    phoneNumber: {
        type: String,
        required: true
    },
    rating: {
        type: [Number, String],
        default: null
    }
});

const whatsappLink = computed(() => {
    // Basic formatting, assuming phoneNumber is just digits or needs '62' prefix handling if needed.
    // For now, just passing it through or prepending if it's a local number could be an enhancement,
    // but let's assume the prop provides a valid number for wa.me
    return `https://wa.me/${props.phoneNumber}`;
});
</script>
