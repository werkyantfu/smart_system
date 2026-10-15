<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { 
  Menu, Bell, ChevronDown, LogOut, Settings as SettingsIcon,
  Search, User, HelpCircle, Moon, Sun, X,
  FileText, DollarSign, Users, GraduationCap, Check, Sparkles
} from 'lucide-vue-next'

defineProps({ title: { type: String, default: 'Dashboard' } })
const emit = defineEmits(['toggle-sidebar'])

const router = useRouter()
const route = useRoute()
const auth = useAuthStore()

const showUserMenu = ref(false)
const showNotifications = ref(false)
const showSearch = ref(false)
const searchQuery = ref('')
const isDark = ref(false)
const currentTime = ref(new Date())

const notifications = ref([
  { id: 1, title: 'New student registered', desc: 'Abebe Kebede joined Grade 9A', time: '5 min ago', unread: true, icon: Users, color: 'blue' },
  { id: 2, title: 'Payment received', desc: 'ETB 5,000 from Dawit Tesfaye', time: '1 hour ago', unread: true, icon: DollarSign, color: 'green' },
  { id: 3, title: 'Marks published', desc: 'Grade 10 Mid-term results', time: '2 hours ago', unread: true, icon: FileText, color: 'purple' },
  { id: 4, title: 'New teacher added', desc: 'Sara Haile - Mathematics', time: '1 day ago', unread: false, icon: GraduationCap, color: 'orange' },
])

const unreadCount = computed(() => notifications.value.filter(n => n.unread).length)

const breadcrumbs = computed(() => {
  const parts = route.path.split('/').filter(Boolean)
  if (parts.length === 0) return [{ name: 'Dashboard', path: '/dashboard' }]
  return parts.map((p, i) => ({
    name: p.charAt(0).toUpperCase() + p.slice(1),
    path: '/' + parts.slice(0, i + 1).join('/')
  }))
})

const roleGradients = {
  super_admin: 'from-red-500 via-pink-500 to-rose-600',
  admin: 'from-blue-500 via-indigo-500 to-purple-600',
  director: 'from-purple-500 via-fuchsia-500 to-pink-600',
  teacher: 'from-green-500 via-emerald-500 to-teal-600',
  accountant: 'from-yellow-500 via-orange-500 to-red-500',
  librarian: 'from-teal-500 via-cyan-500 to-blue-600',
  student: 'from-cyan-500 via-blue-500 to-indigo-600',
  parent: 'from-indigo-500 via-purple-500 to-pink-600',
}

const userGradient = computed(() => roleGradients[auth.userRole] || roleGradients.admin)
const greeting = computed(() => {
  const h = currentTime.value.getHours()
  if (h < 12) return 'Good morning'
  if (h < 18) return 'Good afternoon'
  return 'Good evening'
})

function toggleUserMenu() {
  showUserMenu.value = !showUserMenu.value
  showNotifications.value = false
}

function toggleNotifications() {
  showNotifications.value = !showNotifications.value
  showUserMenu.value = false
}

function toggleSearch() {
  showSearch.value = !showSearch.value
  if (showSearch.value) {
    setTimeout(() => document.getElementById('global-search')?.focus(), 100)
  }
}

function toggleTheme() {
  isDark.value = !isDark.value
  document.documentElement.classList.toggle('dark', isDark.value)
}

async function handleLogout() {
  await auth.logout()
  router.push('/login')
}

function closeAll() {
  showUserMenu.value = false
  showNotifications.value = false
  showSearch.value = false
}

function markAllRead() {
  notifications.value = notifications.value.map(n => ({ ...n, unread: false }))
}

const getColorClasses = (color) => {
  const colors = {
    blue: { bg: 'bg-blue-100', text: 'text-blue-600' },
    green: { bg: 'bg-green-100', text: 'text-green-600' },
    purple: { bg: 'bg-purple-100', text: 'text-purple-600' },
    orange: { bg: 'bg-orange-100', text: 'text-orange-600' },
  }
  return colors[color] || colors.blue
}

