<script setup lang="ts">
import TypeBadge from './TypeBadge.vue' 

// props disponibles en el template directamente (name, id, external, img, types)
defineProps<{ name: string; id: number; external: number; img?: string; types?: string[] }>()
</script>

<template>
    <article class="poke-card">
        <span class="poke-id">#{{ external }}</span>

        <div class="poke-wrap">
            <div class="poke-img">
                <img v-if="img" :src="img" :alt="name" />
            </div>

            <div>
                <h2 class="poke-name">{{ name }}</h2>

                <div class="poke-types">
                    <TypeBadge v-for="t in (types || [])" :key="t" :type="t" />
                </div>

                <div class="poke-foot">
                    <slot />
                </div>
            </div>
        </div>
    </article>
</template>
