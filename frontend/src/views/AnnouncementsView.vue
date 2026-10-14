<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import { Megaphone, Plus } from 'lucide-vue-next'

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />
    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Announcements" @toggle-sidebar="isSidebarOpen = true" />
      <main class="flex-1 overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">Announcements</h2>
            <p class="text-gray-500 text-sm">School announcements</p>
          </div>
          <button class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <Plus class="w-4 h-4" />
            <span>New Announcement</span>
          </button>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
          <Megaphone class="w-16 h-16 text-gray-300 mx-auto mb-4" />
          <p class="text-gray-500">No announcements found</p>
        </div>
      </main>
    </div>
  </div>
</template>
