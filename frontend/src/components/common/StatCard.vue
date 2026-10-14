<script setup>
import { TrendingUp, TrendingDown } from 'lucide-vue-next'

defineProps({
  label: { type: String, required: true },
  value: { type: [String, Number], default: '0' },
  icon: { type: Object, default: null },
  color: { type: String, default: 'blue' },
  change: { type: String, default: '' },
  trend: { type: String, default: 'up' },
})

const colors = {
  blue: { gradient: 'from-blue-500 to-indigo-600', shadow: 'shadow-blue-500/20' },
  green: { gradient: 'from-green-500 to-emerald-600', shadow: 'shadow-green-500/20' },
  purple: { gradient: 'from-purple-500 to-pink-600', shadow: 'shadow-purple-500/20' },
  yellow: { gradient: 'from-yellow-500 to-orange-600', shadow: 'shadow-yellow-500/20' },
  red: { gradient: 'from-red-500 to-pink-600', shadow: 'shadow-red-500/20' },
  teal: { gradient: 'from-teal-500 to-cyan-600', shadow: 'shadow-teal-500/20' },
}
</script>

<template>
  <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 p-5 relative overflow-hidden">
    <div :class="['absolute -top-8 -right-8 w-24 h-24 rounded-full bg-gradient-to-br opacity-5 group-hover:opacity-10 transition-opacity', colors[color]?.gradient]"></div>
    
    <div class="relative">
      <div class="flex items-center justify-between mb-4">
        <div :class="['w-12 h-12 rounded-xl bg-gradient-to-br flex items-center justify-center shadow-lg', colors[color]?.gradient, colors[color]?.shadow]">
          <component :is="icon" v-if="icon" class="w-6 h-6 text-white" />
        </div>
        
        <div v-if="change" :class="[
          'flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-lg',
          trend === 'up' ? 'text-green-700 bg-green-50' : 'text-red-700 bg-red-50'
        ]">
          <TrendingUp v-if="trend === 'up'" class="w-3.5 h-3.5" />
          <TrendingDown v-else class="w-3.5 h-3.5" />
          {{ change }}
        </div>
      </div>

      <div class="text-3xl font-bold text-gray-800 mb-1">{{ value }}</div>
      <div class="text-sm font-medium text-gray-500">{{ label }}</div>
    </div>
  </div>
</template>
