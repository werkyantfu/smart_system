import api from './api'

export default {
  getAll(params = {}) { return api.get('/marks', { params }) },
  getById(id) { return api.get(`/marks/${id}`) },
  create(data) { return api.post('/marks', data) },
  update(id, data) { return api.put(`/marks/${id}`, data) },
  delete(id) { return api.delete(`/marks/${id}`) },
}
