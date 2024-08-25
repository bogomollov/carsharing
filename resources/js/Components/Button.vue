<template>
    <button>
        <slot />
    </button>
</template>
<style>
.blue {
    background-color: var(--color-blue);
    color: var(--color-white);
}
.blue:hover {
    background-color: var(--color-blue-hover);
}

.gray {
    background-color: var(--color-gray);
    color: var(--color-dark);
}
.gray:hover {
    background-color: var(--color-light-gray);
}

.white-blue {
    background-color: transparent;
    color: var(--color-dark);
}
.white-blue:hover {
    background-color: var(--color-blue-hover);
    color: var(--color-white);
}
</style>