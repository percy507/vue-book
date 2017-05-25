<template>
    <div id="app">
        <loading></loading>
        <vLogin></vLogin>
        <vMenu></vMenu>
        <vHelp></vHelp>
        <vBookList></vBookList>
        <vContainer></vContainer>
    </div>
</template>

<script>
import vLogin from './components/login.vue';
import vMenu from './components/menu.vue';
import vContainer from './components/container.vue';
import loading from './components/loading.vue';
import vHelp from './components/help.vue';
import vBookList from './components/book-list.vue';

export default {
    name: 'app',
    components: {
        loading,
        vLogin,
        vMenu,
        vContainer,
        vHelp,
        vBookList
    },
    created: function () {

    }
}


// 万能脚本，自动屏蔽 pc
window.addEventListener('DOMContentLoaded', function () {
    if (!((/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i).test(navigator.userAgent))) {
        document.documentElement.innerHTML = "<p>请使用手机微信打开此页面哦~</p>";
    }
});
</script>
    
<style>
html,
body,
#app {
    height: 100%;
}

body {
    margin: 0;
}








/* 设置全屏模式下 body 的宽度高度 */

body:-webkit-full-screen {
    width: 100vw;
    height: 100vh;
}

body:-moz-full-screen {
    width: 100vw;
    height: 100vh;
}

body:-ms-fullscreen {
    width: 100vw;
    height: 100vh;
}

body:fullscreen {
    width: 100vw;
    height: 100vh;
}

#app {
    position: relative;
    left: 0;
    z-index: 5;
    width: 100%;
    height: 100%;
    background: #FFF;
    max-width: 800px;
    min-width: 300px;
    margin: 0 auto;
    overflow: hidden;
}
</style>