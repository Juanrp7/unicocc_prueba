import { ref } from 'vue'
import Toast from '../components/Toast.vue'

export const toastMessage = ref('')
export const toastKey = ref(0)

export function showToast(message: string) {
    toastMessage.value = message
    toastKey.value++  // fuerza re-render del componente para reiniciar la animación
}

export { Toast }