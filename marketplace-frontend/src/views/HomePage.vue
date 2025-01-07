<template>
  <div>
    <h1 class="text-3xl font-bold">Добро пожаловать в Маркетплейс Услуг</h1>
    <input
      v-model="query"
      @input="search"
      class="border p-2 mt-4"
      placeholder="Искать услуги..."
    />
    <ul v-if="results.length">
      <li v-for="result in results" :key="result.id">{{ result.name }}</li>
    </ul>
  </div>
</template>

<script>
import axios from '../axios';

export default {
  data() {
    return {
      query: '',
      results: [],
    };
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
