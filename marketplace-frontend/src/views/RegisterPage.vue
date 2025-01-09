<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                alt="Your Company">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Регистрация</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-4" @submit.prevent="register">
                <div>
                    <label for="firstName" class="block text-sm/6 font-medium text-gray-900">Имя</label>
                    <div class="mt-2">
                        <input v-model="firstName" type="text" name="firstName" id="firstName" autocomplete="given-name"
                            required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <label for="secondName" class="block text-sm/6 font-medium text-gray-900">Фамилия</label>
                    <div class="mt-2">
                        <input v-model="secondName" type="text" name="secondName" id="secondName"
                            autocomplete="family-name" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">E-mail</label>
                    <div class="mt-2">
                        <input v-model="email" type="email" name="email" id="email" autocomplete="email" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            :class="{ 'outline-red-500': emailUnique }"/>
                        <p v-if="emailUnique" class="text-red-500 text-xs">Почта уже зарегистрирована!</p>
                    </div>
                </div>
                <div>
                    <label for="phone" class="block text-sm/6 font-medium text-gray-900">Номер телефона</label>
                    <div class="mt-2">
                        <input v-model="phone" type="tel" name="phone" id="phone" autocomplete="phone" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            :class="{ 'outline-red-500': phoneError || phoneUnique }" />
                        <p v-if="phoneUnique" class="text-red-500 text-xs">Номер телефона уже зарегистрирован!</p>
                        <p v-if="phoneError" class="text-red-500 text-xs">Некорректный номер телефона.</p>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Пароль</label>
                    </div>
                    <div class="mt-2">
                        <input v-model="password" type="password" name="password" id="password"
                            autocomplete="current-password" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            :class="{ 'outline-red-500': passwordError }" />
                        <p v-if="passwordError" class="text-red-500 text-xs">Пароль слишком слабый.</p>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="passwordConfirmation"
                            class="block text-sm/6 font-medium text-gray-900">Подтверждение пароля</label>
                    </div>
                    <div class="mt-2">
                        <input v-model="passwordConfirmation" type="password" name="passwordConfirmation"
                            id="passwordConfirmation" autocomplete="current-password" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            :class="{ 'outline-red-500': passwordMatchError }" />
                        <p v-if="passwordMatchError" class="text-red-500 text-xs">Пароли не совпадают.</p>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "../axios";
import { isValidPhoneNumber } from "libphonenumber-js";

export default {
    data() {
        return {
            firstName: "",
            secondName: "",
            email: "",
            phone: "",
            password: "",
            passwordConfirmation: "",
            phoneError: false,
            passwordError: false,
            passwordMatchError: false,
            emailUnique: false,
            phoneUnique: false,
        };
    },
    computed: {
        isSubmitDisabled() {
            return (
                this.phoneError ||
                this.passwordError ||
                this.passwordMatchError ||
                !this.firstName ||
                !this.secondName ||
                !this.email ||
                !this.phone ||
                !this.password ||
                !this.passwordConfirmation
            );
        },
    },
    methods: {
        validatePhone() {
            const phoneIsValid = isValidPhoneNumber(this.phone, 'RU');
            this.phoneError = !phoneIsValid;
            this.phoneUnique = false;
        },
        validatePassword(password) {
            const regex = /^[a-zA-Z0-9]+$/;
            return regex.test(password);
        },
        validatePasswordMatch() {
            this.passwordMatchError = this.password !== this.passwordConfirmation;
        },
        async register() {
            this.validatePhone();
            this.validatePassword();
            this.validatePasswordMatch();

            if (
                this.phoneError ||
                this.passwordError ||
                this.passwordMatchError
            ) {
                return;
            }

            try {
                const response = await axios.post("/api/register", {
                    first_name: this.firstName,
                    last_name: this.secondName,
                    email: this.email,
                    phone: this.phone,
                    password: this.password,
                    password_confirmation: this.passwordConfirmation,
                });

                await axios.post('/api/email/verification-notification', {}, {
                    headers: {
                        'Authorization': `Bearer ${response.data.token}`,
                    }
                });

                localStorage.setItem('token', response.data.token);

                this.$router.push({ name: "email-verify" });
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    if (error.response.data.errors.email) {
                        this.emailUnique = true;
                    } else {
                        if (error.response.data.errors.phone) {
                            this.emailUnique = false;
                            this.phoneUnique = true;
                        }
                    }
                } else {
                    console.error("Registration error:", error.response.data || error);
                }
            }
        },
    },
    watch: {
        phone() {
            this.validatePhone();
        },
        password() {
            this.validatePassword();
            this.validatePasswordMatch();
        },
        passwordConfirmation() {
            this.validatePasswordMatch();
        },
    },
};
</script>

<style scoped>
/* Tailwind уже подключен */
</style>