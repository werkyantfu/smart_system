<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { 
  Menu, Bell, ChevronDown, LogOut, User, Settings, Search, X,
  Check, Users, DollarSign, FileText, GraduationCap
} from 'lucide-vue-next'

const emit = defineEmits(['toggle-sidebar'])
const router = useRouter()
const auth = useAuthStore()

// State
const showUserMenu = ref(false)
const showNotifications = ref(false)
const searchQuery = ref('')
const isSearchFocused = ref(false)

// Notifications data
const notifications = ref([
  { id: 1, title: 'New student registered', desc: 'Abebe Kebede - Grade 9A', time: '5 min ago', unread: true, icon: Users, color: 'blue' },
  { id: 2, title: 'Payment received', desc: 'ETB 5,000 from Dawit', time: '1 hour ago', unread: true, icon: DollarSign, color: 'green' },
  { id: 3, title: 'Marks published', desc: 'Grade 10 Mid-term', time: '2 hours ago', unread: true, icon: FileText, color: 'purple' },
  { id: 4, title: 'New teacher added', desc: 'Sara Haile', time: '1 day ago', unread: false, icon: GraduationCap, color: 'orange' },
])

const unreadCount = computed(() => notifications.value.filter(n => n.unread).length)

// Search results
const searchResults = computed(() => {
  if (!searchQuery.value || searchQuery.value.length < 2) return []
  
  const q = searchQuery.value.toLowerCase()
  const pages = [
    { name: 'Dashboard', path: '/dashboard' },
    { name: 'Students', path: '/students' },
    { name: 'Teachers', path: '/teachers' },
    { name: 'Classes', path: '/classes' },
    { name: 'Subjects', path: '/subjects' },
    { name: 'Attendance', path: '/attendance' },
    { name: 'Marks', path: '/marks' },
    { name: 'Fees', path: '/fees' },
    { name: 'Library', path: '/library' },
    { name: 'Announcements', path: '/announcements' },
    { name: 'Reports', path: '/reports' },
    { name: 'Settings', path: '/settings' },
  ]
  
  return pages.filter(p => p.name.toLowerCase().includes(q))
})

// Methods
async function handleLogout() {
  await auth.logout()
  router.push('/login')
}

function closeAll() {
  showUserMenu.value = false
  showNotifications.value = false
}

function markAllRead() {
  notifications.value = notifications.value.map(n => ({ ...n, unread: false }))
}

function markRead(id) {
  const n = notifications.value.find(n => n.id === id)
  if (n) n.unread = false
}

function navigateTo(path) {
  router.push(path)
  searchQuery.value = ''
  isSearchFocused.value = false
}

function getColor(color) {
  const colors = {
    blue: { bg: 'bg-blue-100', text: 'text-blue-600' },
    green: { bg: 'bg-green-100', text: 'text-green-600' },
    purple: { bg: 'bg-purple-100', text: 'text-purple-600' },
    orange: { bg: 'bg-orange-100', text: 'text-orange-600' },
  }
  return colors[color] || colors.blue
}

// Keyboard shortcut
function handleKeydown(e) {
  if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
    e.preventDefault()
    document.getElementById('header-search')?.focus()
  }
  if (e.key === 'Escape') {
    closeAll()
    searchQuery.value = ''
  }
}

onMounted(() => {
  document.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
})
</script>

