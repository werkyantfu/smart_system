import api from './api'

export default {
  login(credentials) {
    return api.post('/auth/login', credentials)
  },

  register(data) {
    return api.post('/auth/register', data)
  },

  logout() {
    return api.post('/auth/logout')
  },

  getProfile() {
    return api.get('/auth/me')
  },

  refreshToken() {
    return api.post('/auth/refresh')
  },

  updateProfile(data) {
    return api.put('/auth/profile', data)
  },

  changePassword(data) {
    return api.post('/auth/change-password', data)
  }
}
