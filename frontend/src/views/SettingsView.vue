<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import { Settings, Save } from 'lucide-vue-next'

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />
    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Settings" @toggle-sidebar="isSidebarOpen = true" />
      <main class="flex-1 overflow-y-auto p-6">
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-gray-800">Settings</h2>
          <p class="text-gray-500 text-sm">Manage system settings</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
          <h3 class="text-lg font-bold text-gray-800 mb-4">School Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">School Name</label>
              <input type="text" class="w-full px-4 py-2 border rounded-lg" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" class="w-full px-4 py-2 border rounded-lg" />
            </div>
          </div>
          <button class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <Save class="w-4 h-4" />
            <span>Save Changes</span>
          </button>
        </div>
      </main>
    </div>
  </div>
</template>
