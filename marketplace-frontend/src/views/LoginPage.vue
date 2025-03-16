<template>
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
        alt="Your Company">
      <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
        {{ isForgotPassword ? 'Сбросить пароль' : 'Вход' }}
      </h2>
    </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent="handleSubmit">
        <div>
          <label for="email" class="block text-sm/6 font-medium text-gray-900">E-mail</label>
          <div class="mt-2">
            <input v-model="email" type="email" name="email" id="email" autocomplete="email" required
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
              :class="{ 'outline-red-500': errorMessage }" />
          </div>
        </div>
        <div v-if="!isForgotPassword">
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-gray-900">Пароль</label>
            <div class="text-sm">
              <a href="#" @click.prevent="isForgotPassword = true"
                class="font-semibold text-indigo-600 hover:text-indigo-500">Забыли пароль?</a>
            </div>
          </div>
          <div class="mt-2">
            <input v-model="password" type="password" name="password" id="password" autocomplete="current-password"
              required
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
              :class="{ 'outline-red-500': errorMessage }" />
          </div>
          <p v-if="errorMessage" class="text-red-500 text-xs">{{ errorMessage }}</p>
        </div>
        <div>
          <button type="submit"
            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            {{ isForgotPassword ? 'Сбросить пароль' : 'Войти' }}
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm/6 text-gray-500">
        Еще не зарегистрированы?
        <a href="/register" class="font-semibold text-indigo-600 hover:text-indigo-500">Зарегистрироваться</a>
      </p>
    </div>
  </div>
</template>

<script>
import axios from '../axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      isForgotPassword: false,
      errorMessage: '',
    };
  },
  methods: {
    handleSubmit() {
      if (this.isForgotPassword) {
        this.resetPassword();
      } else {
        this.login();
      }
    },
    async login() {
      try {
        const response = await axios.post('/api/login', { email: this.email, password: this.password });
        localStorage.setItem('token', response.data.token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
        this.$router.push({ name: 'home' });
      } catch (error) {
        this.errorMessage = 'Неверные данные для входа!';
      }
    },

    async resetPassword() {
      try {
        await axios.post('/forgot-password', { email: this.email });
        this.success = 'Ссылка для сброса пароля отправлена на вашу почту.';
      } catch (error) {
        this.errorMessage = 'Произошла ошибка. Попробуйте снова!';
      }
    },
  },
};
</script>
