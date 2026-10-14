<script setup>
defineProps({
  columns: { type: Array, default: () => [] },
  data: { type: Array, default: () => [] },
  loading: { type: Boolean, default: false },
  emptyTitle: { type: String, default: 'No data found' },
  emptyDescription: { type: String, default: '' },
})

defineEmits(['row-click'])
</script>

<template>
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    
    <!-- Loading Skeleton -->
    <div v-if="loading" class="p-6 space-y-3">
      <div v-for="i in 5" :key="i" class="flex gap-4 animate-pulse">
        <div class="w-12 h-12 bg-gray-100 rounded-xl"></div>
        <div class="flex-1 space-y-2">
          <div class="h-4 bg-gray-100 rounded w-1/3"></div>
          <div class="h-3 bg-gray-100 rounded w-1/2"></div>
        </div>
        <div class="w-20 h-8 bg-gray-100 rounded-lg"></div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else-if="data.length === 0" class="py-16 text-center">
      <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
      </div>
      <h3 class="text-lg font-semibold text-gray-700 mb-1">{{ emptyTitle }}</h3>
      <p v-if="emptyDescription" class="text-sm text-gray-500">{{ emptyDescription }}</p>
    </div>

    <!-- Table -->
    <div v-else class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-100">
          <tr>
            <th 
              v-for="col in columns" 
              :key="col.key"
              class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider"
            >
              {{ col.label }}
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr 
            v-for="(row, idx) in data" 
            :key="row.id || idx"
            @click="$emit('row-click', row)"
            class="hover:bg-blue-50/50 transition-colors cursor-pointer group"
          >
            <td 
              v-for="col in columns" 
              :key="col.key"
              class="px-6 py-4 text-sm text-gray-700"
            >
              <slot :name="col.key" :row="row" :value="row[col.key]">
                {{ row[col.key] }}
              </slot>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