const searchResults = computed(() => {
  if (!searchQuery.value) return []
  const q = searchQuery.value.toLowerCase()
  const items = [
    { label: 'Dashboard', path: '/dashboard' },
    { label: 'Students', path: '/students' },
    { label: 'Teachers', path: '/teachers' },
    { label: 'Classes', path: '/classes' },
    { label: 'Subjects', path: '/subjects' },
    { label: 'Attendance', path: '/attendance' },
    { label: 'Marks', path: '/marks' },
    { label: 'Fees', path: '/fees' },
    { label: 'Library', path: '/library' },
    { label: 'Announcements', path: '/announcements' },
    { label: 'Reports', path: '/reports' },
    { label: 'Settings', path: '/settings' },
  ]
  return items.filter(i => i.label.toLowerCase().includes(q))
})

function navigateTo(path) {
  router.push(path)
  showSearch.value = false
  searchQuery.value = ''
}

function handleKeydown(e) {
  if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
    e.preventDefault()
    toggleSearch()
  }
  if (e.key === 'Escape') closeAll()
}

let timer
onMounted(() => {
  document.addEventListener('keydown', handleKeydown)
  timer = setInterval(() => { currentTime.value = new Date() }, 60000)
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
  clearInterval(timer)
})
</script>

<template>
  <!-- Backdrop -->
  <div v-if="showUserMenu || showNotifications || showSearch" 
    @click="closeAll" 
    class="fixed inset-0 bg-black/20 backdrop-blur-sm z-20">
  </div>

  <header class="bg-white/80 backdrop-blur-xl border-b border-gray-200/80 shadow-sm sticky top-0 z-30 flex-shrink-0">
    <!-- Top gradient line -->
    <div :class="['h-1 bg-gradient-to-r', userGradient]"></div>

    <div class="flex items-center justify-between h-16 px-4 sm:px-6">
      
      <!-- LEFT SIDE -->
      <div class="flex items-center gap-3 min-w-0 flex-1">
        <button 
          @click="emit('toggle-sidebar')" 
          class="lg:hidden p-2 rounded-xl hover:bg-gray-100 active:scale-95 transition-all"
        >
          <Menu class="w-5 h-5 text-gray-700" />
        </button>

        <div class="min-w-0">
          <!-- Breadcrumbs -->
          <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-0.5">
            <button @click="router.push('/dashboard')" class="hover:text-blue-600 transition-colors font-medium">
              Home
            </button>
            <template v-for="(crumb, idx) in breadcrumbs" :key="idx">
              <span class="text-gray-300">/</span>
              <button 
                @click="router.push(crumb.path)"
                :class="idx === breadcrumbs.length - 1 ? 'text-blue-600 font-semibold' : 'hover:text-blue-600'"
              >
                {{ crumb.name }}
              </button>
            </template>
          </div>
          <h1 class="text-lg font-bold text-gray-800 truncate">{{ title }}</h1>
        </div>
      </div>

      <!-- RIGHT SIDE -->
      <div class="flex items-center gap-1.5 flex-shrink-0">
        
        <!-- Greeting (desktop) -->
        <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
          <Sparkles class="w-3.5 h-3.5 text-blue-500" />
          <span class="text-xs font-medium text-blue-700">{{ greeting }}, {{ auth.userName?.split(' ')[0] }}</span>
        </div>

        <!-- Search -->
        <button 
          @click="toggleSearch"
          class="hidden md:flex items-center gap-2 px-3 py-2 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-200 transition-all group"
        >
          <Search class="w-4 h-4 text-gray-500 group-hover:text-blue-600" />
          <span class="text-sm text-gray-500 group-hover:text-gray-700">Search...</span>
          <kbd class="hidden lg:inline-flex items-center gap-0.5 px-1.5 py-0.5 text-xs font-semibold text-gray-500 bg-white border border-gray-200 rounded">
            <span>Ctrl</span><span>K</span>
          </kbd>
        </button>

        <button 
          @click="toggleSearch"
          class="md:hidden p-2 rounded-xl hover:bg-gray-100 active:scale-95 transition-all"
        >
          <Search class="w-5 h-5 text-gray-600" />
        </button>

        <!-- Theme Toggle -->
        <button 
          @click="toggleTheme"
          class="p-2 rounded-xl hover:bg-gray-100 active:scale-95 transition-all"
        >
          <Sun v-if="isDark" class="w-5 h-5 text-yellow-500" />
          <Moon v-else class="w-5 h-5 text-gray-600" />
        </button>

        <!-- Notifications -->
        <div class="relative">
          <button 
            @click="toggleNotifications" 
            class="relative p-2 rounded-xl hover:bg-gray-100 active:scale-95 transition-all group"
          >
            <Bell class="w-5 h-5 text-gray-600 group-hover:text-blue-600 transition-colors" />
            <span v-if="unreadCount > 0" 
              class="absolute top-1 right-1 min-w-[18px] h-[18px] px-1 bg-gradient-to-br from-red-500 to-pink-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-lg animate-pulse">
              {{ unreadCount }}
            </span>
          </button>

          <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 scale-95 -translate-y-2"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
          >
            <div v-if="showNotifications" 
              class="absolute right-0 mt-2 w-[360px] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
              <div class="px-5 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                <div class="flex items-center justify-between">
                  <div>
                    <h3 class="font-bold text-gray-800">Notifications</h3>
                    <p class="text-xs text-gray-500">{{ unreadCount }} unread</p>
                  </div>
                  <button 
                    @click="markAllRead"
                    class="text-xs text-blue-600 hover:text-blue-700 font-medium px-2 py-1 rounded-lg hover:bg-white transition-colors flex items-center gap-1"
                  >
                    <Check class="w-3 h-3" />
                    Mark all read
                  </button>
                </div>
              </div>
              <div class="max-h-96 overflow-y-auto">
                <div v-for="notif in notifications" :key="notif.id" 
                  :class="['px-5 py-3 border-b border-gray-50 hover:bg-gray-50 cursor-pointer transition-colors flex items-start gap-3 relative', notif.unread ? 'bg-blue-50/30' : '']">
                  <div v-if="notif.unread" class="absolute left-2 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-blue-500"></div>
                  <div :class="['w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0', getColorClasses(notif.color).bg]">
                    <component :is="notif.icon" :class="['w-5 h-5', getColorClasses(notif.color).text]" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800">{{ notif.title }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ notif.desc }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">{{ notif.time }}</p>
                  </div>
                </div>
              </div>
              <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 text-center">
                <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                  View all notifications
                </button>
              </div>
            </div>
          </Transition>
        </div>

        <!-- User Menu -->
        <div class="relative">
          <button 
            @click="toggleUserMenu" 
            class="flex items-center gap-2 p-1 pr-2 sm:pr-3 rounded-xl hover:bg-gray-100 active:scale-95 transition-all"
          >
            <div :class="['w-9 h-9 rounded-xl bg-gradient-to-br flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white', userGradient]">
              {{ auth.userName?.charAt(0)?.toUpperCase() || 'U' }}
            </div>
            <div class="hidden sm:block text-left">
              <p class="text-sm font-semibold text-gray-800 leading-tight">{{ auth.userName }}</p>
              <p class="text-[11px] text-gray-500 capitalize leading-tight">{{ auth.userRole?.replace('_', ' ') }}</p>
            </div>
            <ChevronDown :class="['w-4 h-4 text-gray-400 hidden sm:block transition-transform', showUserMenu ? 'rotate-180' : '']" />
          </button>

          <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 scale-95 -translate-y-2"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
          >
            <div v-if="showUserMenu" 
              class="absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
              <div :class="['px-5 py-4 bg-gradient-to-br text-white', userGradient]">
                <div class="flex items-center gap-3">
                  <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center text-white font-bold text-xl ring-2 ring-white/30">
                    {{ auth.userName?.charAt(0)?.toUpperCase() || 'U' }}
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="font-bold truncate">{{ auth.userName }}</p>
                    <p class="text-xs text-white/80 truncate">{{ auth.userEmail }}</p>
                    <span class="inline-block mt-1 px-2 py-0.5 bg-white/20 rounded-full text-[10px] font-semibold uppercase tracking-wider">
                      {{ auth.userRole?.replace('_', ' ') }}
                    </span>
                  </div>
                </div>
              </div>
              
              <div class="p-2">
                <button 
                  @click="router.push('/settings'); showUserMenu = false"
                  class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 text-gray-700 transition-colors group"
                >
                  <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                    <User class="w-4 h-4 text-gray-600 group-hover:text-blue-600" />
                  </div>
                  <span class="text-sm font-medium">My Profile</span>
                </button>
                
                <button 
                  @click="router.push('/settings'); showUserMenu = false"
                  class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 text-gray-700 transition-colors group"
                >
                  <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-purple-100 flex items-center justify-center transition-colors">
                    <SettingsIcon class="w-4 h-4 text-gray-600 group-hover:text-purple-600" />
                  </div>
                  <span class="text-sm font-medium">Settings</span>
                </button>

                <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 text-gray-700 transition-colors group">
                  <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-green-100 flex items-center justify-center transition-colors">
                    <HelpCircle class="w-4 h-4 text-gray-600 group-hover:text-green-600" />
                  </div>
                  <span class="text-sm font-medium">Help & Support</span>
                </button>

                <div class="my-2 border-t border-gray-100"></div>

                <button 
                  @click="handleLogout"
                  class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-50 text-red-600 transition-colors group"
                >
                  <div class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center transition-colors">
                    <LogOut class="w-4 h-4 text-red-600" />
                  </div>
                  <span class="text-sm font-medium">Logout</span>
                </button>
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </div>

    <!-- SEARCH MODAL -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div v-if="showSearch" 
        class="fixed top-20 left-1/2 -translate-x-1/2 w-[90%] max-w-2xl bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
        
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
          <Search class="w-5 h-5 text-gray-400" />
          <input 
            id="global-search"
            v-model="searchQuery"
            type="text"
            placeholder="Search pages, students, teachers..."
            class="flex-1 outline-none text-gray-800 placeholder-gray-400 text-base"
          />
          <button @click="showSearch = false" class="p-1 rounded-lg hover:bg-gray-100 transition-colors">
            <X class="w-4 h-4 text-gray-400" />
          </button>
        </div>

        <div class="max-h-96 overflow-y-auto p-2">
          <template v-if="searchResults.length > 0">
            <div class="px-3 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
              Quick Navigation
            </div>
            <button 
              v-for="result in searchResults" 
              :key="result.path"
              @click="navigateTo(result.path)"
              class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-blue-50 text-left transition-colors group"
            >
              <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                <Search class="w-4 h-4 text-gray-500 group-hover:text-blue-600" />
              </div>
              <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">{{ result.label }}</span>
            </button>
          </template>
          
          <div v-else-if="searchQuery" class="px-5 py-12 text-center">
            <Search class="w-12 h-12 text-gray-200 mx-auto mb-3" />
            <p class="text-gray-500 text-sm">No results for "{{ searchQuery }}"</p>
          </div>
          
          <div v-else class="px-5 py-8 text-center">
            <div class="flex items-center justify-center gap-2 text-xs text-gray-400 mb-2">
              <kbd class="px-2 py-1 bg-gray-100 rounded text-gray-600 font-semibold">Ctrl</kbd>
              <span>+</span>
              <kbd class="px-2 py-1 bg-gray-100 rounded text-gray-600 font-semibold">K</kbd>
            </div>
            <p class="text-sm text-gray-500">Quick navigation</p>
            <p class="text-xs text-gray-400 mt-1">Start typing to search...</p>
          </div>
        </div>
      </div>
    </Transition>
  </header>
</template>
