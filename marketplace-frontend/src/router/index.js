import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../views/HomePage.vue';
import LoginPage from '../views/LoginPage.vue';
import RegisterPage from '../views/RegisterPage.vue';
import EmailVerify from '../views/EmailVerify.vue';
// import DashboardPage from '../views/DashboardPage.vue';

const routes = [
  { path: '/', component: HomePage, name: 'home', meta: { title: 'Главная страница' }, },
  { path: '/login', component: LoginPage, name: 'login', meta: { title: 'Вход' }, },
  { path: '/register', component: RegisterPage, name: 'register', meta: { title: 'Регистрация' }, },
  { path: '/email-verify', component: EmailVerify, name: 'email-verify', meta: { title: 'Подтверждение почты' }, },
  // { path: '/dashboard', component: DashboardPage, name: 'dashboard' },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
