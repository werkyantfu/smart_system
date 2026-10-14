<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import { BarChart3, Download } from 'lucide-vue-next'

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />
    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Reports" @toggle-sidebar="isSidebarOpen = true" />
      <main class="flex-1 overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">Reports</h2>
            <p class="text-gray-500 text-sm">Generate reports</p>
          </div>
          <button class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <Download class="w-4 h-4" />
            <span>Export</span>
          </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow cursor-pointer">
            <BarChart3 class="w-12 h-12 text-blue-600 mb-4" />
            <h3 class="font-bold text-gray-800 mb-2">Student Report</h3>
            <p class="text-sm text-gray-500">Enrollment statistics</p>
          </div>
          <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow cursor-pointer">
            <BarChart3 class="w-12 h-12 text-green-600 mb-4" />
            <h3 class="font-bold text-gray-800 mb-2">Financial Report</h3>
            <p class="text-sm text-gray-500">Fees and payments</p>
          </div>
          <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow cursor-pointer">
            <BarChart3 class="w-12 h-12 text-purple-600 mb-4" />
            <h3 class="font-bold text-gray-800 mb-2">Academic Report</h3>
            <p class="text-sm text-gray-500">Marks and grades</p>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
