<script setup>
defineProps({
  title: { type: String, default: '' },
  subtitle: { type: String, default: '' },
  icon: { type: Object, default: null },
  iconColor: { type: String, default: 'blue' },
  showSearch: { type: Boolean, default: false },
  searchPlaceholder: { type: String, default: 'Search...' },
  actionLabel: { type: String, default: '' },
})

defineEmits(['action', 'search'])

const iconColors = {
  blue: 'from-blue-500 to-indigo-600',
  green: 'from-green-500 to-emerald-600',
  purple: 'from-purple-500 to-pink-600',
  yellow: 'from-yellow-500 to-orange-600',
  red: 'from-red-500 to-pink-600',
  teal: 'from-teal-500 to-cyan-600',
  orange: 'from-orange-500 to-red-600',
  indigo: 'from-indigo-500 to-purple-600',
  gray: 'from-gray-500 to-slate-600',
}
</script>

<template>
  <div class="min-h-full bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/40">
    <div class="max-w-7xl mx-auto p-6">
      
      <div v-if="title" class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4 min-w-0">
          <div v-if="icon" :class="['w-14 h-14 rounded-2xl bg-gradient-to-br flex items-center justify-center shadow-lg flex-shrink-0', iconColors[iconColor]]">
            <component :is="icon" class="w-7 h-7 text-white" />
          </div>
          
          <div class="min-w-0">
            <h1 class="text-2xl font-bold text-gray-800 truncate">{{ title }}</h1>
            <p v-if="subtitle" class="text-sm text-gray-500 mt-0.5">{{ subtitle }}</p>
          </div>
        </div>

        <div class="flex items-center gap-3 flex-shrink-0">
          <slot name="actions">
            <button 
              v-if="actionLabel"
              @click="$emit('action')"
              :class="['inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-semibold shadow-lg hover:shadow-xl active:scale-95 transition-all bg-gradient-to-br whitespace-nowrap', iconColors[iconColor]]"
            >
              <slot name="action-icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
              </slot>
              <span>{{ actionLabel }}</span>
            </button>
          </slot>
        </div>
      </div>

      <div v-if="showSearch" class="mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
          <div class="relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input 
              type="text"
              :placeholder="searchPlaceholder"
              @input="$emit('search', $event.target.value)"
              class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white outline-none transition-all"
            />
          </div>
        </div>
      </div>

      <slot />
    </div>
  </div>
</template>
