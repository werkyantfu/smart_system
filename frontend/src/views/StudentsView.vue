<script setup>
import { ref, onMounted } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import { useStudentStore } from '@/stores/student'
import { Users, Plus } from 'lucide-vue-next'

const studentStore = useStudentStore()
const isSidebarOpen = ref(false)

onMounted(() => {
  if (studentStore.fetchAll) studentStore.fetchAll()
  else if (studentStore.fetchStudents) studentStore.fetchStudents()
})
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="Students"
          subtitle="Manage student records"
          :icon="Users"
          icon-color="green"
          action-label="Add Student"
          show-search
          search-placeholder="Search students..."
        >
          <template #action-icon><Plus class="w-4 h-4" /></template>

          <EmptyState 
            :icon="Users"
            title="No students found"
            description="Start by adding your first student record to get started"
            action-label="Add First Student"
            color="green"
          />
        </PageContainer>
      </main>
    </div>
  </div>
</template>
