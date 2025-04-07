<template>
    <div class="max-w-3xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Создать объявление</h1>

        <form @submit.prevent="createAd" class="space-y-6">
            <div>
                <label class="block text-sm font-medium">Заголовок</label>
                <input v-model="form.title" type="text" class="w-full border rounded px-3 py-2 mt-1" required />
            </div>

            <div>
                <label class="block text-sm font-medium">Описание</label>
                <textarea v-model="form.description" class="w-full border rounded px-3 py-2 mt-1" rows="4"
                    required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Цена (₽)</label>
                <input v-model="form.price" type="number" min="0" class="w-full border rounded px-3 py-2 mt-1" />
            </div>

            <div>
                <label class="block text-sm font-medium">Категория</label>
                <select v-model="form.category_id" @change="loadSubcategories"
                    class="w-full border rounded px-3 py-2 mt-1" required>
                    <option value="" disabled selected>Выберите категорию</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                    </option>
                </select>
            </div>

            <div v-if="subcategories.length">
                <label class="block text-sm font-medium">Подкатегория</label>
                <select v-model="form.subcategory_id" class="w-full border rounded px-3 py-2 mt-1">
                    <option value="" disabled selected>Выберите подкатегорию</option>
                    <option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">
                        {{ subcategory.name }}
                    </option>
                </select>
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Создать
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios';
import { useRouter } from 'vue-router'

const router = useRouter()

const form = ref({
    title: '',
    description: '',
    price: null,
    category_id: '',
    subcategory_id: ''
})

const categories = ref([])
const subcategories = ref([])

onMounted(async () => {
    try {
        const response = await axios.get('/api/categories')
        categories.value = response.data
    } catch (error) {
        console.error('Ошибка загрузки категорий:', error)
    }
})

const loadSubcategories = async () => {
    if (!form.value.category_id) return

    try {
        const response = await axios.get(`/api/categories/${form.value.category_id}/subcategories`)
        subcategories.value = response.data
    } catch (error) {
        console.error('Ошибка загрузки подкатегорий:', error)
    }
}

const createAd = async () => {
    try {
        await axios.post('/api/ads', form.value)
        router.push('/my-ads')
    } catch (error) {
        console.error('Ошибка создания объявления:', error)
        alert('Ошибка при создании объявления')
    }
}
</script>