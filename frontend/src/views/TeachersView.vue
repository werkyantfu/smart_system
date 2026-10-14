<script setup>
import { ref, onMounted } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import { useTeacherStore } from '@/stores/teacher'
import { GraduationCap, UserPlus } from 'lucide-vue-next'

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
      <AppHeader title="Teachers" @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="All Teachers"
          subtitle="Manage teaching staff"
          :icon="GraduationCap"
          icon-color="green"
          action-label="Add Teacher"
          show-search
          search-placeholder="Search teachers..."
        >
          <template #action-icon>
            <UserPlus class="w-4 h-4" />
          </template>

          <!-- Teachers Grid -->
          <div v-if="teacherStore.loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            <div v-for="i in 8" :key="i" class="bg-white rounded-2xl p-5 shadow-sm animate-pulse">
              <div class="w-16 h-16 bg-gray-100 rounded-2xl mb-4"></div>
              <div class="h-4 bg-gray-100 rounded w-3/4 mb-2"></div>
              <div class="h-3 bg-gray-100 rounded w-1/2"></div>
            </div>
          </div>

          <div v-else-if="!teacherStore.teachers?.length && !teacherStore.items?.length">
            <EmptyState 
              :icon="GraduationCap"
              title="No teachers yet"
              description="Get started by adding your first teacher"
              action-label="Add First Teacher"
              color="green"
            />
          </div>

          <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            <div 
              v-for="teacher in (teacherStore.teachers || teacherStore.items || [])" 
              :key="teacher.id"
              class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 p-5 relative overflow-hidden"
            >
              <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 opacity-5 group-hover:opacity-10 transition-opacity"></div>
              
              <div class="relative">
                <div class="flex items-center gap-3 mb-4">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-green-500/20">
                    {{ teacher.first_name?.charAt(0) }}{{ teacher.last_name?.charAt(0) }}
                  </div>
                  <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-800 truncate">{{ teacher.first_name }} {{ teacher.last_name }}</h3>
                    <p class="text-sm text-gray-500 truncate">{{ teacher.qualification || 'Teacher' }}</p>
                  </div>
                </div>
                
                <div class="space-y-2 text-sm">
                  <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="truncate">{{ teacher.email }}</span>
                  </div>
                  <div class="flex items-center gap-2 text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>{{ teacher.phone || 'N/A' }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </PageContainer>
      </main>
    </div>
  </div>
</template>
