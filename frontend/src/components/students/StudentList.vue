<script setup>
import { RouterLink } from 'vue-router'
import { Eye, Edit, Trash2, Users } from 'lucide-vue-next'

defineProps({
  students: {
    type: Array,
    default: () => []
  },
  loading: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['delete'])
</script>

<template>
  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div v-if="loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>

    <div v-else-if="students.length === 0" class="text-center py-12">
      <Users class="w-16 h-16 text-gray-300 mx-auto mb-4" />
      <p class="text-gray-500">No students found</p>
    </div>

    <table v-else class="w-full">
      <thead class="bg-gray-50 border-b">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Grade</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Guardian</th>
          <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr v-for="student in students" :key="student.id" class="hover:bg-gray-50">
          <td class="px-6 py-4 font-mono text-sm">{{ student.student_id }}</td>
          <td class="px-6 py-4">
            <div class="font-medium">{{ student.first_name }} {{ student.last_name }}</div>
            <div class="text-sm text-gray-500">{{ student.gender }}</div>
          </td>
          <td class="px-6 py-4">
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
              Grade {{ student.grade_level }}{{ student.section }}
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="text-sm">{{ student.guardian_name }}</div>
            <div class="text-xs text-gray-500">{{ student.guardian_phone }}</div>
          </td>
          <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
              <RouterLink :to="`/students/${student.id}`" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                <Eye class="w-4 h-4" />
              </RouterLink>
              <RouterLink :to="`/students/${student.id}/edit`" class="p-2 text-green-600 hover:bg-green-50 rounded-lg">
                <Edit class="w-4 h-4" />
              </RouterLink>
              <button @click="emit('delete', student.id)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                <Trash2 class="w-4 h-4" />
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
