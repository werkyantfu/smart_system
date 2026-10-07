import { defineStore } from 'pinia'
import authService from '@/services/authService'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || null,
    user:  JSON.parse(localStorage.getItem('user') || 'null'),
    loading: false,
    error: null
  }),

  getters: {
    isAuthenticated: (s) => !!s.token,
    userName: (s) => s.user?.name || 'Guest',
    userRole: (s) => s.user?.role || null
  },

  actions: {
    async login(email, password) {
      this.loading = true
      this.error = null
      try {
        const { data } = await authService.login(email, password)
        // api.js already unwrapped: data = { user, token, token_type }
        this.token = data.token
        this.user  = data.user
        localStorage.setItem('token', data.token)
        localStorage.setItem('user', JSON.stringify(data.user))
        return true
      } catch (e) {
        this.error = e.response?.data?.message || e.message || 'Login failed'
        return false
      } finally {
        this.loading = false
      }
    },

    async logout() {
      try { await authService.logout() } catch (_) {}
      this.token = null
      this.user = null
      localStorage.removeItem('token')
      localStorage.removeItem('user')
    },

    async fetchMe() {
      try {
        const { data } = await authService.me()
        this.user = data.user ?? data
        localStorage.setItem('user', JSON.stringify(this.user))
      } catch (_) {}
    }
  }
})
