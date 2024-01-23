<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 font-normal text-start text-base leading-5 text-gray-700 hover:text-gray-900 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    >
        <slot />
    </Link>
</template>
