<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import { FileText, Plus } from 'lucide-vue-next'

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Marks" @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="Marks & Grades"
          subtitle="Manage student marks and grades"
          :icon="FileText"
          icon-color="red"
          action-label="Enter Marks"
        >
          <template #action-icon>
            <Plus class="w-4 h-4" />
          </template>

          <EmptyState 
            :icon="FileText"
            title="No marks records"
            description="Start entering marks for your students"
            action-label="Enter First Marks"
            color="red"
          />
        </PageContainer>
      </main>
    </div>
  </div>
</template>
