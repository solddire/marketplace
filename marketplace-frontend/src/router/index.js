import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../views/HomePage.vue';
import LoginPage from '../views/LoginPage.vue';
import RegisterPage from '../views/RegisterPage.vue';
import EmailVerify from '../views/EmailVerify.vue';
import EmailVerification from '@/views/EmailVerification.vue';
import ResetPassword from '@/views/ResetPassword.vue';
// import DashboardPage from '../views/DashboardPage.vue';

const routes = [
  { path: '/', component: HomePage, name: 'home', meta: { title: 'Главная страница' }, },
  { path: '/login', component: LoginPage, name: 'login', meta: { title: 'Вход' }, },
  { path: '/register', component: RegisterPage, name: 'register', meta: { title: 'Регистрация' }, },
  { path: '/email/verify', component: EmailVerification, name: 'email-verify', meta: { title: 'Подтверждение почты' }, },
  { path: '/password-reset/:token', component: ResetPassword, name: 'password-reset', meta: { title: 'Сброс пароля' }, },
  // { path: '/dashboard', component: DashboardPage, name: 'dashboard' },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
