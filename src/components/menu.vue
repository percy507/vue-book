<template>
    <section class="menu-list">
        <header>
            <img src="data:image/png;base64,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" />
        </header>
        <h1 @click="showLoginPage">{{ user_name }}</h1>
        <ul>
            <!--<li @click="toggleFullScreen"><span>{{ menu_list.full_screen }}</span> </li>-->
            <li v-if="this.user_state === 'login_success'"
                @click="showBookList">
                <svg version="1.1"
                     xmlns="http://www.w3.org/2000/svg"
                     width="32"
                     height="32"
                     viewBox="0 0 32 32">
                    <title>cart</title>
                    <path d="M12 29c0 1.657-1.343 3-3 3s-3-1.343-3-3c0-1.657 1.343-3 3-3s3 1.343 3 3z"></path>
                    <path d="M32 29c0 1.657-1.343 3-3 3s-3-1.343-3-3c0-1.657 1.343-3 3-3s3 1.343 3 3z"></path>
                    <path d="M32 16v-12h-24c0-1.105-0.895-2-2-2h-6v2h4l1.502 12.877c-0.915 0.733-1.502 1.859-1.502 3.123 0 2.209 1.791 4 4 4h24v-2h-24c-1.105 0-2-0.895-2-2 0-0.007 0-0.014 0-0.020l26-3.98z"></path>
                </svg>
                <span>{{ menu_list.book_list }}</span>
            </li>
            <li v-if="this.user_state === 'login_success'">
                <svg version="1.1"
                     xmlns="http://www.w3.org/2000/svg"
                     width="32"
                     height="32"
                     viewBox="0 0 32 32">
                    <title>cog</title>
                    <path d="M29.181 19.070c-1.679-2.908-0.669-6.634 2.255-8.328l-3.145-5.447c-0.898 0.527-1.943 0.829-3.058 0.829-3.361 0-6.085-2.742-6.085-6.125h-6.289c0.008 1.044-0.252 2.103-0.811 3.070-1.679 2.908-5.411 3.897-8.339 2.211l-3.144 5.447c0.905 0.515 1.689 1.268 2.246 2.234 1.676 2.903 0.672 6.623-2.241 8.319l3.145 5.447c0.895-0.522 1.935-0.82 3.044-0.82 3.35 0 6.067 2.725 6.084 6.092h6.289c-0.003-1.034 0.259-2.080 0.811-3.038 1.676-2.903 5.399-3.894 8.325-2.219l3.145-5.447c-0.899-0.515-1.678-1.266-2.232-2.226zM16 22.479c-3.578 0-6.479-2.901-6.479-6.479s2.901-6.479 6.479-6.479c3.578 0 6.479 2.901 6.479 6.479s-2.901 6.479-6.479 6.479z"></path>
                </svg>
                <span>{{ menu_list.setting }}</span>
            </li>
            <li @click="help">
                <svg version="1.1"
                     xmlns="http://www.w3.org/2000/svg"
                     width="32"
                     height="32"
                     viewBox="0 0 32 32">
                    <title>question</title>
                    <path d="M14 22h4v4h-4zM22 8c1.105 0 2 0.895 2 2v6l-6 4h-4v-2l6-4v-2h-10v-4h12zM16 3c-3.472 0-6.737 1.352-9.192 3.808s-3.808 5.72-3.808 9.192c0 3.472 1.352 6.737 3.808 9.192s5.72 3.808 9.192 3.808c3.472 0 6.737-1.352 9.192-3.808s3.808-5.72 3.808-9.192c0-3.472-1.352-6.737-3.808-9.192s-5.72-3.808-9.192-3.808zM16 0v0c8.837 0 16 7.163 16 16s-7.163 16-16 16c-8.837 0-16-7.163-16-16s7.163-16 16-16z"></path>
                </svg>
                <span>{{ menu_list.help }}</span>
            </li>
            <li v-if="this.user_state === 'login_success'"
                @click="logout">
                <svg version="1.1"
                     xmlns="http://www.w3.org/2000/svg"
                     width="32"
                     height="32"
                     viewBox="0 0 32 32">
                    <title>exit</title>
                    <path transform="translate(4,0)"
                          d="M24 20v-4h-10v-4h10v-4l6 6zM22 18v8h-10v6l-12-6v-26h22v10h-2v-8h-16l8 4v18h8v-6z"></path>
                </svg>
                <span>{{ menu_list.logout }}</span>
            </li>
        </ul>
    </section>
