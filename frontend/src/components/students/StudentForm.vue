<script setup>
import { ref, watch } from 'vue'
import { Save, X } from 'lucide-vue-next'

const props = defineProps({
  student: {
    type: Object,
    default: null
  },
  loading: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['submit', 'cancel'])

const form = ref({
  first_name: '',
  last_name: '',
  date_of_birth: '',
  gender: 'male',
  address: '',
  guardian_name: '',
  guardian_phone: '',
  grade_level: 9,
  section: 'A',
  enrollment_date: new Date().toISOString().split('T')[0],
})

watch(() => props.student, (newVal) => {
  if (newVal) {
    form.value = { ...form.value, ...newVal }
  }
}, { immediate: true })

function handleSubmit() {
  emit('submit', form.value)
}
</script>

<template>
  <form @submit.prevent="handleSubmit" class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
      <h2 class="text-lg font-bold text-gray-800 mb-4">Personal Information</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
          <input v-model="form.first_name" type="text" required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
          <input v-model="form.last_name" type="text" required
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
          <input v-model="form.date_of_birth" type="date" required class="w-full px-4 py-2 border rounded-lg" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Gender *</label>
          <select v-model="form.gender" class="w-full px-4 py-2 border rounded-lg">
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
          <textarea v-model="form.address" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
      <h2 class="text-lg font-bold text-gray-800 mb-4">Guardian Information</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Name *</label>
          <input v-model="form.guardian_name" type="text" required class="w-full px-4 py-2 border rounded-lg" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Guardian Phone *</label>
          <input v-model="form.guardian_phone" type="text" required placeholder="+251911234567"
            class="w-full px-4 py-2 border rounded-lg" />
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
      <h2 class="text-lg font-bold text-gray-800 mb-4">Academic Information</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level *</label>
          <select v-model="form.grade_level" class="w-full px-4 py-2 border rounded-lg">
            <option v-for="g in [1,2,3,4,5,6,7,8,9,10,11,12]" :key="g" :value="g">Grade {{ g }}</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
          <select v-model="form.section" class="w-full px-4 py-2 border rounded-lg">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Enrollment Date *</label>
          <input v-model="form.enrollment_date" type="date" required class="w-full px-4 py-2 border rounded-lg" />
        </div>
      </div>
    </div>

    <div class="flex gap-3">
      <button type="submit" :disabled="loading"
        class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">
        <Save class="w-4 h-4" />
        {{ loading ? 'Saving...' : 'Save Student' }}
      </button>
      <button type="button" @click="emit('cancel')"
        class="flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
        <X class="w-4 h-4" />
        Cancel
      </button>
    </div>
  </form>
</template>
