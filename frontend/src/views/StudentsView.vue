<script setup>
import { ref, onMounted } from 'vue'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import StudentList from '@/components/students/StudentList.vue'
import { useStudentStore } from '@/stores/student'
import { Plus } from 'lucide-vue-next'

const studentStore = useStudentStore()
const isSidebarOpen = ref(false)

onMounted(() => {
  studentStore.fetchAll?.() || studentStore.fetchStudents?.()
})

function handleDelete(id) {
  if (confirm('Delete this student?')) {
    studentStore.remove?.(id) || studentStore.deleteStudent?.(id)
  }
}
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />
    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Students" @toggle-sidebar="isSidebarOpen = true" />
      <main class="flex-1 overflow-y-auto p-6">
        <div class="flex justify-between items-center mb-6">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">All Students</h2>
            <p class="text-gray-500 text-sm">Manage student records</p>
          </div>
          <button class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <Plus class="w-4 h-4" />
            Add Student
          </button>
        </div>
        <StudentList 
          :students="studentStore.students || studentStore.items || []" 
          :loading="studentStore.loading"
          @delete="handleDelete"
        />
      </main>
    </div>
  </div>
</template>
