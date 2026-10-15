import { defineStore } from 'pinia'
import { ref } from 'vue'
import dashboardService from '@/services/dashboardService'

export const useDashboardStore = defineStore('dashboard', () => {
  const stats = ref({
    total_students: 0,
    total_teachers: 0,
    total_classes: 0,
    total_revenue: 0,
  })
  const recentActivities = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function fetchStats() {
    loading.value = true
    error.value = null
    try {
      const response = await dashboardService.getStats()
      const data = response.data.data || response.data
      stats.value = data
      return { success: true, data }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function fetchActivities() {
    loading.value = true
    try {
      const response = await dashboardService.getActivities()
      recentActivities.value = response.data.data || response.data || []
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function fetchAll() {
    return Promise.all([fetchStats(), fetchActivities()])
  }

  return {
    stats, recentActivities, loading, error,
    fetchStats, fetchActivities, fetchAll,
  }
})
