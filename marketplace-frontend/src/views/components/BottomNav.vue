<template>
  <nav class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 z-50 md:hidden">
    <div class="flex justify-around items-center h-16">
      <!-- Главная -->
      <router-link to="/" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="text-xs mt-1">Главная</span>
      </router-link>

      <!-- Категории -->
      <button @click="toggleCategories" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <span class="text-xs mt-1">Категории</span>
      </button>

      <!-- Профиль -->
      <router-link to="/profile" class="flex flex-col items-center text-gray-600 hover:text-blue-600">
        <img :src="userPhoto ? userPhoto : defaultAvatar" alt="Avatar" class="w-6 h-6 rounded-full">
        <span class="text-xs mt-1">Профиль</span>
      </router-link>
    </div>

    <!-- Модальное окно категорий -->
    <div v-if="showCategories" class="fixed inset-0 bg-black bg-opacity-50 z-50">
      <div class="bg-white h-full overflow-y-auto">
        <div class="flex justify-between items-center p-4 border-b">
          <h3 class="text-lg font-medium">Категории</h3>
          <button @click="toggleCategories" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="p-4">
          <ul class="space-y-2">
            <li v-for="category in categories" :key="category.id" 
                @click="selectCategory(category.slug)"
                class="p-2 hover:bg-gray-100 rounded-lg cursor-pointer">
              {{ category.name }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import axios from '../../axios';

export default {
  name: 'BottomNav',
  data() {
    return {
      showCategories: false,
      categories: [],
      userPhoto: "",
      userName: "",
    };
  },
  computed: {
    defaultAvatar() {
      return this.userPhoto || `https://ui-avatars.com/api/?name=${encodeURIComponent(this.userName || 'User')}&size=40`;
    }
  },
  methods: {
    toggleCategories() {
      this.showCategories = !this.showCategories;
    },
    async fetchCategories() {
      try {
        const response = await axios.get('/api/categories');
        this.categories = response.data;
      } catch (error) {
        console.error("Ошибка при загрузке категорий:", error);
      }
    },
    async checkAuth() {
      try {
        const response = await axios.get('/api/user');
        if (response.status == 200) {
          this.userName = response.data.first_name + " " + response.data.last_name;
          this.userPhoto = response.data.avatar;
        }
      } catch (error) {
        console.error("Ошибка проверки авторизации", error)
      }
    },
    selectCategory(categorySlug) {
      this.$router.push(`/category/${categorySlug}`);
      this.showCategories = false;
    }
  },
  mounted() {
    this.fetchCategories();
    const token = localStorage.getItem('token');
    if (token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      this.checkAuth();
    }
  }
};
</script> 