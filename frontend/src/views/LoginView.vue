<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()
const email = ref('super@ssms.et')
const password = ref('password')

async function submit() {
  const ok = await auth.login(email.value, password.value)
  if (ok) router.push('/')
}
</script>

<template>
  <div class="login-wrap">
    <form class="login-card" @submit.prevent="submit">
      <h1>🏫 SSMS Login</h1>
      <label>Email
        <input v-model="email" type="email" required />
      </label>
      <label>Password
        <input v-model="password" type="password" required />
      </label>
      <p v-if="auth.error" class="error">{{ auth.error }}</p>
      <button class="primary" :disabled="auth.loading">
        {{ auth.loading ? 'Signing in…' : 'Sign in' }}
      </button>
      <p class="hint">Demo: super@ssms.et / password</p>
    </form>
  </div>
</template>

<style scoped>
.login-wrap { min-height: 100vh; display: grid; place-items: center; background: #0f172a; }
.login-card {
  background: white; padding: 2rem; border-radius: 10px;
  width: 360px; display: flex; flex-direction: column; gap: 1rem;
  box-shadow: 0 20px 50px rgba(0,0,0,.25);
}
.login-card h1 { margin: 0; font-size: 1.3rem; text-align: center; }
label { display: flex; flex-direction: column; font-size: .85rem; color: #475569; gap: .25rem; }
.error { color: #dc2626; font-size: .85rem; margin: 0; }
.hint { text-align: center; font-size: .75rem; color: #94a3b8; margin: 0; }
</style>
