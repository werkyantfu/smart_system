<script setup>
import { ref, onMounted, computed } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import ClassList from '@/components/classes/ClassList.vue'
import { useClassStore } from '@/stores/class'
import { Plus, Search } from 'lucide-vue-next'

const classStore = useClassStore()
const isSidebarOpen = ref(false)
const searchQuery = ref('')

const filteredClasses = computed(() => {
  if (!searchQuery.value) return classStore.items || []
  const q = searchQuery.value.toLowerCase()
  return (classStore.items || []).filter(cls =>
    cls.name?.toLowerCase().includes(q) ||
    String(cls.grade_level).includes(q) ||
    cls.section?.toLowerCase().includes(q)
  )
})

onMounted(() => {
  classStore.fetchAll?.()
})

function handleEdit(cls) {
  console.log('Edit:', cls)
}

function handleDelete(cls) {
  if (confirm(`Delete ${cls.name}?`)) {
    classStore.remove?.(cls.id)
  }
}
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
      <AppHeader title="Classes" @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto p-6">
        <!-- Page Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
          <div class="min-w-0">
            <h2 class="text-2xl font-bold text-gray-800">All Classes</h2>
            <p class="text-gray-500 text-sm">Manage school classes</p>
          </div>
          
          <button 
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors flex-shrink-0"
          >
            <Plus class="w-4 h-4" />
            <span>Add Class</span>
          </button>
        </div>

        <!-- Search Bar -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
          <div class="relative">
            <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" />
            <input 
              v-model="searchQuery"
              type="text"
              placeholder="Search classes..."
              class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-gray-800"
            />
          </div>
        </div>

        <!-- Class List -->
        <ClassList 
          :classes="filteredClasses" 
          :loading="classStore.loading"
          @edit="handleEdit"
          @delete="handleDelete"
        />
      </main>
    </div>
  </div>
</template>
