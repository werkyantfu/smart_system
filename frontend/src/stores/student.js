import { defineStore } from 'pinia'
import studentService from '@/services/studentService'

export const useStudentStore = defineStore('student', {
  state: () => ({ list: [], loading: false, error: null }),
  getters: { count: (s) => s.list.length },
  actions: {
    async fetchAll(params = {}) {
      this.loading = true; this.error = null
      try {
        const { data } = await studentService.getAll(params)
        this.list = data.data ?? data
      } catch (e) {
        this.error = e.response?.data?.message || e.message
      } finally { this.loading = false }
    },
    async create(payload) {
      const { data } = await studentService.create(payload)
      const item = data.data ?? data
      this.list.unshift(item)
      return item
    },
    async update(id, payload) {
      const { data } = await studentService.update(id, payload)
      const item = data.data ?? data
      const i = this.list.findIndex(s => s.id === id)
      if (i !== -1) this.list[i] = item
      return item
    },
    async remove(id) {
      await studentService.remove(id)
      this.list = this.list.filter(s => s.id !== id)
    }
  }
})
