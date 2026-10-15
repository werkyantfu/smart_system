<script setup>
import { ref } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import { BookOpen, Plus, Edit, Trash2, Users } from 'lucide-vue-next'

const isSidebarOpen = ref(false)

const classes = ref([
  { id: 1, name: 'Grade 9A', grade_level: 9, section: 'A', students: 40 },
  { id: 2, name: 'Grade 9B', grade_level: 9, section: 'B', students: 40 },
  { id: 3, name: 'Grade 10A', grade_level: 10, section: 'A', students: 40 },
  { id: 4, name: 'Grade 10B', grade_level: 10, section: 'B', students: 40 },
])
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="Classes"
          subtitle="Manage school classes"
          :icon="BookOpen"
          icon-color="blue"
          action-label="Add Class"
          show-search
          search-placeholder="Search classes..."
        >
          <template #action-icon><Plus class="w-4 h-4" /></template>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <div v-for="cls in classes" :key="cls.id" 
              class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
              
              <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                  <BookOpen class="w-6 h-6 text-white" />
                </div>
                <div>
                  <h3 class="font-bold text-gray-800">{{ cls.name }}</h3>
                  <p class="text-xs text-gray-500">Grade {{ cls.grade_level }} · Section {{ cls.section }}</p>
                </div>
              </div>

              <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                <Users class="w-4 h-4" />
                <span>{{ cls.students }} students</span>
              </div>

              <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                <button class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors font-medium">
                  <Edit class="w-4 h-4" /> Edit
                </button>
                <button class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors font-medium">
                  <Trash2 class="w-4 h-4" /> Delete
                </button>
              </div>
            </div>
          </div>
        </PageContainer>
      </main>
    </div>
  </div>
</template>
