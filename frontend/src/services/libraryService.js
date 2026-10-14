import api from './api'

export default {
  getAll(params = {}) { return api.get('/librarys', { params }) },
  getById(id) { return api.get(`/librarys/${id}`) },
  create(data) { return api.post('/librarys', data) },
  update(id, data) { return api.put(`/librarys/${id}`, data) },
  delete(id) { return api.delete(`/librarys/${id}`) },
}
