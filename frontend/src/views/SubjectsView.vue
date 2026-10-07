<script setup>
import { onMounted } from 'vue'
import { useSubjectStore } from '@/stores/subject'

const store = useSubjectStore()
onMounted(() => store.fetchAll())
</script>

<template>
  <div>
    <div class="head">
      <h1>Subjects <small>({{ store.count }})</small></h1>
      <button @click="store.fetchAll()" :disabled="store.loading">
        {{ store.loading ? 'Loading…' : 'Refresh' }}
      </button>
    </div>
    <p v-if="store.error" class="error">{{ store.error }}</p>
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Code</th></tr></thead>
      <tbody>
        <tr v-for="s in store.list" :key="s.id">
          <td>{{ s.id }}</td>
          <td>{{ s.name }}</td>
          <td>{{ s.code || '—' }}</td>
        </tr>
        <tr v-if="store.list.length === 0"><td colspan="3">No subjects yet.</td></tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.head small { color: #64748b; font-weight: 400; }
.error { color: #dc2626; }
</style>
