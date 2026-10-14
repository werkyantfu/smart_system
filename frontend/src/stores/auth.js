import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import authService from '@/services/authService'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('user') || 'null'))
  const token = ref(localStorage.getItem('token') || null)
  const loading = ref(false)
  const error = ref(null)

  const isAuthenticated = computed(() => !!token.value)
  const currentUser = computed(() => user.value)
  const userName = computed(() => user.value?.name || 'Guest')
  const userEmail = computed(() => user.value?.email || '')
  const userRole = computed(() => {
    if (user.value?.role) return user.value.role
    if (user.value?.roles?.[0]?.name) return user.value.roles[0].name
    return null
  })

  const isSuperAdmin = computed(() => userRole.value === 'super_admin')
  const isAdmin = computed(() => ['super_admin', 'admin'].includes(userRole.value))
  const isDirector = computed(() => userRole.value === 'director')
  const isTeacher = computed(() => userRole.value === 'teacher')
  const isAccountant = computed(() => userRole.value === 'accountant')
  const isLibrarian = computed(() => userRole.value === 'librarian')
  const isStudent = computed(() => userRole.value === 'student')
  const isParent = computed(() => userRole.value === 'parent')

  async function login(emailOrCredentials, password) {
    loading.value = true
    error.value = null
    try {
      const credentials = typeof emailOrCredentials === 'object'
        ? emailOrCredentials
        : { email: emailOrCredentials, password }

      const response = await authService.login(credentials)
      const data = response.data.data || response.data

      token.value = data.token
      user.value = data.user
      localStorage.setItem('token', data.token)
      localStorage.setItem('user', JSON.stringify(data.user))
      return true
    } catch (err) {
      error.value = err.response?.data?.message || err.message || 'Login failed'
      return false
    } finally {
      loading.value = false
    }
  }

  async function logout() {
    try {
      if (token.value) await authService.logout().catch(() => {})
    } finally {
      token.value = null
      user.value = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    }
  }

  async function fetchMe() {
    if (!token.value) return false
    try {
      const response = await authService.getProfile()
      user.value = response.data.data || response.data
      localStorage.setItem('user', JSON.stringify(user.value))
      return true
    } catch (err) {
      if (err.response?.status === 401) await logout()
      return false
    }
  }

  function hasRole(roleName) {
    if (!user.value) return false
    const roles = user.value.roles?.map(r => r.name) || []
    return roles.includes(roleName) || user.value.role === roleName
  }

  function hasAnyRole(roleNames) {
    return roleNames.some(r => hasRole(r))
  }

  function hasPermission(permissionName) {
    if (!user.value) return false
    if (isSuperAdmin.value || isAdmin.value) return true
    const permissions = user.value.permissions?.map(p => p.name) || []
    return permissions.includes(permissionName)
  }

  function hasAnyPermission(permissionNames) {
    return permissionNames.some(p => hasPermission(p))
  }

  function initialize() {
    const savedUser = localStorage.getItem('user')
    const savedToken = localStorage.getItem('token')
    if (savedUser && savedToken) {
      try {
        user.value = JSON.parse(savedUser)
        token.value = savedToken
      } catch (_) {
        localStorage.removeItem('user')
        localStorage.removeItem('token')
      }
    }
  }

  return {
    user, token, loading, error,
    isAuthenticated, currentUser, userName, userEmail, userRole,
    isSuperAdmin, isAdmin, isDirector, isTeacher, isAccountant,
    isLibrarian, isStudent, isParent,
    login, logout, fetchMe, initialize,
    hasRole, hasAnyRole, hasPermission, hasAnyPermission
  }
})
