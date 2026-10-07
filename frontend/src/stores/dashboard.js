import { defineStore } from 'pinia'
import dashboardService from '@/services/dashboardService'

export const useDashboardStore = defineStore('dashboard', {
  state: () => ({
    stats: {},
    attendanceChart: [],
    financialChart: [],
    loading: false,
    error: null
  }),
  actions: {
    async fetchAll() {
      this.loading = true; this.error = null
      try {
        const [s, a, f] = await Promise.all([
          dashboardService.stats(),
          dashboardService.attendanceChart(),
          dashboardService.financialChart()
        ])
        this.stats           = s.data ?? {}
        this.attendanceChart = a.data ?? []
        this.financialChart  = f.data ?? []
      } catch (e) {
        this.error = e.response?.data?.message || e.message
      } finally { this.loading = false }
    }
  }
})
