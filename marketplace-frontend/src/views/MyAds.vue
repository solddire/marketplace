<template>
    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Мои объявления</h1>

        <div v-if="loading" class="text-gray-500">Загрузка...</div>

        <div v-else>
            <div v-if="ads.length > 0" class="grid md:grid-cols-2 gap-4">
                <div v-for="ad in ads" :key="ad.id" class="border rounded-lg p-4 shadow-sm hover:shadow-md transition">
                    <h2 class="text-xl font-semibold">{{ ad.title }}</h2>
                    <p class="text-gray-700 mt-1">{{ ad.description }}</p>
                    <p v-if="ad.price" class="mt-2 text-blue-600 font-medium">{{ ad.price }} ₽</p>
                </div>
            </div>

            <div v-else class="text-center mt-10">
                <p class="text-gray-600 mb-4">У вас пока нет объявлений.</p>
                <router-link to="/create-ad">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Создать
                        объявление</button>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios';

const ads = ref([])
const loading = ref(true)

onMounted(async () => {
    try {
        const response = await axios.get('/api/ads') // 👈 адаптируй, если роут другой
        ads.value = response.data
    } catch (error) {
        console.error('Ошибка загрузки объявлений:', error)
    } finally {
        loading.value = false
    }
})
</script>

<style scoped>
/* необязательные стили */
</style>