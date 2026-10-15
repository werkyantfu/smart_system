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
  blue: { bg: 'bg-blue-50', icon: 'text-blue-500', btn: 'from-blue-500 to-indigo-600' },
  green: { bg: 'bg-green-50', icon: 'text-green-500', btn: 'from-green-500 to-emerald-600' },
  purple: { bg: 'bg-purple-50', icon: 'text-purple-500', btn: 'from-purple-500 to-pink-600' },
  pink: { bg: 'bg-pink-50', icon: 'text-pink-500', btn: 'from-pink-500 to-rose-600' },
  red: { bg: 'bg-red-50', icon: 'text-red-500', btn: 'from-red-500 to-pink-600' },
  orange: { bg: 'bg-orange-50', icon: 'text-orange-500', btn: 'from-orange-500 to-red-600' },
  yellow: { bg: 'bg-yellow-50', icon: 'text-yellow-500', btn: 'from-yellow-500 to-orange-600' },
  teal: { bg: 'bg-teal-50', icon: 'text-teal-500', btn: 'from-teal-500 to-cyan-600' },
}
</script>

<template>
  <div class="bg-white rounded-xl shadow-sm border border-gray-100 py-16 text-center">
    <div :class="['w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center', colors[color]?.bg || colors.blue.bg]">
      <component :is="icon" v-if="icon" :class="['w-8 h-8', colors[color]?.icon || colors.blue.icon]" />
    </div>
    
    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ title }}</h3>
    <p v-if="description" class="text-sm text-gray-500 mb-5 max-w-md mx-auto">{{ description }}</p>
    
    <button 
      v-if="actionLabel"
      @click="$emit('action')"
      :class="['inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-white text-sm font-semibold shadow-md hover:shadow-lg active:scale-95 transition-all bg-gradient-to-br', colors[color]?.btn || colors.blue.btn]"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      <span>{{ actionLabel }}</span>
    </button>
  </div>
</template>
