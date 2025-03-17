<template>
  <div v-if="show" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Загрузка фотографии</h3>
        <button @click="$emit('close')" class="text-gray-400 hover:text-gray-500">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="mb-4">
        <div class="flex items-center justify-center w-full">
          <label class="w-full flex flex-col items-center px-4 py-6 bg-white rounded-lg shadow-lg tracking-wide border border-blue-500 cursor-pointer hover:bg-blue-500 hover:text-white">
            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1z" />
            </svg>
            <span class="mt-2 text-base">Выберите фото</span>
            <input type="file" class="hidden" accept="image/*" @change="handleFileChange" ref="fileInput">
          </label>
        </div>
      </div>

      <div v-if="preview" class="mb-4">
        <img :src="preview" class="max-h-48 mx-auto rounded-lg" alt="Preview">
      </div>

      <div class="flex justify-end space-x-3">
        <button 
          @click="$emit('close')" 
          class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none"
        >
          Отмена
        </button>
        <button 
          @click="uploadPhoto" 
          :disabled="!selectedFile || uploading"
          class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ uploading ? 'Загрузка...' : 'Загрузить' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '../axios';

export default {
  name: 'UploadPhotoModal',
  props: {
    show: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      selectedFile: null,
      preview: null,
      uploading: false
    }
  },
  methods: {
    handleFileChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.selectedFile = file;
        // Создаем превью
        const reader = new FileReader();
        reader.onload = e => {
          this.preview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    async uploadPhoto() {
      if (!this.selectedFile) return;

      try {
        this.uploading = true;
        const formData = new FormData();
        formData.append('avatar', this.selectedFile);

        const response = await axios.post('/api/profile/avatar', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        this.$emit('photo-uploaded', response.data.avatar);
        this.$emit('close');
      } catch (error) {
        if (error.response && error.response.status === 401) {
          // Если пользователь не авторизован, перенаправляем на страницу входа
          this.$router.push('/login');
          return;
        }
        console.error('Ошибка при загрузке фото:', error);
      } finally {
        this.uploading = false;
      }
    }
  }
}
</script> 