import { defineStore } from 'pinia'
import { ref } from 'vue'
import classService from '@/services/classService'

export const useClassStore = defineStore('class', () => {
  const items = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function fetchAll(params = {}) {
    loading.value = true
    try {
      const response = await classService.getAll(params)
      items.value = response.data.data?.data || response.data.data || []
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  return { items, loading, error, fetchAll }
})
