<script setup>
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import ThemeButton from '@/Components/ThemeButton.vue';
</script>

<template>
    <header>
        <ApplicationLogo />
        <div class="menu">
            <Link :href="route('login')">О нас</Link>
            <Link :href="route('login')">Автопарк</Link>
            <Link :href="route('login')">Контакты</Link>
            <Link :href="route('login')">FAQ</Link>
        </div>
        <div class="auth">
            <ThemeButton />
            <Button color="gray"><Link :href="route('login')">Войти</Link></Button>
            <Button color="blue"><Link :href="route('register')">Создать аккаунт</Link></Button>
        </div>
    </header>
    <section class="content">
        <slot />
    </section>
    <footer>

    </footer>
</template>

<style scoped>
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 50px;
  margin-bottom: var(--section-gap);
  min-height: 45px;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.menu {
  display: flex;
  gap: 40px;
  justify-content: space-between;
  align-items: center;
}

.menu a {
  color: var(--color-text);
}

.menu a:hover {
  color: var(--color-blue);
}

.auth {
  display: flex;
  gap: 30px;
  font-size: var(--text-p);
  font-weight: 500;
}
</style>