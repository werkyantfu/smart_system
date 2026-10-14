<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import { DollarSign, Plus } from 'lucide-vue-next'

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Fees" @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="Fees & Payments"
          subtitle="Manage school fees and payments"
          :icon="DollarSign"
          icon-color="yellow"
          action-label="Record Payment"
        >
          <template #action-icon>
            <Plus class="w-4 h-4" />
          </template>

          <EmptyState 
            :icon="DollarSign"
            title="No fee records"
            description="Start recording student fee payments"
            action-label="Record First Payment"
            color="yellow"
          />
        </PageContainer>
      </main>
    </div>
  </div>
</template>
