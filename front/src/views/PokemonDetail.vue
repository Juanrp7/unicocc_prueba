<template>
    <section class="detail">
        <button class="detail-back" @click="$router.back()">← Volver</button>

        <div class="detail-grid" v-if="!store.loading && !store.error && store.detail">
            <!-- Columna izquierda: imagen -->
            <div class="detail-hero">
                <img v-if="store.detail.sprites?.other?.['official-artwork']?.front_default"
                    :src="store.detail.sprites.other['official-artwork'].front_default" :alt="store.detail.name" />
                <img v-else-if="store.detail.sprites?.front_default" :src="store.detail.sprites.front_default"
                    :alt="store.detail.name" />
            </div>

            <!-- Columna derecha: texto -->
            <div>
                <div class="detail-head">
                    <div class="detail-title">
                        <h1 class="detail-name">{{ store.detail.name }}</h1>
                        <span class="detail-number">#{{ store.detail.external_id }}</span>
                    </div>

                    <div class="detail-meta">
                        <div><strong>Peso:</strong> {{ store.detail.weight ?? '—' }}</div>
                        <div><strong>Altura:</strong> {{ store.detail.height ?? '—' }}</div>
                    </div>

                    <div v-if="store.detail.types?.length" class="detail-types">
                        <span v-for="t in store.detail.types" :key="t" class="type-badge" :class="`type-${t}`">
                            {{ t }}
                        </span>
                    </div>

                    <div v-if="store.detail.abilities?.length" class="detail-meta">
                        <div><strong>Habilidades:</strong> {{ store.detail.abilities.join(', ') }}</div>
                    </div>
                </div>

                <div v-if="store.detail.stats?.length">
                    <h3 class="h-sub" style="text-align:left;margin:10px 0 8px;">Stats</h3>
                    <div class="detail-stats">
                        <div v-for="s in store.detail.stats" :key="s.name" class="stat-chip">
                            <span>{{ s.name }}</span>
                            <strong>{{ s.base_stat }}</strong>
                        </div>
                    </div>
                </div>

                <div class="detail-actions">
                    <button class="btn btn-primary" @click="store.addFavorite(store.detail.id)">⭐ Agregar a
                        favoritos</button>
                    <button class="btn btn-ghost" @click="$router.back()">Volver</button>
                </div>
            </div>
        </div>

        <div v-else-if="store.loading" class="state">Cargando detalle…</div>
        <div v-else-if="store.error" class="state" style="color:#ff8a8a">{{ store.error }}</div>
    </section>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { usePokemonStore } from '../stores/pokemon'

const route = useRoute()
const router = useRouter()
const store = usePokemonStore()

const id = Number(route.params.id)

onMounted(async () => {
    if (!Number.isFinite(id)) return router.replace({ name: 'list' })
    await store.fetchDetail(id)
})
</script>

<style scoped>
.container {
    max-width: 900px;
}
</style>

