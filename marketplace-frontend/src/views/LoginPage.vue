<template>
    <div>
      <h1>Вход</h1>
      <form @submit.prevent="login">
        <input v-model="email" type="email" placeholder="Email" />
        <input v-model="password" type="password" placeholder="Пароль" />
        <button type="submit">Войти</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from '../axios';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async login() {
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/api/login', { email: this.email, password: this.password });
        this.$router.push({ name: 'dashboard' });
      },
    },
  };
  </script>
  