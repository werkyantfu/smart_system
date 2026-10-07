<script setup>
import { onMounted } from 'vue'
import { useDashboardStore } from '@/stores/dashboard'

const store = useDashboardStore()
onMounted(() => store.fetchAll())
</script>

<template>
  <div>
    <h1>Dashboard</h1>
    <p v-if="store.loading">Loading…</p>
    <p v-if="store.error" class="error">{{ store.error }}</p>

    <div class="stats">
      <div class="card stat" v-for="(v, k) in store.stats" :key="k">
        <div class="label">{{ k }}</div>
        <div class="value">{{ v }}</div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.stats { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-top: 1rem; }
.stat .label { font-size: .75rem; text-transform: uppercase; color: #64748b; letter-spacing: .05em; }
.stat .value { font-size: 1.8rem; font-weight: 700; margin-top: .35rem; color: #0f172a; }
.error { color: #dc2626; }
</style>
