<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import Sidebar from '@/components/common/AppSidebar.vue'
import { Menu } from 'lucide-vue-next'

const router = useRouter()
const isSidebarOpen = ref(false)

onMounted(() => {
  // Load students data
})
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />
    
    <div class="flex-1 flex flex-col overflow-hidden">
      <header class="bg-white shadow-sm border-b">
        <div class="flex items-center justify-between h-16 px-6">
          <div class="flex items-center gap-4">
            <button @click="isSidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
              <Menu class="w-6 h-6" />
            </button>
            <h1 class="text-xl font-bold text-gray-800">Students - Show</h1>
          </div>
        </div>
      </header>

      <main class="flex-1 overflow-y-auto p-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
          <h2 class="text-lg font-semibold mb-4">Students Show</h2>
          <p class="text-gray-500">This is the Show page for students.</p>
        </div>
      </main>
    </div>
  </div>
</template>
