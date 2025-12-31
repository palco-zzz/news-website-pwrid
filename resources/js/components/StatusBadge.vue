<template>
    <span :class="badgeClasses">
        <slot>{{ label }}</slot>
    </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'headline', // headline, viral, umkm, lost
        validator: (value) => ['headline', 'viral', 'umkm', 'lost'].includes(value)
    }
});

const badgeClasses = computed(() => {
    switch (props.type) {
        case 'headline':
            return 'px-3 sm:px-4 py-1.5 bg-indigo-600 text-white text-[9px] sm:text-[10px] font-black rounded-full uppercase tracking-widest shadow-lg';
        case 'viral':
            return 'text-[10px] font-black text-orange-600 uppercase tracking-widest';
        case 'umkm':
            return 'bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[9px] font-black text-indigo-600 shadow-sm uppercase';
        case 'lost':
            return 'px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black rounded-full uppercase tracking-widest';
        default:
            return 'px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-full uppercase tracking-widest';
    }
});
</script>
