<script setup>
import { GraduationCap, Mail, Phone } from 'lucide-vue-next'

defineProps({
  teachers: {
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

    <div v-else-if="teachers.length === 0" class="text-center py-12">
      <GraduationCap class="w-16 h-16 text-gray-300 mx-auto mb-4" />
      <p class="text-gray-500">No teachers found</p>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
      <div v-for="teacher in teachers" :key="teacher.id" class="border rounded-xl p-4 hover:shadow-md transition-shadow">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
            {{ teacher.first_name?.charAt(0) }}{{ teacher.last_name?.charAt(0) }}
          </div>
          <div>
            <h3 class="font-bold">{{ teacher.first_name }} {{ teacher.last_name }}</h3>
            <p class="text-sm text-gray-500">{{ teacher.qualification || 'Teacher' }}</p>
          </div>
        </div>
        <div class="space-y-1 text-sm">
          <div class="flex items-center gap-2 text-gray-600">
            <Mail class="w-4 h-4" />
            <span>{{ teacher.email }}</span>
          </div>
          <div class="flex items-center gap-2 text-gray-600">
            <Phone class="w-4 h-4" />
            <span>{{ teacher.phone }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
