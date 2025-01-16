<template>
  <div>
    <h1 class="text-3xl font-bold">Добро пожаловать в Маркетплейс Услуг</h1>
    <input v-model="query" @input="search" class="border p-2 mt-4" placeholder="Искать услуги..." />
    <ul v-if="results.length">
      <li v-for="result in results" :key="result.id">{{ result.name }}</li>
    </ul>
  </div>
  <CategorySelector />
</template>

<script>
import axios from '../axios';
import CategorySelector from './components/CategorySelector.vue';

export default {
  data() {
    return {
      query: '',
      results: [],
    };
  },
  components: {
    CategorySelector 
  },
  methods: {
    async search() {
      if (this.query.length > 2) {
        const { data } = await axios.get(`/search?query=${this.query}`);
        this.results = data;
      }
    },
  },
};
</script>
