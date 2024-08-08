<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>
    <Head title="Drive" />
    <Link :href="route('login')">Вход</Link>
    <Link :href="route('register')">Регистрация</Link>
    </template>
<script>
</script>