<template>
  <Header />
  <div class="mt-12 container">
    <h1 class="text-3xl font-bold">Добро пожаловать в Аналог Авито</h1>
  </div>
  <CategorySelector />
</template>

<script>
import axios from '../axios';
import CategorySelector from './components/CategorySelector.vue';

export default {
  data() {
    return {
    };
  },
  components: {
    CategorySelector
  },
};
</script>
<style scoped>
.container {
  max-width: 1200px;
}
</style>
