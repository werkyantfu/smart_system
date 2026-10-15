import { defineStore } from 'pinia'
import { ref } from 'vue'
import teacherService from '@/services/teacherService'

export const useTeacherStore = defineStore('teacher', () => {
  const items = ref([])
  const teachers = ref([])
  const current = ref(null)
  const loading = ref(false)
  const error = ref(null)
  const pagination = ref({ current_page: 1, last_page: 1, per_page: 15, total: 0 })

  async function fetchAll(params = {}) {
    loading.value = true
    error.value = null
    try {
      const response = await teacherService.getAll(params)
      const data = response.data.data || response.data
      items.value = data.data || data
      teachers.value = data.data || data
      pagination.value = data
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function fetchTeachers(params = {}) {
    return fetchAll(params)
  }

  async function fetchOne(id) {
    loading.value = true
    try {
      const response = await teacherService.getById(id)
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
      const response = await teacherService.create(data)
      const newItem = response.data.data || response.data
      items.value.unshift(newItem)
      teachers.value.unshift(newItem)
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
      const response = await teacherService.update(id, data)
      const updated = response.data.data || response.data
      const index = items.value.findIndex(i => i.id === id)
      if (index !== -1) items.value[index] = updated
      const index2 = teachers.value.findIndex(i => i.id === id)
      if (index2 !== -1) teachers.value[index2] = updated
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
      await teacherService.delete(id)
      items.value = items.value.filter(i => i.id !== id)
      teachers.value = teachers.value.filter(i => i.id !== id)
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  return {
    items, teachers, current, loading, error, pagination,
    fetchAll, fetchTeachers, fetchOne, create, update, remove,
  }
})
