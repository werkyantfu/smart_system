<script setup>
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

const links = [
  { to: '/',         label: '📊 Dashboard' },
  { to: '/students', label: '🎓 Students' },
  { to: '/teachers', label: '👩‍🏫 Teachers' },
  { to: '/classes',  label: '🏫 Classes' },
  { to: '/subjects', label: '📚 Subjects' }
]
</script>

<template>
  <aside class="sidebar">
    <div class="brand">🏫 SSMS</div>
    <nav>
      <RouterLink v-for="l in links" :key="l.to" :to="l.to">{{ l.label }}</RouterLink>
    </nav>
    <div class="foot">
      <small>{{ auth.userName }}</small>
      <small class="role">{{ auth.userRole }}</small>
    </div>
  </aside>
</template>

<style scoped>
.sidebar {
  width: 220px; background: #0f172a; color: #cbd5e1;
  display: flex; flex-direction: column; padding: 1rem 0;
}
.brand { font-size: 1.15rem; font-weight: 700; padding: 0 1.25rem 1rem; color: white; }
nav { display: flex; flex-direction: column; flex: 1; }
nav a {
  color: #cbd5e1; text-decoration: none; padding: .7rem 1.25rem;
  font-size: .9rem; border-left: 3px solid transparent;
}
nav a:hover { background: #1e293b; color: white; }
nav a.router-link-exact-active { background: #1e293b; color: white; border-left-color: #38bdf8; }
.foot { padding: .75rem 1.25rem; border-top: 1px solid #1e293b; display: flex; flex-direction: column; }
.foot small { font-size: .8rem; }
.role { color: #64748b; text-transform: capitalize; }
</style>
