<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="route('welcome')" class="logo">Driv<a class="letter">e</a></Link>
</template>

<style lang="scss">
.logo, .letter {
  font-family: "Montserrat", sans-serif;
  font-optical-sizing: auto;
  font-weight: 500;
  font-size: var(--text-h4);
  font-style: normal;
  color: var(--color-dark);
  cursor: pointer;

  &:hover {
    .letter {
        margin-left: -0.5px;
        font-family: "Montserrat Alternates", sans-serif;
    }
  }
}
</style>