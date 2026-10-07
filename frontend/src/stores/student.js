import { defineStore } from 'pinia'
import { ref } from 'vue'
import studentService from '@/services/studentService'

export const useStudentStore = defineStore('student', () => {
  const students = ref([])
  const currentStudent = ref(null)
  const loading = ref(false)
  const error = ref(null)
  const pagination = ref({
    current_page: 1,
    last_page: 1,
    per_page: 15,
    total: 0,
  })

  async function fetchStudents(params = {}) {
    loading.value = true
    error.value = null
    try {
      const response = await studentService.getAll(params)
      students.value = response.data.data.data
      pagination.value = {
        current_page: response.data.data.current_page,
        last_page: response.data.data.last_page,
        per_page: response.data.data.per_page,
        total: response.data.data.total,
      }
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to load students'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function fetchStudent(id) {
    loading.value = true
    error.value = null
    try {
      const response = await studentService.getById(id)
      currentStudent.value = response.data.data
      return { success: true, data: response.data.data }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to load student'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function createStudent(data) {
    loading.value = true
    error.value = null
    try {
      const response = await studentService.create(data)
      students.value.unshift(response.data.data)
      return { success: true, data: response.data.data }
    } catch (err) {
      error.value = err.response?.data?.errors || err.response?.data?.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function updateStudent(id, data) {
    loading.value = true
    error.value = null
    try {
      const response = await studentService.update(id, data)
      const index = students.value.findIndex(s => s.id === id)
      if (index !== -1) students.value[index] = response.data.data
      return { success: true, data: response.data.data }
    } catch (err) {
      error.value = err.response?.data?.errors || err.response?.data?.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function deleteStudent(id) {
    loading.value = true
    error.value = null
    try {
      await studentService.delete(id)
      students.value = students.value.filter(s => s.id !== id)
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to delete student'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  return {
    students,
    currentStudent,
    loading,
    error,
    pagination,
    fetchStudents,
    fetchStudent,
    createStudent,
    updateStudent,
    deleteStudent,
  }
})
