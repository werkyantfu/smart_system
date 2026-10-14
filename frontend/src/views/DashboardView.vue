<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import {
  Users, GraduationCap, BookOpen, DollarSign,
  Calendar, TrendingUp, UserCheck, FileText
} from 'lucide-vue-next'

const authStore = useAuthStore()
const isSidebarOpen = ref(false)

const stats = ref([
  { label: 'Total Students', value: '0', icon: Users, color: '#3b82f6', bg: '#dbeafe', change: '+0%' },
  { label: 'Total Teachers', value: '0', icon: GraduationCap, color: '#10b981', bg: '#d1fae5', change: '+0%' },
  { label: 'Total Classes', value: '0', icon: BookOpen, color: '#8b5cf6', bg: '#ede9fe', change: '+0%' },
  { label: 'Revenue', value: 'ETB 0', icon: DollarSign, color: '#eab308', bg: '#fef3c7', change: '+0%' },
])

const recentActivities = ref([
  { id: 1, action: 'New student registered', user: 'Admin', time: '5 min ago' },
  { id: 2, action: 'Payment received', user: 'System', time: '1 hour ago' },
  { id: 3, action: 'New teacher added', user: 'Admin', time: '2 hours ago' },
])

onMounted(() => {
  // Load dashboard data
})
</script>

<template>
  <div class="flex h-screen bg-gray-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Dashboard" @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto p-6">
        <!-- Welcome -->
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-gray-800">
            Welcome back, {{ authStore.userName }}!
          </h2>
          <p class="text-gray-500">Here's what's happening in your school today.</p>
        </div>

        <!-- Stats Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 24px;">
          <div v-for="stat in stats" :key="stat.label"
            style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
              <div :style="`width: 48px; height: 48px; border-radius: 8px; background: ${stat.bg}; color: ${stat.color}; display: flex; align-items: center; justify-content: center;`">
                <component :is="stat.icon" style="width: 24px; height: 24px;" />
              </div>
              <span style="font-size: 14px; color: #16a34a; font-weight: 500; display: flex; align-items: center; gap: 4px;">
                <TrendingUp style="width: 16px; height: 16px;" />
                {{ stat.change }}
              </span>
            </div>
            
            <div style="font-size: 28px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
              {{ stat.value }}
            </div>
            <div style="font-size: 14px; color: #64748b;">
              {{ stat.label }}
            </div>
          </div>
        </div>

        <!-- Content Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
          
          <!-- Recent Activity -->
          <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); grid-column: span 2;">
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
              <UserCheck style="width: 20px; height: 20px; color: #2563eb;" />
              Recent Activity
            </h3>
            <div style="display: flex; flex-direction: column; gap: 12px;">
              <div v-for="activity in recentActivities" :key="activity.id"
                style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border-radius: 8px; background: #f8fafc;">
                <div style="display: flex; align-items: center; gap: 12px;">
                  <div style="width: 40px; height: 40px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <FileText style="width: 20px; height: 20px; color: #2563eb;" />
                  </div>
                  <div>
                    <p style="font-weight: 500; color: #1e293b; margin: 0;">{{ activity.action }}</p>
                    <p style="font-size: 14px; color: #64748b; margin: 0;">by {{ activity.user }}</p>
                  </div>
                </div>
                <span style="font-size: 14px; color: #94a3b8;">{{ activity.time }}</span>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
              <Calendar style="width: 20px; height: 20px; color: #8b5cf6;" />
              Quick Actions
            </h3>
            <div style="display: flex; flex-direction: column; gap: 8px;">
              <button style="width: 100%; text-align: left; padding: 12px 16px; background: #eff6ff; color: #1d4ed8; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 12px; font-size: 14px;">
                <Users style="width: 20px; height: 20px;" />
                <span>Add Student</span>
              </button>
              <button style="width: 100%; text-align: left; padding: 12px 16px; background: #f0fdf4; color: #15803d; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 12px; font-size: 14px;">
                <GraduationCap style="width: 20px; height: 20px;" />
                <span>Add Teacher</span>
              </button>
              <button style="width: 100%; text-align: left; padding: 12px 16px; background: #faf5ff; color: #7c3aed; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 12px; font-size: 14px;">
                <BookOpen style="width: 20px; height: 20px;" />
                <span>Add Class</span>
              </button>
              <button style="width: 100%; text-align: left; padding: 12px 16px; background: #fefce8; color: #a16207; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 12px; font-size: 14px;">
                <DollarSign style="width: 20px; height: 20px;" />
                <span>Record Payment</span>
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
