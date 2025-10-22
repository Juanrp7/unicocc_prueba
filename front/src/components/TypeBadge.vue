<script setup lang="ts">
defineProps<{ type: string }>()
</script>
<template>
    <span class="type-badge" :class="`type-${type.toLowerCase()}`">
        {{ type }}
    </span>

</template>