import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../views/HomePage.vue';
import LoginPage from '../views/LoginPage.vue';
import RegisterPage from '../views/RegisterPage.vue';
import EmailVerify from '../views/EmailVerify.vue';
// import DashboardPage from '../views/DashboardPage.vue';

const routes = [
  { path: '/', component: HomePage, name: 'home' },
  { path: '/login', component: LoginPage, name: 'login' },
  { path: '/register', component: RegisterPage, name: 'register' },
  { path: '/email-verify', component: EmailVerify, name: 'email-verify' },
  // { path: '/dashboard', component: DashboardPage, name: 'dashboard' },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
