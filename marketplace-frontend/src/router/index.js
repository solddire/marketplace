import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../views/HomePage.vue';
import LoginPage from '../views/LoginPage.vue';
// import DashboardPage from '../views/DashboardPage.vue';

const routes = [
  { path: '/', component: HomePage, name: 'home' },
  { path: '/login', component: LoginPage, name: 'login' },
  // { path: '/dashboard', component: DashboardPage, name: 'dashboard' },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
