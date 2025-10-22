import { defineStore } from 'pinia'
import api from '../services/api'
import { showToast } from '../composables/useToast'

export interface Pokemon {
    id: number
    external_id: number
    name: string
    height?: number
    weight?: number
    base_experience?: number
    sprites?: Record<string, any>
    types?: string[]
    abilities?: string[]
    stats?: { name: string; base_stat: number }[]
}

export interface Pagination<T> {
    data: T[]
    current_page: number
    per_page: number
    total: number
    last_page: number
}

type ListParams = {
    search?: string
    type?: string
    ability?: string
    min_weight?: number
    max_weight?: number
    min_height?: number
    max_height?: number
    sort?: 'name' | 'weight' | 'height' | 'base_experience'
    dir?: 'asc' | 'desc'
    page?: number
    per_page?: number
}

export const usePokemonStore = defineStore('pokemon', {
    state: () => ({
        items: [] as Pokemon[],
        page: 1,
        per_page: 20,
        total: 0,
        last_page: 1,
        loading: false,
        error: '' as string | null,
        detail: null as Pokemon | null,
        // filtros UI
        search: '' as string,
        type: '' as string,
        ability: '' as string,
        sort: 'name' as ListParams['sort'],
        dir: 'asc' as ListParams['dir'],
    }),

    getters: {
        hasMore: (s) => s.page < s.last_page,
    },

    actions: {
        async fetchList(overrides: Partial<ListParams> = {}) {
            this.loading = true; this.error = null
            try {
                const params: ListParams = {
                    search: this.search || undefined,
                    type: this.type || undefined,
                    ability: this.ability || undefined,
                    sort: this.sort,
                    dir: this.dir,
                    page: overrides.page ?? this.page,
                    per_page: overrides.per_page ?? this.per_page,
                    ...overrides
                }
                const { data } = await api.get<Pagination<Pokemon>>('/pokemon', { params })
                this.items = data.data
                this.page = data.current_page
                this.per_page = data.per_page
                this.total = data.total
                this.last_page = data.last_page
            } catch (e: any) {
                this.error = e?.response?.data?.message ?? e?.message ?? 'Error cargando Pokémon'
            } finally {
                this.loading = false
            }
        },

        async fetchDetail(id: number) {
            this.loading = true; this.error = null; this.detail = null
            try {
                const { data } = await api.get<Pokemon>(`/pokemon/${id}`)
                this.detail = data
            } catch (e: any) {
                this.error = e?.response?.data?.message ?? e?.message ?? 'Error cargando detalle'
            } finally {
                this.loading = false
            }
        },

        async addFavorite(pokemon_id: number, user_ref = 'guest') {
            try {
                await api.post('/favorites', { pokemon_id, user_ref })
                showToast('✅ Pokémon añadido a favoritos')
                return true
            } catch (e) {
                showToast('⚠️ No se pudo agregar a favoritos')
                return false
            }
        },
    }
})
