import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './router/routes.js'; // 引入路由配置
import store from './vuex/store.js';
import App from './app.vue';
import 'normalize.css';
import './fonts/font.css';

Vue.use(VueRouter);

const router = new VueRouter({
    routes
});

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');