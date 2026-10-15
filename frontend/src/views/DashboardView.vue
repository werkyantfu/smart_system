<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Sidebar from '@/components/common/AppSidebar.vue'
import AppHeader from '@/components/common/AppHeader.vue'
import {
  Users, GraduationCap, BookOpen, DollarSign,
  Calendar, TrendingUp, UserCheck, FileText,
  Megaphone, Library, BarChart3, Clock, ArrowUpRight,
  Sparkles, Target, Award
} from 'lucide-vue-next'

const router = useRouter()
const authStore = useAuthStore()
const isSidebarOpen = ref(false)

const stats = ref([
  { label: 'Total Students', value: '1,234', icon: Users, color: 'blue', change: '+12%' },
  { label: 'Total Teachers', value: '56', icon: GraduationCap, color: 'green', change: '+3%' },
  { label: 'Total Classes', value: '42', icon: BookOpen, color: 'purple', change: '+5%' },
  { label: 'Revenue', value: 'ETB 458K', icon: DollarSign, color: 'yellow', change: '+18%' },
])

const recentActivities = ref([
  { id: 1, action: 'New student registered', user: 'Admin', time: '5 min ago', icon: Users, color: 'blue' },
  { id: 2, action: 'Payment received', user: 'System', time: '1 hour ago', icon: DollarSign, color: 'green' },
  { id: 3, action: 'New teacher added', user: 'Admin', time: '2 hours ago', icon: GraduationCap, color: 'purple' },
  { id: 4, action: 'Marks published', user: 'Teacher', time: '3 hours ago', icon: FileText, color: 'orange' },
])

const quickActions = computed(() => {
  const role = authStore.userRole
  const allActions = {
    super_admin: [
      { label: 'Add Student', icon: Users, color: 'blue', path: '/students' },
      { label: 'Add Teacher', icon: GraduationCap, color: 'green', path: '/teachers' },
      { label: 'Add Class', icon: BookOpen, color: 'purple', path: '/classes' },
      { label: 'Record Payment', icon: DollarSign, color: 'yellow', path: '/fees' },
    ],
    admin: [
      { label: 'Add Student', icon: Users, color: 'blue', path: '/students' },
      { label: 'Add Teacher', icon: GraduationCap, color: 'green', path: '/teachers' },
      { label: 'Add Class', icon: BookOpen, color: 'purple', path: '/classes' },
      { label: 'Record Payment', icon: DollarSign, color: 'yellow', path: '/fees' },
    ],
    director: [
      { label: 'View Reports', icon: BarChart3, color: 'blue', path: '/reports' },
      { label: 'View Students', icon: Users, color: 'green', path: '/students' },
      { label: 'View Teachers', icon: GraduationCap, color: 'purple', path: '/teachers' },
      { label: 'View Fees', icon: DollarSign, color: 'yellow', path: '/fees' },
    ],
    teacher: [
      { label: 'Mark Attendance', icon: Calendar, color: 'blue', path: '/attendance' },
      { label: 'Enter Marks', icon: FileText, color: 'green', path: '/marks' },
      { label: 'View Students', icon: Users, color: 'purple', path: '/students' },
      { label: 'Announcements', icon: Megaphone, color: 'yellow', path: '/announcements' },
    ],
    accountant: [
      { label: 'Record Payment', icon: DollarSign, color: 'blue', path: '/fees' },
      { label: 'View Reports', icon: BarChart3, color: 'green', path: '/reports' },
      { label: 'View Students', icon: Users, color: 'purple', path: '/students' },
      { label: 'Announcements', icon: Megaphone, color: 'yellow', path: '/announcements' },
    ],
    librarian: [
      { label: 'Add Book', icon: Library, color: 'blue', path: '/library' },
      { label: 'View Students', icon: Users, color: 'green', path: '/students' },
      { label: 'Announcements', icon: Megaphone, color: 'purple', path: '/announcements' },
    ],
    student: [
      { label: 'View Marks', icon: FileText, color: 'blue', path: '/marks' },
      { label: 'View Attendance', icon: Calendar, color: 'green', path: '/attendance' },
      { label: 'Library', icon: Library, color: 'purple', path: '/library' },
      { label: 'Announcements', icon: Megaphone, color: 'yellow', path: '/announcements' },
    ],
    parent: [
      { label: 'View Marks', icon: FileText, color: 'blue', path: '/marks' },
      { label: 'View Attendance', icon: Calendar, color: 'green', path: '/attendance' },
      { label: 'Pay Fees', icon: DollarSign, color: 'purple', path: '/fees' },
      { label: 'Announcements', icon: Megaphone, color: 'yellow', path: '/announcements' },
    ],
  }
  return allActions[role] || allActions.admin
})

