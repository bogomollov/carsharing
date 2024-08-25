<script setup>
import Logo from '@/Components/SunLogo.vue';
import Logo2 from '@/Components/MoonLogo.vue';
</script>

<template>
    <button
        role="button"
        @click="changeTheme">
        class="themeButton"
    </button>
</template>

<script>
export default {
    data() {
        return {
            theme: "light",
        }
    }
}
</script>