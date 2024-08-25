<script setup>
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
</script>

<template>
    <header>
        <Link :href="route('welcome')" class="logo">Drive</Link>
        <div class="menu">
            <Link :href="route('login')">О нас</Link>
            <Link :href="route('login')">Автопарк</Link>
            <Link :href="route('login')">Контакты</Link>
            <Link :href="route('login')">FAQ</Link>
        </div>
        <div class="auth">
            <Button class="blue"><Link :href="route('login')">Вход</Link></Button>
            <Link :href="route('register')">Регистрация</Link>
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

.logo {
  font-family: "Montserrat", sans-serif;
  font-optical-sizing: auto;
  font-weight: 500;
  font-size: 30px;
  font-style: normal;
  color: var(--color-dark);
  cursor: pointer;
}

.logo:hover {
  font-family: "Montserrat Alternates", sans-serif;
}

.menu {
  display: flex;
  gap: 40px;
  justify-content: space-between;
  align-items: center;
}

.menu a {
  color: var(--color-dark-gray);
}

.menu a:hover {
  color: var(--color-dark);
}

.auth {
  font-size: var(--text-p);
  font-weight: 500;
}
</style>