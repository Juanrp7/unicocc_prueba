<template>
    <transition name="toast">
        <div v-if="visible" class="toast">{{ message }}</div>
    </transition>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'

const props = defineProps<{ message: string; duration?: number }>()
const visible = ref(true)

onMounted(() => {
    setTimeout(() => (visible.value = false), props.duration ?? 2500)
})
</script>

<style scoped>
.toast {
    position: fixed;
    bottom: 28px;
    right: 28px;
    background: #2d2f36;
    border: 1px solid #444;
    padding: 12px 20px;
    border-radius: 12px;
    color: #fff;
    font-weight: 500;
    box-shadow: 0 8px 24px rgba(0, 0, 0, .35);
    z-index: 1000;
    animation: pop .25s ease;
}

@keyframes pop {
    from {
        transform: translateY(10px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.toast-enter-active,
.toast-leave-active {
    transition: opacity .3s, transform .3s;
}

.toast-enter-from,
.toast-leave-to {
    opacity: 0;
    transform: translateY(10px);
}
</style>
