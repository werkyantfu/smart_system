import api from './api'
export default {
  stats:           () => api.get('/dashboard/stats'),
  attendanceChart: () => api.get('/dashboard/charts/attendance'),
  financialChart:  () => api.get('/dashboard/charts/financial')
}
