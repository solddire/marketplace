<template>
    <div>
        <h1>Подтверждение электронной почты</h1>
        <p>Пожалуйста, проверьте свою почту, чтобы подтвердить адрес.</p>
        <button @click="resendVerificationLink">Отправить письмо еще раз</button>
    </div>
</template>

<script>
import axios from '../axios';

export default {
    data() {
        return {};
    },
    methods: {
        async resendVerificationLink() {
            try {
                const response = await axios.post('/api/email/verification-notification', {}, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    }
                });
                alert("Сообщение направлено еще раз!");
            } catch (error) {
                console.error('Ошибка отправки письма:', error.response.data);
            }
        }
    }
};
</script>

<style scoped></style>