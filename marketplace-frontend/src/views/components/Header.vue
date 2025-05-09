<template>
    <div class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-4 py-2">
            <div class="flex items-center justify-between">
                <!-- Логотип -->
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-600">Vendo</a>
                </div>

                <!-- Поисковая строка -->
                <div class="flex-grow mx-4">
                    <div class="flex">
                        <input v-model="searchQuery" type="text" placeholder="Поиск..."
                            class="flex-grow px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <button @click="search" class="px-4 py-2 text-white bg-blue-600 rounded-r-md hover:bg-blue-700">
                            Найти
                        </button>
                    </div>
                </div>

                <!-- Выбор региона -->
                <div class="relative">
                    <button @click="toggleRegions"
                        class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none">
                        {{ selectedRegion }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Список регионов -->
                    <div v-if="showRegions" class="absolute left-n65p w-64 bg-white border rounded-lg shadow-lg mt-2 z-10">
                        <ul>
                            <li v-for="region in regions" :key="region" @click="selectRegion(region)"
                                class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                                {{ region }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Профиль (десктопная версия) -->
                <div class="hidden md:flex items-center ml-4 relative" ref="dropdownRef">
                    <div @click="showDropdown = !showDropdown" class="flex items-center space-x-2 cursor-pointer text-gray-700 hover:text-blue-600">
                        <template v-if="loading">
                            <div class="flex items-center space-x-2">
                                <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                </svg>
                                <span class="text-sm font-medium">Загрузка...</span>
                            </div>
                        </template>
                        <template v-else>
                            <img :src="defaultAvatar" alt="Аватар" class="w-8 h-8 rounded-full">
                            <span class="text-sm font-medium">{{ userName }}</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </template>
                    </div>
                    <!-- Выпадающее меню -->
                    <div v-if="showDropdown"
                        class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50 top-34px left-n8px">
                        <router-link to="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Профиль</router-link>
                        <router-link to="/my-ads" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Мои объявления</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from '../../axios';

export default {
    data() {
        return {
            showRegions: false,
            selectedRegion: "Москва",
            showDropdown: false,
            searchQuery: "",
            regions: ["Москва", "Санкт-Петербург", "Новосибирск", "Екатеринбург"],
            userName: "Пользователь",
            userPhoto: null,
            loading: true
        };
    },
    computed: {
        defaultAvatar() {
            return this.userPhoto || `https://ui-avatars.com/api/?name=${encodeURIComponent(this.userName || 'User')}&size=40`;
        }
    },
    methods: {
        toggleRegions() {
            this.showRegions = !this.showRegions;
        },
        selectRegion(region) {
            this.selectedRegion = region;
            this.showRegions = false;
        },
        search() {
            alert(`Ищем: ${this.searchQuery}`);
        },
        async fetchUserData() {
            try {
                this.loading = true;
                const response = await axios.get('/api/user');
                const userData = response.data;
                this.userName = userData.first_name + ' ' + userData.last_name;
                this.userPhoto = userData.avatar;
            } catch (error) {
                console.error('Ошибка при получении данных пользователя:', error);
            } finally {
                this.loading = false;
            }
        }
    },
    mounted() {
        const token = localStorage.getItem('token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            this.fetchUserData();
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 1200px;
}
</style>
