<template>
    <section class="container">
        <h1 class="h-title">API POKEMON</h1>


        <!-- filtros -->
        <div class="filters">
            <input v-model="localSearch" class="input" placeholder="Buscar por nombre..." />
            <input v-model="localType" class="input" placeholder="Tipo (e.g., fire)" />
            <input v-model="localAbility" class="input" placeholder="Habilidad (e.g., overgrow)" />
            <div class="btn group">
                <button class="btn" @click="applyFilters">Aplicar</button>
                <button class="btn secondary" @click="clearFilters">Limpiar</button>
            </div>
        </div>

        <!-- estados -->
        <div v-if="store.loading" class="state">Cargando…</div>
        <div v-else-if="store.error" class="state" style="color:#ff8a8a">{{ store.error }}</div>

        <!-- grid -->
        <div v-else class="pokedex-grid">
            <PokeCard v-for="p in store.items" :key="p.id" :name="p.name" :id="p.id" :external="p.external_id"
                :img="p.sprites?.front_default" :types="p.types" @click="goDetail(p.id)">
                <div class="poke-foot">
                    <small style="color:var(--muted)">Peso: {{ p.weight ?? '—' }} · Altura: {{ p.height ?? '—'
                    }}</small>
                </div>
                <button class="star" @click.stop="store.addFavorite(p.id)">⭐ Favorito</button>
            </PokeCard>
        </div>

        <!-- paginación -->
        <div class="pager">
            <button class="btn" :disabled="store.page <= 1" @click="prevPage">← Anterior</button>
            <div class="state">Página {{ store.page }} / {{ store.last_page }} — Total: {{ store.total }}</div>
            <button class="btn" :disabled="store.page >= store.last_page" @click="nextPage">Siguiente →</button>
        </div>
    </section>
</template>

<style scoped>
.container {
    max-width: 1100px;
}
</style>

<script setup lang="ts">
import { onMounted, ref, watch } from "vue";
import { usePokemonStore } from "../stores/pokemon";
import { useRouter } from "vue-router";
import PokeCard from '../components/PokeCard.vue'

const store = usePokemonStore();
const router = useRouter();

const localSearch = ref(store.search);
const localType = ref(store.type);
const localAbility = ref(store.ability);

function applyFilters() {
    store.search = localSearch.value.trim();
    store.type = localType.value.trim();
    store.ability = localAbility.value.trim();
    store.fetchList({ page: 1 });
}

function clearFilters() {
    localSearch.value = "";
    localType.value = "";
    localAbility.value = "";
    applyFilters();
}

function goDetail(id: number) {
    router.push({ name: "detail", params: { id } });
}

function nextPage() {
    if (store.page < store.last_page) store.fetchList({ page: store.page + 1 });
}
function prevPage() {
    if (store.page > 1) store.fetchList({ page: store.page - 1 });
}

onMounted(() => {
    store.fetchList();
});

// Opcional: aplica búsqueda “debounced”
watch(localSearch, (v, old) => {
    if (v !== old) {
        const t = setTimeout(() => applyFilters(), 400);
        return () => clearTimeout(t);
    }
});
</script>
