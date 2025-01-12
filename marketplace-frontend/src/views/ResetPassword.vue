<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                alt="Your Company">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
                Установите новый пароль
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="resetPassword">
                <div>
                    <label for="password" class="block text-sm/6 font-medium text-gray-900">Новый пароль</label>
                    <div class="mt-2">
                        <input v-model="password" type="password" name="password" id="password"
                            autocomplete="new-password" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Подтвердите
                        новый пароль</label>
                    <div class="mt-2">
                        <input v-model="passwordConfirmation" type="password" name="password_confirmation"
                            id="password_confirmation" autocomplete="new-password" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Сбросить пароль
                    </button>
                </div>

                <div v-if="message" class="text-sm text-green-600 text-center mt-4">
                    {{ message }}
                </div>
                <div v-if="error" class="text-sm text-red-600 text-center mt-4">
                    {{ error }}
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "../axios";

export default {
    data() {
        return {
            password: "",
            passwordConfirmation: "",
            email: null,
            token: null,
            message: null,
            error: null,
        };
    },
    async created() {
        const urlParams = new URLSearchParams(window.location.search);
        this.email = urlParams.get("email");

        const pathParts = window.location.pathname.split("/");
        this.token = pathParts[pathParts.length - 1];

        if (!this.email || !this.token) {
            this.error = "Неверная ссылка для сброса пароля.";
        }
    },
    methods: {
        async resetPassword() {
            if (this.password !== this.passwordConfirmation) {
                this.error = "Пароли не совпадают.";
                return;
            }

            try {
                await axios.post("http://localhost:8000/reset-password", {
                    email: this.email,
                    token: this.token,
                    password: this.password,
                    password_confirmation: this.passwordConfirmation,
                });

                this.message = "Пароль успешно сброшен. Вы можете войти с новым паролем.";
                this.error = null;

                setTimeout(() => {
                    this.$router.push({ name: "login" });
                }, 5000);
            } catch (error) {
                this.error = "Произошла ошибка при сбросе пароля. Попробуйте снова.";
                this.message = null;
            }
        },
    },
};
</script>