<template>
    <div>
        <h1>Регистрация</h1>
        <form @submit.prevent="register">
            <div>
                <input v-model="firstName" type="text" placeholder="Имя" class="border p-2 mb-2 text-black" />
            </div>
            <div>
                <input v-model="secondName" type="text" placeholder="Фамилия" class="border p-2 mb-2 text-black" />
            </div>
            <div>
                <input v-model="email" type="email" placeholder="Email" class="border p-2 mb-2 text-black" />
            </div>
            <div>
                <input v-model="phone" type="text" placeholder="+7 (999) 123-45-67" class="border p-2 mb-2 text-black"
                    :class="{ 'border-red-500': phoneError }" />
                <p v-if="phoneError" class="text-red-500 text-xs">Некорректный номер телефона.</p>
            </div>
            <div>
                <input v-model="password" type="password" placeholder="Пароль" class="border p-2 mb-2 text-black"
                    :class="{ 'border-red-500': passwordError }" />
                <p v-if="passwordError" class="text-red-500 text-xs">Пароль слишком слабый.</p>
            </div>
            <div>
                <input v-model="passwordConfirmation" type="password" placeholder="Подтверждение пароля"
                    class="border p-2 mb-2 text-black" :class="{ 'border-red-500': passwordMatchError }" />
                <p v-if="passwordMatchError" class="text-red-500 text-xs">Пароли не совпадают.</p>
            </div>
            <button type="submit" :disabled="isSubmitDisabled" class="bg-blue-500 text-white p-2 mt-4">
                Зарегистрироваться
            </button>
        </form>
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
        },
        validatePassword(password) {
            const regex = /^[a-zA-Z0-9]+$/;
            return regex.test(password);
        },
        validatePasswordMatch() {
            this.passwordMatchError = this.password !== this.passwordConfirmation;
        },
        async register() {
            // Проводим валидацию
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

                this.$router.push({ name: "email-verify" });
            } catch (error) {
                console.error("Registration error:", error.response.data);
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