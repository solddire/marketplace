<template>
    <div>
        <h1>Подтверждение почты</h1>
        <p v-if="loading">Пожалуйста, подождите...</p>
        <p v-if="error">{{ error }}</p>
        <p v-if="success">Ваш email успешно подтвержден!</p>
    </div>
</template>

<script>
import axios from '../axios';

export default {
    data() {
        return {
            loading: true,
            success: false,
            error: null,
        };
    },
    async created() {
        const urlParams = new URLSearchParams(window.location.search);
        const verifyUrl = urlParams.get("verify_url");
        const token = localStorage.getItem('token');

        if (verifyUrl) {
            try {
                const response = await axios.get(verifyUrl, {
                    headers: {
                    'Authorization': `Bearer ${token}`,
                    },
                    withCredentials: true,
                });
                setTimeout(() => {
                    this.$router.push({ name: 'home' });
                }, 5000);
                this.success = true;
            } catch (err) {
                this.error = "Не удалось подтвердить email. Попробуйте снова.";
            } finally {
                this.loading = false;
            }
        } else {
            this.error = "Неверный URL подтверждения.";
            this.loading = false;
        }
    },
};
</script>