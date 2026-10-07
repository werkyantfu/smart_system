import api from './api'

export default {
  getAll(params = {}) {
    return api.get('/students', { params })
  },
  getById(id) {
    return api.get(`/students/${id}`)
  },
  create(data) {
    return api.post('/students', data)
  },
  update(id, data) {
    return api.put(`/students/${id}`, data)
  },
  delete(id) {
    return api.delete(`/students/${id}`)
  },
  import(formData) {
    return api.post('/students/import', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })
  },
  export(params = {}) {
    return api.get('/students/export', { params, responseType: 'blob' })
  },
}
