<template>
    <div
        class="bg-slate-50 rounded-[2.5rem] p-12 border border-slate-100 shadow-sm text-center flex flex-col items-center justify-center min-h-[400px]">
        <div
            class="w-24 h-24 bg-white text-indigo-600 rounded-3xl flex items-center justify-center text-4xl mb-6 shadow-lg shadow-indigo-100 animate-float">
            <i :class="icon"></i>
        </div>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-950 mb-3 tracking-tight">{{ title }}</h2>
        <p class="text-slate-500 font-medium text-base sm:text-lg max-w-md mb-8 leading-relaxed">{{ description }}</p>
        <button v-if="actionLabel" @click="$emit('action')"
            class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-200 hover:scale-95 hover:shadow-indigo-100 transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            {{ actionLabel }}
        </button>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    icon: {
        type: String,
        default: 'fa-solid fa-box-open'
    },
    actionLabel: {
        type: String,
        default: ''
    }
});

defineEmits(['action']);
</script>

<style scoped>
@keyframes float {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-10px);
    }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}
</style>
