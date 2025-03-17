<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Мой профиль</h1>
        
        <div v-if="loading" class="flex justify-center items-center py-8">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        </div>

        <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
          <span class="block sm:inline">{{ error }}</span>
        </div>

        <div v-else class="flex flex-col md:flex-row gap-8">
          <div class="flex flex-col items-center">
            <img 
              :src="defaultAvatar" 
              alt="Аватар пользователя" 
              class="w-32 h-32 rounded-full object-cover border-4 border-gray-200"
            >
            <button 
              @click="showUploadModal = true"
              class="mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors duration-200"
            >
              Изменить фото
            </button>
          </div>

          <div class="flex-1 space-y-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Имя</label>
              <input 
                v-model="userData.name" 
                type="text" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input 
                v-model="userData.email" 
                type="email" 
                disabled
                class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm text-gray-500"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Телефон</label>
              <input 
                v-model="userData.phone" 
                type="tel" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Адрес</label>
              <textarea 
                v-model="userData.address" 
                rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              ></textarea>
            </div>

            <button 
              @click="saveProfile" 
              :disabled="saving"
              class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {{ saving ? 'Сохранение...' : 'Сохранить изменения' }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <UploadPhotoModal 
      :show="showUploadModal"
      @close="showUploadModal = false"
      @photo-uploaded="handlePhotoUploaded"
    />
  </div>
</template>

<script>
import axios from '../axios';
import UploadPhotoModal from '../components/UploadPhotoModal.vue';

export default {
  name: 'ProfilePage',
  components: {
    UploadPhotoModal
  },
  data() {
    return {
      userData: {
        name: '',
        email: '',
        phone: '',
        address: '',
        avatar: ''
      },
      loading: true,
      saving: false,
      error: null,
      showUploadModal: false
    }
  },
  computed: {
    defaultAvatar() {
      return this.userData.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(this.userData.name || 'User')}&size=128`;
    }
  },
  methods: {
    handlePhotoUploaded(avatarUrl) {
      this.userData.avatar = avatarUrl;
    },
    async fetchProfile() {
      try {
        this.loading = true;
        this.error = null;
        const response = await axios.get('/api/user');
        const user = response.data;
        
        // Формируем полное имя
        this.userData = {
          name: `${user.first_name} ${user.last_name}`,
          email: user.email,
          phone: user.phone,
          address: user.address,
          avatar: user.avatar
        };
      } catch (error) {
        if (error.response && error.response.status === 401) {
          this.$router.push('/login');
          return;
        }
        this.error = 'Ошибка при загрузке профиля';
        console.error('Ошибка при загрузке профиля:', error);
      } finally {
        this.loading = false;
      }
    },
    async saveProfile() {
      try {
        this.saving = true;
        this.error = null;
        
        // Разделяем полное имя на имя и фамилию
        const nameParts = this.userData.name.split(' ');
        const firstName = nameParts[0];
        const lastName = nameParts.slice(1).join(' ');

        await axios.put('/api/profile', {
          name: this.userData.name,
          phone: this.userData.phone,
          address: this.userData.address
        });
        this.$toast.success('Профиль успешно обновлен');
      } catch (error) {
        if (error.response && error.response.status === 401) {
          this.$router.push('/login');
          return;
        }
        this.error = 'Ошибка при сохранении профиля';
        console.error('Ошибка при сохранении профиля:', error);
      } finally {
        this.saving = false;
      }
    }
  },
  async created() {
    await this.fetchProfile();
  }
}
</script> 