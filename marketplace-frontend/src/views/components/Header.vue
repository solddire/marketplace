<template>
    <div class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
        <div class="container mx-auto flex items-center justify-between px-4 py-2">
            <!-- Логотип -->
            <div class="flex items-center mr-5">
                <a href="/" class="text-2xl font-bold text-blue-600">Avito</a>
            </div>

            <!-- Выпадающий список Все категории -->
            <div class="relative">
                <button @click="toggleCategories"
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none">
                    Все категории
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Список категорий и подкатегорий -->
                <div v-if="showCategories" class="absolute left-0 w-96 bg-white border rounded-lg shadow-lg mt-2 z-10">
                    <div class="flex">
                        <!-- Список категорий -->
                        <ul class="w-1/3 border-r">
                            <li v-for="category in categories" :key="category.id" @click="selectCategory(category.slug)"
                                class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                                {{ category.name }}
                            </li>
                        </ul>


                        <ul class="w-2/3">
                            <li v-for="subcategory in subcategories" :key="subcategory.id"
                                class="px-4 py-2 hover:bg-gray-100">
                                {{ subcategory.name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Поисковая строка -->
            <div class="flex flex-grow items-center mx-4">
                <input v-model="searchQuery" type="text" placeholder="Поиск..."
                    class="flex-grow px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button @click="search" class="px-4 py-2 text-white bg-blue-600 rounded-r-md hover:bg-blue-700">
                    Найти
                </button>
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
                <div v-if="showRegions" class="absolute right-0 w-64 bg-white border rounded-lg shadow-lg mt-2 z-10">
                    <ul>
                        <li v-for="region in regions" :key="region" @click="selectRegion(region)"
                            class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                            {{ region }}
                        </li>
                    </ul>
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
            showCategories: false,
            showRegions: false,
            selectedCategory: null,
            selectedSubcategory: null,
            selectedRegion: "Москва",
            searchQuery: "",
            categories: [],
            subcategories: [],
            regions: ["Москва", "Санкт-Петербург", "Новосибирск", "Екатеринбург"],
        };
    },
    methods: {
        toggleCategories() {
            this.showCategories = !this.showCategories;
            this.showRegions = false;
        },
        async selectCategory(categorySlug) {
            this.selectedCategory = categorySlug;
            await this.fetchSubcategories();
        },
        async fetchCategories() {
            try {
                const response = await axios.get('/api/categories');
                this.categories = response.data;
            } catch (error) {
                console.error("Ошибка при загрузке категорий:", error);
            }
        },
        async fetchSubcategories() {
            try {
                const response = await axios.get(`/api/categories/${this.selectedCategory}/subcategories`);
                this.subcategories = response.data;
            } catch (error) {
                console.error("Ошибка при загрузке подкатегорий:", error);
            }
        },
        toggleRegions() {
            this.showRegions = !this.showRegions;
            this.showCategories = false;
        },
        selectRegion(region) {
            this.selectedRegion = region;
            this.showRegions = false;
        },
        search() {
            alert(`Ищем: ${this.searchQuery}`);
        },
    },
    mounted() {
        this.fetchCategories();
    },
};
</script>

<style scoped>
.container {
    max-width: 1200px;
}
</style>
