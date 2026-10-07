<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import AppHeader from '@/components/common/AppHeader.vue'
import AppSidebar from '@/components/common/AppSidebar.vue'

const route = useRoute()
const isLogin = computed(() => route.name === 'login')
</script>

<template>
  <div v-if="isLogin">
    <RouterView />
  </div>
  <div v-else class="layout">
    <AppSidebar />
    <div class="content">
      <AppHeader />
      <main><RouterView /></main>
    </div>
  </div>
</template>

<style>
* { box-sizing: border-box; }
body { margin: 0; font-family: system-ui, -apple-system, sans-serif; background: #f1f5f9; color: #1e293b; }
.layout { display: flex; min-height: 100vh; }
.content { flex: 1; display: flex; flex-direction: column; }
main { padding: 1.5rem; flex: 1; }
button { cursor: pointer; padding: .5rem 1rem; border: 1px solid #cbd5e1; background: white; border-radius: 6px; font-size: .9rem; }
button:hover { background: #f1f5f9; }
button.primary { background: #2563eb; color: white; border-color: #2563eb; }
button.primary:hover { background: #1d4ed8; }
button.danger { background: #dc2626; color: white; border-color: #dc2626; }
input, select, textarea { padding: .5rem .75rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: .9rem; width: 100%; }
table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
th, td { padding: .75rem 1rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
th { background: #f8fafc; font-weight: 600; font-size: .85rem; text-transform: uppercase; color: #64748b; }
h1, h2, h3 { margin-top: 0; }
.card { background: white; padding: 1.25rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
</style>
