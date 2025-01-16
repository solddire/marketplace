<template>
    <div>
        <label>Категория:</label>
        <select v-model="selectedCategory" @change="fetchSubcategories">
            <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
            </option>
        </select>

        <label v-if="subcategories.length">Подкатегория:</label>
        <select v-if="subcategories.length" v-model="selectedSubcategory">
            <option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">
                {{ subcategory.name }}
            </option>
        </select>
    </div>
</template>

<script>
import axios from '../../axios';

export default {
    data() {
        return {
            categories: [],
            subcategories: [],
            selectedCategory: null,
            selectedSubcategory: null,
        };
    },
    methods: {
        async fetchCategories() {
            const response = await axios.get('/api/categories');
            this.categories = response.data;
        },
        async fetchSubcategories() {
            const response = await axios.get(`/api/categories/${this.selectedCategory}/subcategories`);
            this.subcategories = response.data;
            this.selectedSubcategory = null;
        },
    },
    mounted() {
        this.fetchCategories();
    },
};
</script>