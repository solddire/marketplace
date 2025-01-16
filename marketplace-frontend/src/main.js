import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import Header from './views/components/Header.vue';

const headerApp = createApp(Header);
headerApp.mount('#header-root');

const app = createApp(App)

router.afterEach((to) => {
    document.title = to.meta.title || 'Аналог Авито';
});

app.use(createPinia())
app.use(router)

app.mount('#app')
