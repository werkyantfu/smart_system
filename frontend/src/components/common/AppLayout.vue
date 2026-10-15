<script setup>
import { ref } from 'vue'
import AppSidebar from './AppSidebar.vue'
import AppHeader from './AppHeader.vue'
import AppFooter from './AppFooter.vue'

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-50 overflow-hidden">
    
    <!-- Sidebar -->
    <AppSidebar 
      :is-open="isSidebarOpen" 
      @close="isSidebarOpen = false" 
    />

    <!-- Main Area -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
      
      <!-- Header (Sticky) -->
      <AppHeader @toggle-sidebar="isSidebarOpen = true" />
      
      <!-- Content -->
      <main class="flex-1 overflow-y-auto">
        <slot />
      </main>
      
      <!-- Footer -->
      <AppFooter />
    </div>
  </div>
</template>
