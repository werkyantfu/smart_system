<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import { Library, Plus } from 'lucide-vue-next'

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Library" @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="Library"
          subtitle="Manage books and loans"
          :icon="Library"
          icon-color="teal"
          action-label="Add Book"
        >
          <template #action-icon>
            <Plus class="w-4 h-4" />
          </template>

          <EmptyState 
            :icon="Library"
            title="No books in library"
            description="Start adding books to your library"
            action-label="Add First Book"
            color="teal"
          />
        </PageContainer>
      </main>
    </div>
  </div>
</template>
