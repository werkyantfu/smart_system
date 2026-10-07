<script setup>
import { onMounted } from 'vue'
import { useTeacherStore } from '@/stores/teacher'

const store = useTeacherStore()
onMounted(() => store.fetchAll())
</script>

<template>
  <div>
    <div class="head">
      <h1>Teachers <small>({{ store.count }})</small></h1>
      <button @click="store.fetchAll()" :disabled="store.loading">
        {{ store.loading ? 'Loading…' : 'Refresh' }}
      </button>
    </div>
    <p v-if="store.error" class="error">{{ store.error }}</p>
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr></thead>
      <tbody>
        <tr v-for="t in store.list" :key="t.id">
          <td>{{ t.id }}</td>
          <td>{{ t.first_name }} {{ t.last_name }}</td>
          <td>{{ t.email }}</td>
          <td>{{ t.phone || '—' }}</td>
        </tr>
        <tr v-if="store.list.length === 0"><td colspan="4">No teachers yet.</td></tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.head small { color: #64748b; font-weight: 400; }
.error { color: #dc2626; }
</style>
