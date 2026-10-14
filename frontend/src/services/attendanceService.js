import api from './api'

export default {
  getAll(params = {}) { return api.get('/attendances', { params }) },
  getById(id) { return api.get(`/attendances/${id}`) },
  create(data) { return api.post('/attendances', data) },
  update(id, data) { return api.put(`/attendances/${id}`, data) },
  delete(id) { return api.delete(`/attendances/${id}`) },
}
