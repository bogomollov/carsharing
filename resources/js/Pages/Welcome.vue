<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Button from '@/Components/Button.vue';

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
    <GuestLayout>
        <div class="title">
            <div class="title-up">
                <h3>У нас есть подходящий автомобиль</h3>
                <h1>для любых потребностей</h1>
            </div>
            <div class="title-down">
                <h6>Поминутная аренда машины в любой точке города</h6>
                <Button><Link :href="route('register')">Начать поездку</Link></Button>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.title, .title-up, .title-down {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
}
.title {
    gap: 60px;
}
.title-down {
    gap: 30px;
}
h6 {
    color: var(--color-dark-gray);
}
</style>