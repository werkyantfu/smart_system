<script setup>
import { Heart } from 'lucide-vue-next'
</script>

<template>
  <footer class="bg-white border-t border-gray-200 px-6 py-3 flex-shrink-0">
    <div class="flex items-center justify-between">
      
      <div class="flex items-center gap-2 text-xs text-gray-500">
        <span>© 2026 <span class="font-semibold text-gray-700">Smart School</span></span>
        <span class="text-gray-300">·</span>
        <span class="hidden sm:inline">All rights reserved</span>
      </div>

      <div class="flex items-center gap-3 text-xs text-gray-500">
        <span class="hidden md:flex items-center gap-1">
          Made with <Heart class="w-3 h-3 text-red-500 fill-red-500" /> in Ethiopia 🇪🇹
        </span>
        <span class="px-2 py-0.5 bg-gray-100 rounded-full font-medium">v1.0.0</span>
      </div>
    </div>
  </footer>
</template>
