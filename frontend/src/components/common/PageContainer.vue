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

const gradients = {
  blue: 'from-blue-500 to-indigo-600',
  green: 'from-green-500 to-emerald-600',
  purple: 'from-purple-500 to-pink-600',
  pink: 'from-pink-500 to-rose-600',
  red: 'from-red-500 to-pink-600',
  orange: 'from-orange-500 to-red-600',
  yellow: 'from-yellow-500 to-orange-600',
  teal: 'from-teal-500 to-cyan-600',
  gray: 'from-gray-500 to-slate-600',
}
</script>

<template>
  <div class="min-h-full bg-gray-50">
    <div class="p-6 max-w-7xl mx-auto">
      
      <!-- Page Header -->
      <div v-if="title" class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
          <div v-if="icon" :class="['w-12 h-12 rounded-xl bg-gradient-to-br flex items-center justify-center shadow-md flex-shrink-0', gradients[iconColor]]">
            <component :is="icon" class="w-6 h-6 text-white" />
          </div>
          
          <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ title }}</h1>
            <p v-if="subtitle" class="text-sm text-gray-500 mt-0.5">{{ subtitle }}</p>
          </div>
        </div>

        <button 
          v-if="actionLabel"
          @click="$emit('action')"
          :class="['inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-semibold shadow-md hover:shadow-lg active:scale-95 transition-all bg-gradient-to-br whitespace-nowrap', gradients[iconColor]]"
        >
          <slot name="action-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
          </slot>
          <span>{{ actionLabel }}</span>
        </button>
      </div>

      <!-- Search -->
      <div v-if="showSearch" class="mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
          <input 
            type="text"
            :placeholder="searchPlaceholder"
            @input="$emit('search', $event.target.value)"
            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
          />
        </div>
      </div>

      <!-- Content -->
      <slot />
    </div>
  </div>
</template>
