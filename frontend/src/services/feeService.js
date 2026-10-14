import api from './api'

export default {
  getAll(params = {}) { return api.get('/fees', { params }) },
  getById(id) { return api.get(`/fees/${id}`) },
  create(data) { return api.post('/fees', data) },
  update(id, data) { return api.put(`/fees/${id}`, data) },
  delete(id) { return api.delete(`/fees/${id}`) },
}
