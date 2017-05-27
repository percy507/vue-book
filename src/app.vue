<template>
    <div id="app">
        <vLogin></vLogin>
        <loading v-if="showLoading"></loading>
        <vContainer v-if="showContainer"></vContainer>
        <vMenu v-if="showMenu"></vMenu>
        <vBookList v-if="user_state"></vBookList>
        <vSetting v-if="user_state"></vSetting>
        <vHelp v-if="showHelp"></vHelp>
    </div>
</template>

<script>
import loading from './components/loading.vue';
import vLogin from './components/login.vue';
import vContainer from './components/container.vue';
import vMenu from './components/menu/menu.vue';
import vBookList from './components/menu/book-list.vue';
import vSetting from './components/menu/setting.vue';
import vHelp from './components/menu/help.vue';

export default {
    name: 'app',
    data: function () {
        return {
            showLoading: false,
            showContainer: false,
            showMenu: false,
            showHelp: false
        };
    },
    computed: {
        user_state: function () {
            return this.$store.state.user_state === 'login_success';
        }
    },
    components: {
        loading,
        vLogin,
        vContainer,
        vMenu,
        vBookList,
        vSetting,
        vHelp
    },
    created: function () {
        setTimeout(() => {
            this.showLoading = true;
        }, 0);
        setTimeout(() => {
            this.showContainer = true;
        }, 0);
        setTimeout(() => {
            this.showMenu = true;
        }, 0);
        setTimeout(() => {
            this.showHelp = true;
        }, 0);
    }
}

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