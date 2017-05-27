import Vue from 'vue';
import VueRouter from 'vue-router';
import VueLazyload from 'vue-lazyload';
import routes from './router/routes.js'; // 引入路由配置
import store from './vuex/store.js';
import App from './app.vue';
import 'normalize.css';
import './common/loading.gif';
import './common/error.png';

// 为了方便遍历，这里为一些类数组对象注册数组的 forEach 方法
NodeList.prototype.forEach = Array.prototype.forEach;
Storage.prototype.forEach = Array.prototype.forEach;

// 万能脚本，自动屏蔽 pc
window.addEventListener('DOMContentLoaded', function() {
    if (!((/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i).test(navigator.userAgent))) {
        document.documentElement.innerHTML = "<p>请使用手机打开此页面哦~</p>";
    }
});

Vue.use(VueRouter);

Vue.use(VueLazyload, {
    preLoad: 1.3,
    error: './public/error.png',
    loading: './public/loading.gif',
    attempt: 1
});

const router = new VueRouter({
    routes
});

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');


/*
// 通用的关闭页面时提示，对微信内置浏览器无效
window.addEventListener("beforeunload", function() {
    var message = "你真的要离开吗？";
    event.returnValue = message;
    return message;
}, false);
*/