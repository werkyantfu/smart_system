<script setup>
import { useRouter } from 'vue-router'
import { GraduationCap, ArrowRight } from 'lucide-vue-next'

const router = useRouter()
</script>

<template>
  <div class="min-h-screen flex items-center justify-center p-6"
       style="background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 100%);">
    <div class="max-w-2xl w-full text-center">
      
      <div class="flex justify-center mb-6">
        <div style="width: 80px; height: 80px; background-color: #2563eb; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 15px rgba(0,0,0,0.1);">
          <GraduationCap class="w-12 h-12 text-white" />
        </div>
      </div>
      
      <h1 class="text-4xl font-bold text-gray-800 mb-4">
        Smart School Management System
      </h1>
      
      <p class="text-xl text-gray-600 mb-8">
        Complete solution for managing students, teachers, classes, and more.
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <button 
          @click="router.push('/login')"
          style="background-color: #2563eb; color: white; padding: 16px 32px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-size: 16px;"
        >
          <span>Get Started</span>
          <ArrowRight class="w-5 h-5" />
        </button>
        
        <button 
          @click="router.push('/dashboard')"
          style="background-color: white; color: #2563eb; padding: 16px 32px; border-radius: 8px; font-weight: 600; border: 2px solid #bfdbfe; cursor: pointer; font-size: 16px;"
        >
          View Dashboard
        </button>
      </div>

      <p style="font-size: 14px; color: #94a3b8; margin-top: 48px;">
        © 2026 Smart School Management System
      </p>
    </div>
  </div>
</template>
