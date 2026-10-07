import api from './api'
export default {
  getAll:      (params = {}) => api.get('/classes', { params }),
  getOne:      (id)          => api.get(`/classes/${id}`),
  create:      (data)        => api.post('/classes', data),
  update:      (id, data)    => api.put(`/classes/${id}`, data),
  remove:      (id)          => api.delete(`/classes/${id}`),
  getStudents: (id)          => api.get(`/classes/${id}/students`)
}
