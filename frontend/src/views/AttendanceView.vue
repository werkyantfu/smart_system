<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import { Calendar, Plus } from 'lucide-vue-next'

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="Attendance"
          subtitle="Track and manage student attendance"
          :icon="Calendar"
          icon-color="orange"
          action-label="Mark Attendance"
        >
          <template #action-icon><Plus class="w-4 h-4" /></template>

          <EmptyState 
            :icon="Calendar"
            title="No attendance records yet"
            description="Start by marking attendance for your students"
            action-label="Mark First Attendance"
            color="orange"
          />
        </PageContainer>
      </main>
    </div>
  </div>
</template>