const getColorClasses = (color) => {
  const colors = {
    blue: { text: 'text-blue-600', light: 'bg-blue-50', gradient: 'from-blue-500 to-indigo-600', border: 'border-blue-200' },
    green: { text: 'text-green-600', light: 'bg-green-50', gradient: 'from-green-500 to-emerald-600', border: 'border-green-200' },
    purple: { text: 'text-purple-600', light: 'bg-purple-50', gradient: 'from-purple-500 to-pink-600', border: 'border-purple-200' },
    yellow: { text: 'text-yellow-600', light: 'bg-yellow-50', gradient: 'from-yellow-500 to-orange-600', border: 'border-yellow-200' },
    orange: { text: 'text-orange-600', light: 'bg-orange-50', gradient: 'from-orange-500 to-red-600', border: 'border-orange-200' },
  }
  return colors[color] || colors.blue
}

onMounted(() => {})
</script>

<template>
  <div class="flex h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <div class="flex-1 flex flex-col overflow-hidden">
      <AppHeader title="Dashboard" @toggle-sidebar="isSidebarOpen = true" />

      <main class="flex-1 overflow-y-auto p-6">
        
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-2xl p-6 mb-6 text-white shadow-xl relative overflow-hidden">
          <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
          <div class="absolute bottom-0 right-20 w-40 h-40 bg-white/5 rounded-full -mb-20"></div>
          
          <div class="relative z-10 flex items-start justify-between flex-wrap gap-4">
            <div>
              <div class="flex items-center gap-2 mb-2">
                <Sparkles class="w-5 h-5 text-yellow-300" />
                <span class="text-sm font-medium text-blue-100">Welcome back</span>
              </div>
              <h2 class="text-3xl font-bold mb-2">{{ authStore.userName }}!</h2>
              <p class="text-blue-100">Here's what's happening in your school today.</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur rounded-xl p-4 border border-white/20">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                  <Award class="w-6 h-6 text-yellow-300" />
                </div>
                <div>
                  <p class="text-xs text-blue-100">Your Role</p>
                  <p class="font-bold capitalize">{{ authStore.userRole?.replace('_', ' ') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
          <div v-for="stat in stats" :key="stat.label"
            class="group bg-white rounded-2xl shadow-sm p-5 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 relative overflow-hidden">
            <div :class="['absolute -top-8 -right-8 w-24 h-24 rounded-full bg-gradient-to-br opacity-5 group-hover:opacity-10 transition-opacity', getColorClasses(stat.color).gradient]"></div>
            
            <div class="relative">
              <div class="flex items-center justify-between mb-4">
                <div :class="['w-12 h-12 rounded-xl bg-gradient-to-br flex items-center justify-center shadow-md', getColorClasses(stat.color).gradient]">
                  <component :is="stat.icon" class="w-6 h-6 text-white" />
                </div>
                <div class="flex items-center gap-1 text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded-lg">
                  <TrendingUp class="w-3.5 h-3.5" />
                  {{ stat.change }}
                </div>
              </div>
              <div class="text-3xl font-bold text-gray-800 mb-1">{{ stat.value }}</div>
              <div class="text-sm text-gray-500 font-medium">{{ stat.label }}</div>
            </div>
          </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
          
          <!-- Recent Activity -->
          <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-5">
              <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                  <Clock class="w-4 h-4 text-blue-600" />
                </div>
                Recent Activity
              </h3>
              <button class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                View all <ArrowUpRight class="w-3.5 h-3.5" />
              </button>
            </div>
            <div class="space-y-3">
              <div v-for="activity in recentActivities" :key="activity.id"
                class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors group cursor-pointer">
                <div class="flex items-center gap-3">
                  <div :class="['w-11 h-11 rounded-xl flex items-center justify-center shadow-sm', getColorClasses(activity.color).light]">
                    <component :is="activity.icon" :class="['w-5 h-5', getColorClasses(activity.color).text]" />
                  </div>
                  <div>
                    <p class="font-medium text-gray-800 group-hover:text-blue-600 transition-colors">{{ activity.action }}</p>
                    <p class="text-xs text-gray-500">by {{ activity.user }}</p>
                  </div>
                </div>
                <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">{{ activity.time }}</span>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
              <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                <Target class="w-4 h-4 text-purple-600" />
              </div>
              Quick Actions
            </h3>
            <div class="space-y-2">
              <button 
                v-for="action in quickActions" 
                :key="action.label"
                @click="router.push(action.path)"
                :class="['w-full text-left px-4 py-3 rounded-xl transition-all duration-200 flex items-center gap-3 group hover:shadow-md hover:-translate-y-0.5', getColorClasses(action.color).light]"
              >
                <div :class="['w-9 h-9 rounded-lg flex items-center justify-center shadow-sm bg-gradient-to-br', getColorClasses(action.color).gradient]">
                  <component :is="action.icon" style="width: 18px; height: 18px;" class="text-white" />
                </div>
                <span :class="['font-medium text-sm flex-1', getColorClasses(action.color).text]">{{ action.label }}</span>
                <ArrowUpRight :class="['w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity', getColorClasses(action.color).text]" />
              </button>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>
</template>
