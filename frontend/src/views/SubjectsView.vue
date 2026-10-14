<script setup>
import { ref, onMounted } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import PageContainer from '@/components/common/PageContainer.vue'
import EmptyState from '@/components/common/EmptyState.vue'
import { useSubjectStore } from '@/stores/subject'
import { BookOpen, Plus } from 'lucide-vue-next'

const subjectStore = useSubjectStore()
const isSidebarOpen = ref(false)

onMounted(() => {
  if (subjectStore.fetchAll) subjectStore.fetchAll()
  else if (subjectStore.fetchSubjects) subjectStore.fetchSubjects()
})
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Subjects" @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto">
        <PageContainer 
          title="All Subjects"
          subtitle="Manage curriculum subjects"
          :icon="BookOpen"
          icon-color="purple"
          action-label="Add Subject"
          show-search
          search-placeholder="Search subjects..."
        >
          <template #action-icon>
            <Plus class="w-4 h-4" />
          </template>

          <div v-if="!subjectStore.subjects?.length && !subjectStore.items?.length">
            <EmptyState 
              :icon="BookOpen"
              title="No subjects yet"
              description="Start by adding subjects to your curriculum"
              action-label="Add First Subject"
              color="purple"
            />
          </div>

          <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            <div 
              v-for="subject in (subjectStore.subjects || subjectStore.items || [])" 
              :key="subject.id"
              class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 p-5 relative overflow-hidden"
            >
              <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 opacity-5 group-hover:opacity-10 transition-opacity"></div>
              
              <div class="relative">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center mb-4 shadow-lg shadow-purple-500/20">
                  <BookOpen class="w-6 h-6 text-white" />
                </div>
                
                <div class="text-xs font-mono text-purple-600 bg-purple-50 px-2 py-1 rounded inline-block mb-2">
                  {{ subject.code }}
                </div>
                
                <h3 class="font-bold text-gray-800 mb-2 text-lg">{{ subject.name }}</h3>
                
                <div class="flex items-center gap-4 text-sm text-gray-500">
                  <span>Grade {{ subject.grade_level }}</span>
                  <span>•</span>
                  <span>{{ subject.credits || 0 }} credits</span>
                </div>
              </div>
            </div>
          </div>
        </PageContainer>
      </main>
    </div>
  </div>
</template>
