<template>
    <span :class="badgeClasses">
        <slot>{{ displayLabel }}</slot>
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
    },
    status: {
        type: String,
        default: '' // pending, verified, in_progress, resolved, rejected
    }
});

// Status labels for citizen reports
const statusLabels = {
    pending: 'Menunggu',
    verified: 'Terverifikasi',
    in_progress: 'Sedang Ditangani',
    resolved: 'Selesai',
    rejected: 'Ditolak',
};

// Display label - prioritize status if provided
const displayLabel = computed(() => {
    if (props.status && statusLabels[props.status]) {
        return statusLabels[props.status];
    }
    return props.label;
});

const badgeClasses = computed(() => {
    // Handle citizen report statuses first
    if (props.status) {
        switch (props.status) {
            case 'pending':
                return 'px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full uppercase tracking-wider border border-amber-200';
            case 'verified':
                return 'px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full uppercase tracking-wider border border-blue-200';
            case 'in_progress':
                return 'px-3 py-1 bg-purple-100 text-purple-700 text-[10px] font-bold rounded-full uppercase tracking-wider border border-purple-200';
            case 'resolved':
                return 'px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase tracking-wider border border-green-200';
            case 'rejected':
                return 'px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-full uppercase tracking-wider border border-red-200';
            default:
                return 'px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-full uppercase tracking-wider';
        }
    }

    // Handle original type-based styling
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
