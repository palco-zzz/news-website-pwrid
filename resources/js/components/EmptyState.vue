<template>
    <div
        class="bg-slate-50 rounded-[2.5rem] p-8 sm:p-12 border border-slate-100 shadow-sm text-center flex flex-col items-center justify-center min-h-[400px]">
        <!-- Icon with floating animation -->
        <div
            class="w-20 h-20 sm:w-24 sm:h-24 bg-white text-indigo-600 rounded-3xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-100/50 animate-float">
            <!-- Lucide Icon -->
            <component v-if="lucideIcon" :is="lucideIcon" class="w-10 h-10 sm:w-12 sm:h-12 stroke-[1.5]" />
            <!-- FontAwesome Icon fallback -->
            <i v-else :class="[icon, 'text-3xl sm:text-4xl']"></i>
        </div>

        <!-- Title - Plus Jakarta Sans Black -->
        <h2 class="text-xl sm:text-2xl md:text-3xl font-black text-slate-950 mb-3 tracking-tight font-display">
            {{ title }}
        </h2>

        <!-- Description - Plus Jakarta Sans Medium -->
        <p class="text-slate-500 font-medium text-sm sm:text-base md:text-lg max-w-md mb-8 leading-relaxed">
            {{ description }}
        </p>

        <!-- Action Button - Only shown for admins or when always visible -->
        <Link v-if="actionLink && (isAdmin || showActionForAll)" :href="actionLink"
            class="bg-indigo-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-[0.98] active:scale-95 transition-all flex items-center gap-2">
            <Plus class="w-4 h-4 sm:w-5 sm:h-5" />
            {{ actionLabel }}
        </Link>

        <!-- Fallback button with emit -->
        <button v-else-if="actionLabel && !actionLink && (isAdmin || showActionForAll)" @click="$emit('action')"
            class="bg-indigo-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl font-black text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-[0.98] active:scale-95 transition-all flex items-center gap-2">
            <Plus class="w-4 h-4 sm:w-5 sm:h-5" />
            {{ actionLabel }}
        </button>

        <!-- Secondary action (e.g., go back, explore) -->
        <button v-if="secondaryLabel" @click="$emit('secondary')"
            class="mt-4 text-slate-500 hover:text-indigo-600 font-bold text-sm transition-colors flex items-center gap-2">
            <component v-if="secondaryIcon" :is="secondaryIcon" class="w-4 h-4" />
            {{ secondaryLabel }}
        </button>
    </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { computed, type Component } from 'vue';

interface Props {
    title: string;
    description: string;
    icon?: string;
    lucideIcon?: Component;
    actionLabel?: string;
    actionLink?: string;
    secondaryLabel?: string;
    secondaryIcon?: Component;
    showActionForAll?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    icon: 'fa-solid fa-box-open',
    actionLabel: '',
    actionLink: '',
    secondaryLabel: '',
    showActionForAll: false,
});

defineEmits(['action', 'secondary']);

const page = usePage();
const isAdmin = computed(() => !!page.props.auth?.user);
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

.font-display {
    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
}
</style>
