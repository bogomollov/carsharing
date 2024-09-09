<script setup>
const props = defineProps({
    color: {
        type: String,
        default: 'white',
    }
});
</script>

<template>
    <button :class="['btn', `btn_${color}`]">
        <slot />
    </button>
</template>
<style lang="scss">
.btn {
    border-radius: 10px;
    padding: 12px 18px;
    transition: .2s;

    &_white {
        background-color: transparent;
        border: 1px solid var(--color-light-gray);
        padding: 14px 18px;
        a {
            color: var(--color-dark-gray);
        }

        &:enabled:hover {
            background-color: var(--color-blue-hover);
            border: 1px solid var(--color-blue-hover);
            a {
                color: var(--color-white);
            }
        }
    }
    
    &_blue {
        background-color: var(--color-blue);
        a {
            color: var(--color-white);
        }

        &:enabled:hover {
            background-color: var(--color-blue-hover);
        }
    }

    &_gray {
        background-color: var(--color-light-gray);
        a {
            color: var(--color-dark-gray);
        }
        
        &:enabled:hover {
            background-color: var(--color-gray);
        }
    }
}
</style>