<template>
    <transition name="fade">
        <div id="login-container"
             v-if="isShowLogin">
            <div class="forget-password-page">
                <div class="return"
                     @click="showLoginPage">
                    返回 &gt;
                </div>
                <form class="form"
                      :class="isFormUp?'form-up':''">
                    <h1>重设密码</h1>
                    <div class="form-item">
                        <label for="forget-phone_number">
                            <span>账号</span>
                        </label>
                        <input id="forget-phone_number"
                               type="text"
                               maxlength="11"
                               v-model="phone_number"
                               @input="onlyNumber($event)"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入您注册的手机号 ~">
                    </div>
                    <div class="form-item">
                        <label for="forgot-password">
                            <span>密码</span>
                        </label>
                        <input id="forgot-password"
                               type="password"
                               v-model="password"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入新的密码 ~">
                    </div>
                    <div class="form-item">
                        <input class="get-code"
                               type="button"
                               @click.prevent="getAuthCode($event,'forget_password')"
                               :value="message">
                        <input type="text"
                               maxlength="6"
                               v-model="auth_code"
                               @input="onlyNumber($event)"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入您收到的验证码 ~">
                    </div>
                    <div class="form-item">
                        <input type="submit"
                               @click.prevent="forgetPasswordFunc"
                               value="提交">
                    </div>
                </form>
            </div>
            <div class="login-page">
                <div id="forget-password"
                     @click="showForgetPasswordPage">
                    ? 忘记密码
                </div>
                <div id="just-see"
                     @click="justSee">
                    随便看看 >
                </div>
                <form class="form"
                      :class="isFormUp?'form-up':''">
                    <h1>伯牙书舍</h1>
                    <div class="form-item">
                        <label for="login-phone_number">
                            <span>账号</span>
                        </label>
                        <input id="login-phone_number"
                               type="text"
                               maxlength="11"
                               v-model="phone_number"
                               @input="onlyNumber($event)"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入您注册的手机号 ~">
                    </div>
                    <div class="form-item">
                        <label for="login-password">
                            <span>密码</span>
                        </label>
                        <input id="login-password"
                               v-model="password"
                               type="password"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入您的密码 ~">
                    </div>
                    <div class="form-item">
                        <input id="login-login"
                               type="submit"
                               @click.prevent="loginFunc"
                               value="登录">
                        <input id="login-signup"
                               type="submit"
                               @click.prevent="showSignupPage"
                               value="注册">
                    </div>
                </form>
            </div>
            <div class="signup-page">
                <div class="return"
                     @click="showLoginPage">
                    &lt; 返回
                </div>
                <form class="form"
                      :class="isFormUp?'form-up':''">
                    <h1>欢迎注册</h1>
                    <div class="form-item">
                        <label for="signup-phone_number">
                            <span>账号</span>
                        </label>
                        <input id="signup-phone_number"
                               type="text"
                               maxlength="11"
                               v-model="phone_number"
                               @input="onlyNumber($event)"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入您的手机号 ~">
                    </div>
                    <div class="form-item">
                        <label for="signup-password">
                            <span>密码</span>
                        </label>
                        <input id="signup-password"
                               type="password"
                               v-model="password"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入您的密码 ~">
                    </div>
                    <div class="form-item">
                        <label for="signup-password-again">
                            <span>密码</span>
                        </label>
                        <input id="signup-password-again"
                               type="password"
                               v-model="password_again"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请再次输入您的密码 ~">
                    </div>
                    <div class="form-item">
                        <input class="get-code"
                               type="button"
                               @click.prevent="getAuthCode($event,'signup')"
                               :value="message">
                        <input type="text"
                               maxlength="6"
                               v-model="auth_code"
                               @input="onlyNumber($event)"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入您收到的验证码 ~">
                    </div>
                    <div class="form-item">
                        <input type="submit"
                               @click.prevent="signupFunc"
                               value="确认注册">
                    </div>
                </form>
            </div>
            <div class="userinfo-page">
                <div class="return"
                     @click="showLoginPage">
                    <p>&#8248;</p>
                    <p>返回</p>
                </div>
                <form class="form"
                      :class="isFormUp?'form-up':''">
                    <h1>完善信息</h1>
                    <div class="form-item">
                        <label for="userinfo_name">
                            <span>姓名</span>
                        </label>
                        <input id="userinfo_name"
                               type="text"
                               maxlength="11"
                               v-model="name"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入您真实的姓名 ~">
                    </div>
                    <div class="form-item">
                        <label for="userinfo_id_number">
                            <span>学号</span>
                        </label>
                        <input id="userinfo_id_number"
                               type="text"
                               v-model="id_number"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="请输入您的学号 ~">
                    </div>
                    <div class="form-item">
                        <label for="userinfo_academy">
                            <span>学院</span>
                        </label>
                        <input id="userinfo_academy"
                               type="text"
                               list="academys"
                               v-model="academy"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="eg: 信息学院 ~">
                        <datalist id="academys">
                            <option v-for="(value,index) in academyArr"
                                    :value="value" />
                        </datalist>
                    </div>
                    <div class="form-item">
                        <label for="userinfo_address">
                            <span>地址</span>
                        </label>
                        <input id="userinfo_address"
                               type="text"
                               v-model="address"
                               @focus="moveUp"
                               @blur="moveDown"
                               placeholder="eg: 生活二区6号北楼666寝室 ~ ">
                    </div>
                    <div class="form-item">
                        <input type="submit"
                               @click.prevent="userinfoFunc"
                               value="提交">
                    </div>
                </form>
            </div>
        </div>
    </transition>
