import { createRouter, createWebHistory } from 'vue-router'
import PokemonList from '../views/PokemonList.vue'
import PokemonDetail from '../views/PokemonDetail.vue'

export default createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', name: 'list', component: PokemonList },
        { path: '/pokemon/:id', name: 'detail', component: PokemonDetail, props: true },
    ],
})
