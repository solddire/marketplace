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
    </div>
</template>

<script>
export default {
    data() {
        return {
            showRegions: false,
            selectedRegion: "Москва",
            searchQuery: "",
            regions: ["Москва", "Санкт-Петербург", "Новосибирск", "Екатеринбург"],
        };
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
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 1200px;
}
</style>