</template>

<script>
// 因为项目要接入微信，而微信浏览器不支持全屏显示
// 所以将全屏显示功能注释掉了，舍不得删  0.0

// import fullScreen from '../common/fullscreen.js';

export default {
    name: 'menu',
    data() {
        return {
            menu_list: {
                // full_screen: '全屏模式',
                book_list: '我的书单',
                setting: '设置',
                help: '帮助',
                logout: '登出'
            },
            // isFullScreen: false
        }
    },
    computed: {
        user_name: function () {
            if (!this.$store.state.user.name) {
                return '请登录';
            }
            return this.$store.state.user.name;
        },
        user_state: function () {
            return this.$store.state.user_state;
        }
    },
    mounted: function () {
        /*let that = this;
     
        // 注册全屏切换事件的监听器
        fullScreen.registChangeEvent(function () {
            if (!(document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement)) {
                that.isFullScreen = false;
            }
        });*/
    },
    methods: {
        showLoginPage: function () {
            if (this.user_name === '请登录') {
                this.$store.commit('TOGGLE_SIDEBAR');
                this.$store.commit('TOGGLE_LOGIN_PAGE');
            }
        },
        /*toggleFullScreen: function () {
            this.isFullScreen = this.isFullScreen ? false : true;
     
            if (this.isFullScreen) {
                fullScreen.launch(document.body);
            } else {
                fullScreen.exit();
            }
        },*/
        showBookList: function () {
            this.$store.commit('TOGGLE_SIDEBAR');
            this.$store.commit('TOGGLE_BOOK_LIST');
        },
        help: function () {
            this.$store.commit('TOGGLE_SIDEBAR');
            this.$store.commit('TOGGLE_HELP');
        },
        logout: function () {
            if (this.user_state === 'not_login') {
                return;
            } else {
                // 登出时清除 cookie
                let now = Date.now();
                let expireTime = new Date(now - 1000);
                document.cookie = `user${this.$store.state.user.phone_number}=${now}end;expires=${expireTime.toUTCString()};`;

                // 清除用户信息
                this.$store.state.user.phone_number = '';
                this.$store.state.user.name = '';
                this.$store.state.user.id_number = '';
                this.$store.state.user.academy = '';
                this.$store.state.user.address = '';

                this.$store.commit('CHANGE_USER_STATE', 'not_login');
                this.$store.commit('TOGGLE_LOGIN_PAGE');
            }
        }
    },
    watch: {
        /*isFullScreen: function () {
            if (this.isFullScreen) {
                this.menu_list.full_screen = '关闭全屏模式';
            } else {
                this.menu_list.full_screen = '全屏模式';
            }
        }*/
    }
}
</script>

<style lang="stylus">
.menu-list
    box-sizing: border-box
    position: absolute
    top: 0
    left: 0
    z-index: 1
    width: 250px
    height: 100%
    background: #808080
    transition: 1s

    header
        width: 50%
        margin: 20px auto 0

        img
            width: 100%
            border-radius: 50%

    h1
        text-align: center
        font-size: 1.6em
        color: #FFF
    

    ul
        box-sizing: border-box
        padding: 0
        margin-top: 50px
        padding-left: 40px

    li
        display: block
        height: 40px
        line-height 40px
        font-size: 1.2em
        font-weight: bolder
        color: #a6adb3
        list-style: none
        margin-top: 20px

    li span {
        display: inline-block
        margin-left: 20px
        color: #fff
    }

    svg {
        vertical-align: middle
    }

</style>