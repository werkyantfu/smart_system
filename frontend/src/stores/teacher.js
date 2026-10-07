import { defineStore } from 'pinia'
import teacherService from '@/services/teacherService'

export const useTeacherStore = defineStore('teacher', {
  state: () => ({ list: [], loading: false, error: null }),
  getters: { count: (s) => s.list.length },
  actions: {
    async fetchAll(params = {}) {
      this.loading = true; this.error = null
      try {
        const { data } = await teacherService.getAll(params)
        this.list = Array.isArray(data) ? data : (data.data ?? [])
      } catch (e) {
        this.error = e.response?.data?.message || e.message
      } finally { this.loading = false }
    },
    async create(payload) {
      const { data } = await teacherService.create(payload)
      const item = data.data ?? data
      this.list.unshift(item)
      return item
    },
    async update(id, payload) {
      const { data } = await teacherService.update(id, payload)
      const item = data.data ?? data
      const i = this.list.findIndex(x => x.id === id)
      if (i !== -1) this.list[i] = item
      return item
    },
    async remove(id) {
      await teacherService.remove(id)
      this.list = this.list.filter(x => x.id !== id)
    }
  }
})
