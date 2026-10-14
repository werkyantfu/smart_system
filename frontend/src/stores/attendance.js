import { defineStore } from 'pinia'
import { ref } from 'vue'
import attendanceService from '@/services/attendanceService'

export const useAttendanceStore = defineStore('attendance', () => {
  const items = ref([])
  const current = ref(null)
  const loading = ref(false)
  const error = ref(null)
  const pagination = ref({ current_page: 1, last_page: 1, per_page: 15, total: 0 })

  async function fetchAll(params = {}) {
    loading.value = true
    try {
      const response = await attendanceService.getAll(params)
      items.value = response.data.data.data || response.data.data
      pagination.value = response.data.data
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function fetchOne(id) {
    loading.value = true
    try {
      const response = await attendanceService.getById(id)
      current.value = response.data.data
      return { success: true, data: response.data.data }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function create(data) {
    loading.value = true
    try {
      const response = await attendanceService.create(data)
      items.value.unshift(response.data.data)
      return { success: true, data: response.data.data }
    } catch (err) {
      error.value = err.response?.data?.errors || err.response?.data?.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function update(id, data) {
    loading.value = true
    try {
      const response = await attendanceService.update(id, data)
      const index = items.value.findIndex(i => i.id === id)
      if (index !== -1) items.value[index] = response.data.data
      return { success: true, data: response.data.data }
    } catch (err) {
      error.value = err.response?.data?.errors || err.response?.data?.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function remove(id) {
    loading.value = true
    try {
      await attendanceService.delete(id)
      items.value = items.value.filter(i => i.id !== id)
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  return { items, current, loading, error, pagination, fetchAll, fetchOne, create, update, remove }
})
