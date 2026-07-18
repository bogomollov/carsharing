<script setup>
import { ref, onMounted } from 'vue';
import SunLogo from '@/Components/SunLogo.vue';
import MoonLogo from '@/Components/MoonLogo.vue';

const theme = ref('light');

function applyTheme(value) {
    document.documentElement.setAttribute('data-theme', value);
    localStorage.setItem('theme', value);
    theme.value = value;
}

function toggleTheme() {
    applyTheme(theme.value === 'dark' ? 'light' : 'dark');
}

onMounted(() => {
    theme.value = document.documentElement.getAttribute('data-theme') ?? 'light';
});
</script>

<template>
    <button
        type="button"
        class="theme-button"
        :aria-label="theme === 'dark' ? 'Переключить на светлую тему' : 'Переключить на тёмную тему'"
        :aria-pressed="theme === 'dark'"
        @click="toggleTheme"
    >
        <MoonLogo v-if="theme === 'dark'" />
        <SunLogo v-else />
    </button>
</template>

<style scoped>
.theme-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    border-radius: 10px;
    background-color: var(--color-light-gray);
    color: var(--color-dark-gray);
    transition: background-color 0.2s;
}

.theme-button:hover {
    background-color: var(--color-gray);
}

.theme-button :deep(svg) {
    width: 20px;
    height: 20px;
}
</style>