<template>
  <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between flex-shrink-0 sticky top-0 z-30">
    
    <!-- LEFT: Menu + Search -->
    <div class="flex items-center gap-3 flex-1 max-w-lg">
      <!-- Mobile menu -->
      <button 
        @click="emit('toggle-sidebar')" 
        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
      >
        <Menu class="w-5 h-5 text-gray-700" />
      </button>

      <!-- Search -->
      <div class="relative flex-1">
        <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg hover:border-gray-300 transition-colors"
             :class="isSearchFocused ? 'ring-2 ring-blue-500 border-transparent bg-white' : ''">
          <Search class="w-4 h-4 text-gray-400 flex-shrink-0" />
          <input 
            id="header-search"
            v-model="searchQuery"
            @focus="isSearchFocused = true"
            @blur="setTimeout(() => isSearchFocused = false, 200)"
            type="text" 
            placeholder="Search pages, students..." 
            class="flex-1 bg-transparent outline-none text-sm text-gray-700 placeholder-gray-400 min-w-0"
          />
          <button v-if="searchQuery" @click="searchQuery = ''" class="text-gray-400 hover:text-gray-600">
            <X class="w-4 h-4" />
          </button>
          <kbd v-else class="hidden md:inline-block text-[10px] font-semibold text-gray-500 bg-white border border-gray-200 px-1.5 py-0.5 rounded">
            Ctrl K
          </kbd>
        </div>

        <!-- Search Results Dropdown -->
        <div v-if="isSearchFocused && searchResults.length > 0" 
          class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-gray-200 max-h-80 overflow-y-auto z-50">
          <div class="p-2">
            <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
              Pages
            </div>
            <button 
              v-for="result in searchResults" 
              :key="result.path"
              @mousedown.prevent="navigateTo(result.path)"
              class="w-full text-left px-3 py-2 rounded-lg hover:bg-blue-50 text-gray-700 hover:text-blue-600 text-sm transition-colors flex items-center gap-2"
            >
              <Search class="w-4 h-4 text-gray-400" />
              {{ result.name }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Actions -->
    <div class="flex items-center gap-1">
      
      <!-- Notifications -->
      <div class="relative">
        <button 
          @click="showNotifications = !showNotifications; showUserMenu = false"
          class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors"
        >
          <Bell class="w-5 h-5 text-gray-600" />
          <span v-if="unreadCount > 0" 
            class="absolute top-1 right-1 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
            {{ unreadCount }}
          </span>
        </button>

        <!-- Notifications Dropdown -->
        <div v-if="showNotifications" 
          class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden z-50">
          
          <!-- Header -->
          <div class="px-4 py-3 border-b bg-gray-50 flex items-center justify-between">
            <div>
              <h3 class="font-semibold text-gray-800 text-sm">Notifications</h3>
              <p class="text-xs text-gray-500">{{ unreadCount }} unread</p>
            </div>
            <button 
              v-if="unreadCount > 0"
              @click="markAllRead"
              class="text-xs text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1"
            >
              <Check class="w-3 h-3" /> Mark all
            </button>
          </div>

          <!-- List -->
          <div class="max-h-96 overflow-y-auto">
            <div v-if="notifications.length === 0" class="p-8 text-center text-gray-500 text-sm">
              No notifications
            </div>
            <div 
              v-for="notif in notifications" 
              :key="notif.id"
              @click="markRead(notif.id)"
              :class="['px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors flex items-start gap-3 relative', notif.unread ? 'bg-blue-50/30' : '']"
            >
              <div v-if="notif.unread" class="absolute left-2 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-blue-500"></div>
              <div :class="['w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0', getColor(notif.color).bg]">
                <component :is="notif.icon" :class="['w-4 h-4', getColor(notif.color).text]" />
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800">{{ notif.title }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ notif.desc }}</p>
                <p class="text-[11px] text-gray-400 mt-1">{{ notif.time }}</p>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="px-4 py-2 bg-gray-50 border-t text-center">
            <button class="text-xs text-blue-600 hover:text-blue-700 font-medium">
              View all notifications
            </button>
          </div>
        </div>
      </div>

      <!-- Divider -->
      <div class="w-px h-6 bg-gray-200 mx-1 hidden sm:block"></div>

      <!-- User Menu -->
      <div class="relative">
        <button 
          @click="showUserMenu = !showUserMenu; showNotifications = false"
          class="flex items-center gap-2 p-1 pr-2 rounded-lg hover:bg-gray-100 transition-colors"
        >
          <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
            {{ auth.userName?.charAt(0)?.toUpperCase() || 'U' }}
          </div>
          <div class="hidden md:block text-left">
            <p class="text-sm font-semibold text-gray-800 leading-tight">{{ auth.userName }}</p>
            <p class="text-xs text-gray-500 capitalize leading-tight">{{ auth.userRole?.replace('_', ' ') }}</p>
          </div>
          <ChevronDown :class="['w-4 h-4 text-gray-400 transition-transform hidden md:block', showUserMenu ? 'rotate-180' : '']" />
        </button>

        <!-- User Dropdown -->
        <div v-if="showUserMenu" 
          class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden z-50">
          
          <!-- User info -->
          <div class="px-4 py-3 border-b bg-gradient-to-br from-blue-50 to-indigo-50">
            <div class="flex items-center gap-3">
              <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                {{ auth.userName?.charAt(0)?.toUpperCase() || 'U' }}
              </div>
              <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-800 text-sm truncate">{{ auth.userName }}</p>
                <p class="text-xs text-gray-500 truncate">{{ auth.userEmail }}</p>
              </div>
            </div>
          </div>

          <!-- Menu -->
          <div class="p-1">
            <button 
              @click="router.push('/settings'); showUserMenu = false"
              class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 text-gray-700 text-sm transition-colors"
            >
              <User class="w-4 h-4" /> 
              <span>My Profile</span>
            </button>
            
            <button 
              @click="router.push('/settings'); showUserMenu = false"
              class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 text-gray-700 text-sm transition-colors"
            >
              <Settings class="w-4 h-4" /> 
              <span>Settings</span>
            </button>

            <div class="my-1 border-t"></div>

            <button 
              @click="handleLogout"
              class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-red-50 text-red-600 text-sm transition-colors"
            >
              <LogOut class="w-4 h-4" /> 
              <span>Logout</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Backdrop -->
    <div v-if="showUserMenu || showNotifications" 
      @click="closeAll" 
      class="fixed inset-0 z-40"
    ></div>
  </header>
</template>
