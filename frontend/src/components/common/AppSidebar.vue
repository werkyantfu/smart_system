<script setup>
import { computed } from 'vue'
import { RouterLink, useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { 
  LayoutDashboard, Users, GraduationCap, BookOpen, 
  Calendar, FileText, DollarSign, Library, 
  Megaphone, BarChart3, Settings, LogOut, X, Sparkles
} from 'lucide-vue-next'

defineProps({ isOpen: { type: Boolean, default: false } })
const emit = defineEmits(['close'])

const route = useRoute()
const router = useRouter()
const auth = useAuthStore()

const allMenuItems = [
  { name: 'Dashboard', path: '/dashboard', icon: LayoutDashboard, roles: ['super_admin', 'admin', 'director', 'teacher', 'accountant', 'librarian', 'student', 'parent'], color: 'from-blue-500 to-indigo-600' },
  { name: 'Students', path: '/students', icon: Users, roles: ['super_admin', 'admin', 'director', 'teacher', 'accountant', 'librarian'], color: 'from-green-500 to-emerald-600' },
  { name: 'Teachers', path: '/teachers', icon: GraduationCap, roles: ['super_admin', 'admin', 'director'], color: 'from-purple-500 to-pink-600' },
  { name: 'Classes', path: '/classes', icon: BookOpen, roles: ['super_admin', 'admin', 'director', 'teacher'], color: 'from-indigo-500 to-purple-600' },
  { name: 'Subjects', path: '/subjects', icon: BookOpen, roles: ['super_admin', 'admin', 'director', 'teacher'], color: 'from-pink-500 to-rose-600' },
  { name: 'Attendance', path: '/attendance', icon: Calendar, roles: ['super_admin', 'admin', 'director', 'teacher', 'student', 'parent'], color: 'from-orange-500 to-red-600' },
  { name: 'Marks', path: '/marks', icon: FileText, roles: ['super_admin', 'admin', 'director', 'teacher', 'student', 'parent'], color: 'from-red-500 to-pink-600' },
  { name: 'Fees', path: '/fees', icon: DollarSign, roles: ['super_admin', 'admin', 'director', 'accountant', 'parent'], color: 'from-yellow-500 to-orange-600' },
  { name: 'Library', path: '/library', icon: Library, roles: ['super_admin', 'admin', 'director', 'librarian', 'student'], color: 'from-teal-500 to-cyan-600' },
  { name: 'Announcements', path: '/announcements', icon: Megaphone, roles: ['super_admin', 'admin', 'director', 'teacher', 'accountant', 'librarian', 'student', 'parent'], color: 'from-cyan-500 to-blue-600' },
  { name: 'Reports', path: '/reports', icon: BarChart3, roles: ['super_admin', 'admin', 'director', 'accountant'], color: 'from-violet-500 to-purple-600' },
  { name: 'Settings', path: '/settings', icon: Settings, roles: ['super_admin', 'admin'], color: 'from-gray-500 to-slate-600' },
]

const menuItems = computed(() => {
  const role = auth.userRole
  if (!role) return allMenuItems
  return allMenuItems.filter(item => item.roles.includes(role))
})

function isActive(path) { return route.path === path }

async function handleLogout() {
  await auth.logout()
  router.push('/login')
}

const roleGradients = {
  super_admin: 'from-red-500 to-pink-500',
  admin: 'from-blue-500 to-indigo-500',
  director: 'from-purple-500 to-pink-500',
  teacher: 'from-green-500 to-emerald-500',
  accountant: 'from-yellow-500 to-orange-500',
  librarian: 'from-teal-500 to-cyan-500',
  student: 'from-cyan-500 to-blue-500',
  parent: 'from-indigo-500 to-purple-500',
}
</script>

<template>
  <div v-if="isOpen" @click="emit('close')" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"></div>
  
  <aside :class="[
    'fixed lg:static inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white shadow-2xl transform transition-transform duration-300',
    isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
  ]">
    
    <!-- Logo Header -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-white/10">
      <div class="flex items-center gap-3">
        <div class="w-11 h-11 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg relative">
          <span class="text-white font-bold text-xl">S</span>
          <Sparkles class="w-3 h-3 text-yellow-300 absolute -top-1 -right-1" />
        </div>
        <div>
          <h1 class="font-bold text-lg leading-tight">Smart School</h1>
          <p class="text-xs text-slate-400">Management System</p>
        </div>
      </div>
      <button @click="emit('close')" class="lg:hidden p-1.5 rounded-lg hover:bg-white/10 transition-colors">
        <X class="w-5 h-5" />
      </button>
    </div>

    <!-- User Info -->
    <div v-if="auth.userRole" class="p-4 border-b border-white/10">
      <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 backdrop-blur">
        <div :class="['w-10 h-10 rounded-lg bg-gradient-to-br flex items-center justify-center text-white font-bold shadow-lg', roleGradients[auth.userRole] || 'from-blue-500 to-indigo-500']">
          {{ auth.userName?.charAt(0)?.toUpperCase() || 'U' }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-semibold truncate">{{ auth.userName }}</p>
          <p class="text-xs text-slate-400 capitalize truncate">{{ auth.userRole.replace('_', ' ') }}</p>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <nav class="p-4 space-y-1.5 overflow-y-auto h-[calc(100vh-16rem)] sidebar-scroll">
      <div class="px-3 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Menu</div>
      
      <RouterLink
        v-for="item in menuItems"
        :key="item.path"
        :to="item.path"
        @click="emit('close')"
        :class="[
          'group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 relative overflow-hidden',
          isActive(item.path) 
            ? 'bg-white/10 text-white shadow-lg border border-white/10' 
            : 'text-slate-300 hover:bg-white/5 hover:text-white'
        ]"
      >
        <div v-if="isActive(item.path)" :class="['absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-gradient-to-b rounded-r-full', item.color]"></div>
        
        <div :class="[
          'w-9 h-9 rounded-lg flex items-center justify-center transition-all',
          isActive(item.path)
            ? ['bg-gradient-to-br shadow-lg', item.color]
            : 'bg-white/5 group-hover:bg-white/10'
        ]">
          <component :is="item.icon" style="width: 18px; height: 18px;" />
        </div>
        
        <span class="font-medium text-sm flex-1">{{ item.name }}</span>

        <div v-if="isActive(item.path)" class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
      </RouterLink>

      <div class="my-4 border-t border-white/10"></div>
      
      <button 
        @click="handleLogout" 
        class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-red-500/10 hover:text-red-200 transition-all"
      >
        <div class="w-9 h-9 rounded-lg bg-red-500/10 group-hover:bg-red-500/20 flex items-center justify-center transition-all">
          <LogOut style="width: 18px; height: 18px;" />
        </div>
        <span class="font-medium text-sm">Logout</span>
      </button>
    </nav>

    <!-- Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10 bg-slate-900/50 backdrop-blur">
      <p class="text-xs text-slate-500 text-center">v1.0.0 · © 2026</p>
    </div>
  </aside>
</template>

<style scoped>
.sidebar-scroll::-webkit-scrollbar { width: 4px; }
.sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
.sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 2px; }
.sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
</style>
