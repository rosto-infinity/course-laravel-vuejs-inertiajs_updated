<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import { Moon, Sun } from 'lucide-vue-next';

const { appearance, updateAppearance } = useAppearance();

const toggleAppearance = () => {
    const newAppearance = appearance.value === 'light' ? 'dark' : 'light';
    updateAppearance(newAppearance);
};
</script>

<template>
    <button
        @click="toggleAppearance"
        class="relative flex h-6 w-12 cursor-pointer items-center rounded-full border-1 border-gray-200 bg-gray-300 p-0.5 transition-colors duration-300 ease-in-out focus:outline-none dark:border-gray-500 dark:bg-gray-600"
        role="switch"
        :aria-checked="appearance === 'dark'"
    >
        <!-- Le poussoir vert -->
        <span
            class="absolute flex h-5 w-5 items-center justify-center rounded-full bg-white shadow dark:bg-primary"
            :class="
                appearance === 'dark'
                    ? 'left-6 translate-x-0'
                    : 'left-0 translate-x-0'
            "
            style="
                transition-property: left;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 300ms;
            "
        >
            <!-- Icônes -->
            <Sun v-if="appearance === 'light'" class="h-3 w-3 text-green-800" />
            <Moon v-else class="h-3 w-3 text-white" />
        </span>
    </button>
</template>