</template>

<script>
import getData from '../common/getdata.js';
import sendData from '../common/senddata.js';

export default {
    name: 'login',
    data: function () {
        return {
            isFormUp: false,
            waitTime: 60,
            globalTimer: '',
            message: '获取验证码',
            url: {
                forgetPasswordUrl: 'http://localhost/book/new/server/login/forget-password.php',
                loginUrl: 'http://localhost/book/new/server/login/login.php',
                signupUrl: 'http://localhost/book/new/server/login/signup.php',
                userinfoUrl: 'http://localhost/book/new/server/login/update-userinfo.php',
                authCodeUrl: 'http://localhost/book/new/server/login/get-auth-code.php'
            },
            // 设置学院
            academyArr: ['理学院', '材料与纺织学院、丝绸学院', '服装学院', '信息学院', '机械与自动控制学院', '建筑工程学院', '生命科学学院', '经济管理学院', '艺术与设计学院', '法政学院', '外国语学院', '史量才新闻与传播学院', '马克思主义学院', '启新学院', '继续教育学院', '科技与艺术学院'],
            // 以下变量用于向服务器发送相关的数据
            phone_number: '',
            password: '',
            auth_code: '',
            password_again: '',
            name: '',
            id_number: '',
            academy: '',
            address: ''
        }
    },
    computed: {
        isShowLogin: function () {
            return this.$store.state.isShowLogin;
        }
    },
    mounted: function () {
        let that = this;

        // mounted 完成后，检查 cookie
        let allCookie = document.cookie;

        // 如果 cookie 中存在之前的用户，则可直接进行登录
        if (allCookie.match(/user.+?=.+?end/)) {
            let cookie = allCookie.match(/user.+?=.+?end/)[0];
            let user = cookie.slice(4, 15);
            let token = cookie.slice(16, -3);

            sendData(that.url.loginUrl, {
                phone_number: user,
                token: token
            }).then(function (data) {

                if (data === 'not_found') {
                    return;
                } else if (data === 'wrong_token') {
                    return;
                } else {
                    let arr = data.split('|');

                    if (arr[0] === 'should_update_userinfo') {

                        that.$el.querySelector('.userinfo-page').classList.add('show-page');

                        return;
                    } else if (arr[0] === 'login_success') {
                        let userData = JSON.parse(arr[1]);

                        // 将用户信息存入 this.$store.state.user 对象
                        that.$store.state.user.phone_number = userData[0];
                        that.$store.state.user.name = userData[1];
                        that.$store.state.user.id_number = userData[2];
                        that.$store.state.user.academy = userData[3];
                        that.$store.state.user.address = userData[4];

                        that.$store.commit('CHANGE_CONTENTTYPE', 'home');
                        that.$store.commit('CHANGE_USER_STATE', 'login_success');
                        that.$store.commit('TOGGLE_LOGIN_PAGE');
                    }
                }

            });
        }
    },
    methods: {
        justSee: function () {
            this.$store.commit('CHANGE_CONTENTTYPE', 'home');
            this.$store.commit('CHANGE_USER_STATE', 'not_login');
            this.$store.commit('TOGGLE_LOGIN_PAGE');
        },
        moveUp: function () {
            this.isFormUp = true;
        },
        moveDown: function () {
            this.isFormUp = false;
        },
        onlyNumber: function (event) {
            let target = event.target;

            if (target.maxLength === 6) {
                this.auth_code = target.value.replace(/[^\d]/g, '');
            } else {
                this.phone_number = target.value.replace(/[^\d]/g, '');
            }
        },
        resetForm: function () {
            // 清除之前的计时器
            clearInterval(this.globalTimer);

            this.waitTime = 60;
            this.message = '获取验证码';
            this.phone_number = '';
            this.password = '';
            this.password_again = '';
            this.auth_code = '';

            // 解禁验证码按钮
            this.$el.querySelector('.get-code').classList.remove('submit-close');
        },
        showSignupPage: function () {
            this.resetForm();
            this.$el.querySelector('.signup-page').classList.add('show-page');
        },
        showLoginPage: function () {
            this.resetForm();
            this.$el.querySelector('.signup-page').classList.remove('show-page');
            this.$el.querySelector('.forget-password-page').classList.remove('show-page');
            this.$el.querySelector('.userinfo-page').classList.remove('show-page');
        },
        showForgetPasswordPage: function () {
            this.resetForm();
            this.$el.querySelector('.forget-password-page').classList.add('show-page');
        },
        getAuthCode: function (event, flag) {
            let that = this;

            // 验证是否输入了有效的手机号，手机号未做详细校验
            if (!this.phone_number.match(/\d{11}/)) {
                alert('请输入有效的手机号 ~');
                return;
            }

            // 发送验证码后，暂时禁用验证码按钮
            event.target.classList.add('submit-close');

            // 将手机号发送至服务器，以便获取验证码
            sendData(that.url.authCodeUrl, {
                phone_number: that.phone_number,
                flag: flag
            }).then(function (data) {
                if (flag === 'forget_password' && data === 'not_found') {
                    alert('该用户尚未注册哦 ~');
                    return;
                }

                if (flag === 'signup' && data === 'user_existed') {
                    alert('哈，该用户已被注册啦 ~');
                    return;
                }

                let timer = setInterval(function () {
                    that.waitTime--;
                    that.message = that.waitTime;
                    if (that.waitTime === 0) {
                        that.message = "重新获取验证码";
                        that.waitTime = 60;

                        // 解禁验证码按钮
                        event.target.classList.remove('submit-close');
                        clearInterval(timer);
                    }
                }, 1000);

                that.globalTimer = timer;

                that.message = that.waitTime;
            }).catch(function (e) {
                alert(e);
            });

        },
        loginFunc: function () {
            let that = this;

            if (that.isFormWrong('login')) {
                return;
            }

            that.$store.commit('TOGGLE_LOADING');

            sendData(that.url.loginUrl, {
                phone_number: that.phone_number,
                password: that.password
            }).then(function (data) {
                that.$store.commit('TOGGLE_LOADING');

                if (data === 'not_found') {
                    alert('该用户尚未注册哦 ~');
                    return;
                } else if (data === 'wrong_password') {
                    alert('密码错误 ~');
                    return;
                } else {
                    let arr = data.split('|');

                    if (arr[0] === 'should_update_userinfo') {

                        that.$el.querySelector('.userinfo-page').classList.add('show-page');

                        // 将用户信息存入 this.$store.state.user 对象
                        that.$store.state.user.phone_number = arr[1];
                        return;
                    } else if (arr[0] === 'login_success') {
                        let userData = JSON.parse(arr[2]);

                        // 清除用户密码信息
                        that.password = '';

                        // 将用户信息存入 this.$store.state.user 对象
                        that.$store.state.user.phone_number = userData[0];
                        that.$store.state.user.name = userData[1];
                        that.$store.state.user.id_number = userData[2];
                        that.$store.state.user.academy = userData[3];
                        that.$store.state.user.address = userData[4];

                        that.$store.commit('CHANGE_CONTENTTYPE', 'home');
                        that.$store.commit('CHANGE_USER_STATE', 'login_success');
                        that.$store.commit('TOGGLE_LOGIN_PAGE');

                        // 登录成功后，将服务器发来的时间戳写入本地 cookie
                        // 并设置过期时间为 30分钟
                        // 注意 PHP 返回的时间戳单位是秒，而 JavaScript 操作的是毫秒
                        let tokenTime = Number.parseInt(arr[1], 10);
                        let expireTime = new Date(tokenTime * 1000 + 30 * 60 * 1000);
                        document.cookie = `user${that.phone_number}=${tokenTime}end;expires=${expireTime.toUTCString()};`;
                    }
                }
            }).catch(function (e) {
                that.$store.commit('TOGGLE_LOADING');
                alert(e);
            });

        },
        signupFunc: function () {
            let that = this;

            if (that.isFormWrong('signup')) {
                return;
            };

            that.$store.commit('TOGGLE_LOADING');

            sendData(that.url.signupUrl, {
                phone_number: that.phone_number,
                password: that.password,
                auth_code: that.auth_code
            }).then(function (data) {
                that.$store.commit('TOGGLE_LOADING');

                if (data === 'wrong_data') {
                    alert('服务端检测出错误的数据，请重试 ~');
                    return;
                } else if (data === 'wrong_auth_code') {
                    alert('请填写正确的验证码 ~');
                    return;
                } else if (data === 'phone_number_existed') {
                    alert('哈，该用户已被注册啦 ~');
                    return;
                } else if (data === 'signup_success') {
                    alert('恭喜您注册成功 ~');
                } else {
                    alert('未知错误 ~');
                    return;
                }

                that.$el.querySelector('.userinfo-page').classList.add('show-page');

                console.log(data);
            }).catch(function (e) {
                that.$store.commit('TOGGLE_LOADING');
                alert(e);
            });
        },
        forgetPasswordFunc: function () {
            let that = this;

            if (that.isFormWrong()) {
                return;
            };

            that.$store.commit('TOGGLE_LOADING');

            sendData(that.url.forgetPasswordUrl, {
                phone_number: that.phone_number,
                password: that.password,
                auth_code: that.auth_code
            }).then(function (data) {
                that.$store.commit('TOGGLE_LOADING');

                if (data === 'wrong_data') {
                    alert('服务端检测出错误的数据，请重试 ~');
                    return;
                } else if (data === 'wrong_auth_code') {
                    alert('请填写正确的验证码 ~');
                    return;
                } else if (data === 'not_found') {
                    alert('该用户尚未注册哦 ~');
                    return;
                } else if (data === 'change_password_success') {
                    alert('恭喜您修改密码成功 ~');
                } else {
                    alert('未知错误 ~');
                    return;
                }

                console.log(data);

                that.showLoginPage();
            }).catch(function (e) {
                that.$store.commit('TOGGLE_LOADING');
                alert(e);
            });
        },
        userinfoFunc: function () {
            let that = this;

            if (that.isFormWrong('userinfo')) {
                return;
            }

            that.$store.commit('TOGGLE_LOADING');

            sendData(that.url.userinfoUrl, {
                phone_number: that.phone_number,
                name: that.name,
                id_number: that.id_number,
                academy: that.academy,
                address: that.address
            }).then(function (data) {
                that.$store.commit('TOGGLE_LOADING');

                if (data === 'update_userinfo_success') {
                    alert('恭喜您，信息已完善 ~');
                } else {
                    alert('未知错误 ~');
                    return;
                }

                console.log(data);
                that.showLoginPage();

            }).catch(function (e) {
                that.$store.commit('TOGGLE_LOADING');
                alert(e);
            });
        },
        isFormWrong: function (type) {
            let that = this;

            if (type === 'userinfo') {
                if (!that.name.match(/^[\u4E00-\u9FCCa-zA-Z]+$/)) {
                    alert('请输入有效的姓名（仅限中文、字母字符） ~');
                    return true;
                }
                if (!that.id_number.match(/^\d+$/)) {
                    alert('请输入有效的学号（仅限数字） ~');
                    return true;
                }
                if (!that.academyArr.includes(that.academy)) {
                    alert('请输入有效的学院 ~');
                    return true;
                }
                if (!that.address.match(/^[\u4E00-\u9FCC\w]+$/)) {
                    alert('请输入有效的地址（仅限中文、数字与字母字符） ~');
                    return true;
                }
                return false;
            }

            if (!that.phone_number.match(/\d{11}/)) {
                alert('请输入有效的手机号 ~');
                return true;
            }

            if (!that.password.match(/^\w{6,}$/)) {
                alert('密码至少有6个字符，字符仅限字母与数字 ~');
                return true;
            }

            if (type === 'signup') {
                if (that.password !== that.password_again) {
                    alert('您填写的两次的密码不同哦 ~');
                    return true;
                }
            }

            if (type !== 'login') {
                if (!that.auth_code.match(/\d{6}/)) {
                    alert('请填写有效的验证码 ~');
                    return true;
                }
            }

            return false;
        }
    }
}

</script>

<style>
@import url('./login-css/login-normal.css');
@import url('./login-css/login-forget-password.css');
@import url('./login-css/login-login.css');
@import url('./login-css/login-signup.css');
@import url('./login-css/login-userinfo.css');
</style>