<script setup>
import { BookOpen } from 'lucide-vue-next'

defineProps({
  subjects: {
    type: Array,
    default: () => []
  },
  loading: {
    type: Boolean,
    default: false
  }
})
</script>

<template>
  <div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div v-if="loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>

    <div v-else-if="subjects.length === 0" class="text-center py-12">
      <BookOpen class="w-16 h-16 text-gray-300 mx-auto mb-4" />
      <p class="text-gray-500">No subjects found</p>
    </div>

    <table v-else class="w-full">
      <thead class="bg-gray-50 border-b">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Code</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Grade</th>
          <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Credits</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr v-for="subject in subjects" :key="subject.id" class="hover:bg-gray-50">
          <td class="px-6 py-4 font-mono text-sm">{{ subject.code }}</td>
          <td class="px-6 py-4 font-medium">{{ subject.name }}</td>
          <td class="px-6 py-4">Grade {{ subject.grade_level }}</td>
          <td class="px-6 py-4">{{ subject.credits || 'N/A' }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
