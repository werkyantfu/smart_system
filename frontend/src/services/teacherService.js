import api from './api'
export default {
  getAll: (params = {}) => api.get('/teachers', { params }),
  getOne: (id)          => api.get(`/teachers/${id}`),
  create: (data)        => api.post('/teachers', data),
  update: (id, data)    => api.put(`/teachers/${id}`, data),
  remove: (id)          => api.delete(`/teachers/${id}`)
}
