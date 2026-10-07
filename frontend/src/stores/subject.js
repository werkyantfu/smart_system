import { defineStore } from 'pinia'
import subjectService from '@/services/subjectService'

export const useSubjectStore = defineStore('subject', {
  state: () => ({ list: [], loading: false, error: null }),
  getters: { count: (s) => s.list.length },
  actions: {
    async fetchAll(params = {}) {
      this.loading = true; this.error = null
      try {
        const { data } = await subjectService.getAll(params)
        this.list = data.data ?? data
      } catch (e) { this.error = e.response?.data?.message || e.message }
      finally { this.loading = false }
    },
    async create(p) { const { data } = await subjectService.create(p); const i = data.data ?? data; this.list.unshift(i); return i },
    async update(id, p) { const { data } = await subjectService.update(id, p); const i = data.data ?? data; const x = this.list.findIndex(s => s.id === id); if (x !== -1) this.list[x] = i; return i },
    async remove(id) { await subjectService.remove(id); this.list = this.list.filter(s => s.id !== id) }
  }
})
