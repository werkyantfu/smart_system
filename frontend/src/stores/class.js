import { defineStore } from 'pinia'
import { ref } from 'vue'
import classService from '@/services/classService'

export const useClassStore = defineStore('class', () => {
  const items = ref([])
  const classes = ref([])
  const current = ref(null)
  const loading = ref(false)
  const error = ref(null)
  const pagination = ref({ current_page: 1, last_page: 1, per_page: 15, total: 0 })

  async function fetchAll(params = {}) {
    loading.value = true
    error.value = null
    try {
      const response = await classService.getAll(params)
      const data = response.data.data || response.data
      items.value = data.data || data
      classes.value = data.data || data
      pagination.value = data
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function fetchClasses(params = {}) {
    return fetchAll(params)
  }

  async function fetchOne(id) {
    loading.value = true
    try {
      const response = await classService.getById(id)
      current.value = response.data.data || response.data
      return { success: true, data: current.value }
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
      const response = await classService.create(data)
      const newItem = response.data.data || response.data
      items.value.unshift(newItem)
      classes.value.unshift(newItem)
      return { success: true, data: newItem }
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
      const response = await classService.update(id, data)
      const updated = response.data.data || response.data
      const index = items.value.findIndex(i => i.id === id)
      if (index !== -1) items.value[index] = updated
      const index2 = classes.value.findIndex(i => i.id === id)
      if (index2 !== -1) classes.value[index2] = updated
      return { success: true, data: updated }
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
      await classService.delete(id)
      items.value = items.value.filter(i => i.id !== id)
      classes.value = classes.value.filter(i => i.id !== id)
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  return {
    items, classes, current, loading, error, pagination,
    fetchAll, fetchClasses, fetchOne, create, update, remove,
  }
})
