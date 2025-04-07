import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../views/HomePage.vue';
import LoginPage from '../views/LoginPage.vue';
import RegisterPage from '../views/RegisterPage.vue';
import EmailVerify from '../views/EmailVerify.vue';
import EmailVerification from '@/views/EmailVerification.vue';
import ResetPassword from '@/views/ResetPassword.vue';
import ProfilePage from '@/views/ProfilePage.vue';
import MyAds from '@/views/MyAds.vue';
import CreateAd from '@/views/CreateAd.vue';
// import DashboardPage from '../views/DashboardPage.vue';

const routes = [
  { path: '/', component: HomePage, name: 'home', meta: { title: 'Главная страница' }, },
  { path: '/login', component: LoginPage, name: 'login', meta: { title: 'Вход' }, },
  { path: '/register', component: RegisterPage, name: 'register', meta: { title: 'Регистрация' }, },
  { path: '/email/verify', component: EmailVerification, name: 'email-verify', meta: { title: 'Подтверждение почты' }, },
  { path: '/password-reset/:token', component: ResetPassword, name: 'password-reset', meta: { title: 'Сброс пароля' }, },
  { path: '/profile', component: ProfilePage, name: 'profile', meta: { title: 'Мой профиль', requiresAuth: true }, },
  { path: '/my-ads', component: MyAds, name: 'ads', meta: { title: 'Мои обьявления', requiresAuth: true }, },
  { path: '/create-ad', component: CreateAd, name: 'create-ad', meta: { title: 'Добавить обьявление', requiresAuth: true }, },
  // { path: '/dashboard', component: DashboardPage, name: 'dashboard' },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
