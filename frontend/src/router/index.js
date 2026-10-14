import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', component: () => import('@/views/HomeView.vue') },
    { path: '/login', name: 'login', component: () => import('@/views/LoginView.vue') },
    { path: '/dashboard', name: 'dashboard', component: () => import('@/views/DashboardView.vue'), meta: { requiresAuth: true } },
    { path: '/students', name: 'students', component: () => import('@/views/StudentsView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'director', 'teacher', 'accountant', 'librarian'] } },
    { path: '/teachers', name: 'teachers', component: () => import('@/views/TeachersView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'director'] } },
    { path: '/classes', name: 'classes', component: () => import('@/views/ClassesView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'director', 'teacher'] } },
    { path: '/subjects', name: 'subjects', component: () => import('@/views/SubjectsView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'director', 'teacher'] } },
    { path: '/attendance', name: 'attendance', component: () => import('@/views/AttendanceView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'director', 'teacher', 'student', 'parent'] } },
    { path: '/marks', name: 'marks', component: () => import('@/views/MarksView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'director', 'teacher', 'student', 'parent'] } },
    { path: '/fees', name: 'fees', component: () => import('@/views/FeesView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'director', 'accountant', 'parent'] } },
    { path: '/library', name: 'library', component: () => import('@/views/LibraryView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'director', 'librarian', 'student'] } },
    { path: '/announcements', name: 'announcements', component: () => import('@/views/AnnouncementsView.vue'), meta: { requiresAuth: true } },
    { path: '/reports', name: 'reports', component: () => import('@/views/ReportsView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin', 'director', 'accountant'] } },
    { path: '/settings', name: 'settings', component: () => import('@/views/SettingsView.vue'), meta: { requiresAuth: true, roles: ['super_admin', 'admin'] } },
    { path: '/:pathMatch(.*)*', redirect: '/' }
  ]
})

router.beforeEach((to, from, next) => {
  const auth = useAuthStore()
  auth.initialize()

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return next('/login')
  }
  if (to.path === '/login' && auth.isAuthenticated) {
    return next('/dashboard')
  }
  if (to.meta.roles && auth.userRole) {
    if (!to.meta.roles.includes(auth.userRole)) {
      console.warn(`Access denied to ${to.path}`)
      return next('/dashboard')
    }
  }
  next()
})

export default router
