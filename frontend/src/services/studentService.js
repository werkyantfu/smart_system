import api from './api'
export default {
  getAll: (params = {}) => api.get('/students', { params }),
  getOne: (id)          => api.get(`/students/${id}`),
  create: (data)        => api.post('/students', data),
  update: (id, data)    => api.put(`/students/${id}`, data),
  remove: (id)          => api.delete(`/students/${id}`)
}
