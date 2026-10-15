<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import { BookOpen, Plus } from 'lucide-vue-next'

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="Subjects"
          subtitle="Manage curriculum subjects"
          :icon="BookOpen"
          icon-color="pink"
          action-label="Add Subject"
        >
          <template #action-icon><Plus class="w-4 h-4" /></template>

          <EmptyState 
            :icon="BookOpen"
            title="No subjects yet"
            description="Start by adding subjects to your curriculum"
            action-label="Add First Subject"
            color="pink"
          />
        </PageContainer>
      </main>
    </div>
  </div>
</template>
