<script setup>
import { ref, onMounted } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import { useTeacherStore } from '@/stores/teacher'
import { GraduationCap, Plus } from 'lucide-vue-next'

const teacherStore = useTeacherStore()
const isSidebarOpen = ref(false)

onMounted(() => {
  if (teacherStore.fetchAll) teacherStore.fetchAll()
  else if (teacherStore.fetchTeachers) teacherStore.fetchTeachers()
})
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="Teachers"
          subtitle="Manage teaching staff"
          :icon="GraduationCap"
          icon-color="purple"
          action-label="Add Teacher"
          show-search
          search-placeholder="Search teachers..."
        >
          <template #action-icon><Plus class="w-4 h-4" /></template>

          <EmptyState 
            :icon="GraduationCap"
            title="No teachers found"
            description="Start by adding your first teacher record"
            action-label="Add First Teacher"
            color="purple"
          />
        </PageContainer>
      </main>
    </div>
  </div>
</template>
