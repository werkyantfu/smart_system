import api from './api'
export default {
  getAll: (params = {}) => api.get('/subjects', { params }),
  getOne: (id)          => api.get(`/subjects/${id}`),
  create: (data)        => api.post('/subjects', data),
  update: (id, data)    => api.put(`/subjects/${id}`, data),
  remove: (id)          => api.delete(`/subjects/${id}`)
}
