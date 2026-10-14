<script setup>
import { BookOpen, Users, Edit, Trash2 } from 'lucide-vue-next'

defineProps({
  classes: { type: Array, default: () => [] },
  loading: { type: Boolean, default: false }
})

const emit = defineEmits(['edit', 'delete'])
</script>

<template>
  <div>
    <!-- Loading -->
    <div v-if="loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>

    <!-- Empty -->
    <div v-else-if="classes.length === 0" class="bg-white rounded-xl shadow-sm p-12 text-center">
      <BookOpen class="w-16 h-16 text-gray-300 mx-auto mb-4" />
      <p class="text-gray-500 mb-4">No classes found</p>
    </div>

    <!-- Grid -->
    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
      <div 
        v-for="cls in classes" 
        :key="cls.id" 
        class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition-shadow border border-gray-100"
      >
        <!-- Header -->
        <div class="flex items-start justify-between mb-3">
          <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
              <BookOpen class="w-5 h-5 text-blue-600" />
            </div>
            <div>
              <h3 class="font-bold text-gray-800 text-lg leading-tight">
                {{ cls.name || `Grade ${cls.grade_level}${cls.section}` }}
              </h3>
              <p class="text-xs text-gray-500">
                {{ cls.grade_level ? `Grade ${cls.grade_level}` : '' }}
                {{ cls.section ? `· Section ${cls.section}` : '' }}
              </p>
            </div>
          </div>
        </div>

        <!-- Info -->
        <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
          <div class="flex items-center gap-1">
            <Users class="w-4 h-4" />
            <span>{{ cls.capacity || 0 }} students</span>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
          <button 
            @click="emit('edit', cls)"
            class="flex-1 flex items-center justify-center gap-1 px-3 py-1.5 text-sm text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
          >
            <Edit class="w-4 h-4" />
            Edit
          </button>
          <button 
            @click="emit('delete', cls)"
            class="flex-1 flex items-center justify-center gap-1 px-3 py-1.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors"
          >
            <Trash2 class="w-4 h-4" />
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
