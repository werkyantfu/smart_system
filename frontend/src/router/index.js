import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  { path: '/login', name: 'login', component: () => import('@/views/LoginView.vue'), meta: { public: true } },
  { path: '/', name: 'dashboard', component: () => import('@/views/DashboardView.vue') },
  { path: '/students', name: 'students', component: () => import('@/views/StudentsView.vue') },
  { path: '/teachers', name: 'teachers', component: () => import('@/views/TeachersView.vue') },
  { path: '/classes', name: 'classes', component: () => import('@/views/ClassesView.vue') },
  { path: '/subjects', name: 'subjects', component: () => import('@/views/SubjectsView.vue') }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to) => {
  const auth = useAuthStore()
  if (!to.meta.public && !auth.isAuthenticated) return { name: 'login' }
  if (to.name === 'login' && auth.isAuthenticated) return { name: 'dashboard' }
})

export default router
