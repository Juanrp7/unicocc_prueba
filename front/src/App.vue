<script setup lang="ts">
  import { Toast, toastMessage, toastKey } from './composables/useToast'
</script>

<template>
  <router-view />
  <Toast v-if="toastMessage" :key="toastKey" :message="toastMessage" />
</template>