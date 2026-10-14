<script setup>
defineProps({
  icon: { type: Object, default: null },
  title: { type: String, default: 'No data found' },
  description: { type: String, default: '' },
  actionLabel: { type: String, default: '' },
  color: { type: String, default: 'blue' },
})

defineEmits(['action'])

const colors = {
  blue: { bg: 'bg-blue-100', icon: 'text-blue-500', btn: 'from-blue-500 to-indigo-600' },
  green: { bg: 'bg-green-100', icon: 'text-green-500', btn: 'from-green-500 to-emerald-600' },
  purple: { bg: 'bg-purple-100', icon: 'text-purple-500', btn: 'from-purple-500 to-pink-600' },
  yellow: { bg: 'bg-yellow-100', icon: 'text-yellow-500', btn: 'from-yellow-500 to-orange-600' },
  red: { bg: 'bg-red-100', icon: 'text-red-500', btn: 'from-red-500 to-pink-600' },
  teal: { bg: 'bg-teal-100', icon: 'text-teal-500', btn: 'from-teal-500 to-cyan-600' },
  indigo: { bg: 'bg-indigo-100', icon: 'text-indigo-500', btn: 'from-indigo-500 to-purple-600' },
  orange: { bg: 'bg-orange-100', icon: 'text-orange-500', btn: 'from-orange-500 to-red-600' },
}
</script>

<template>
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
    <div :class="['w-20 h-20 mx-auto mb-6 rounded-3xl flex items-center justify-center shadow-lg', colors[color]?.bg || colors.blue.bg]">
      <component :is="icon" v-if="icon" :class="['w-10 h-10', colors[color]?.icon || colors.blue.icon]" />
      <svg v-else :class="['w-10 h-10', colors[color]?.icon || colors.blue.icon]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
      </svg>
    </div>
    
    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ title }}</h3>
    <p v-if="description" class="text-gray-500 mb-6 max-w-md mx-auto">{{ description }}</p>
    
    <button 
      v-if="actionLabel"
      @click="$emit('action')"
      :class="['inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl active:scale-95 transition-all bg-gradient-to-br', colors[color]?.btn || colors.blue.btn]"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      <span>{{ actionLabel }}</span>
    </button>
  </div>
</template>
