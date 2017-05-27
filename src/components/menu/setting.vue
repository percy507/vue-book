<template>
    <div class="setting">
        <div class="return-to-home"
             @click="toggleSetting">&lt; 返回</div>
        <form class="form"
              :class="isFormUp?'form-up':''">
            <h1>更新信息</h1>
            <div class="form-item">
                <label for="setting_name">
                    <span>姓名</span>
                </label>
                <input id="setting_name"
                       type="text"
                       maxlength="11"
                       v-model="name"
                       @focus="moveUp"
                       @blur="moveDown"
                       placeholder="请输入您真实的姓名 ~">
            </div>
            <div class="form-item">
                <label for="setting_id_number">
                    <span>学号</span>
                </label>
                <input id="setting_id_number"
                       type="text"
                       v-model="id_number"
                       @focus="moveUp"
                       @blur="moveDown"
                       placeholder="请输入您的学号 ~">
            </div>
            <div class="form-item">
                <label for="setting_academy">
                    <span>学院</span>
                </label>
                <input id="setting_academy"
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
                <label for="setting_address">
                    <span>地址</span>
                </label>
                <input id="setting_address"
                       type="text"
                       v-model="address"
                       @focus="moveUp"
                       @blur="moveDown"
                       placeholder="eg: 生活二区6号北楼666寝室 ~ ">
            </div>
            <div class="form-item">
                <input type="submit"
                       @click.prevent="userinfoFunc"
                       value="确认更新">
            </div>
        </form>
    </div>
</template>

<script>
import sendData from '../../common/senddata.js';

export default {
    name: 'setting',
    data: function () {
        return {
            isFormUp: false,
            phone_number: '',
            name: '',
            id_number: '',
            academy: '',
            address: '',
            // 设置学院
            academyArr: ['理学院', '材料与纺织学院、丝绸学院', '服装学院', '信息学院', '机械与自动控制学院', '建筑工程学院', '生命科学学院', '经济管理学院', '艺术与设计学院', '法政学院', '外国语学院', '史量才新闻与传播学院', '马克思主义学院', '启新学院', '继续教育学院', '科技与艺术学院'],
            userinfoUrl: 'http://localhost/book/new/server/login/update-userinfo.php'
        }
    },
    computed: {
        isShowSetting: function () {
            return this.$store.state.isShowSetting;
        }
    },
    methods: {
        toggleSetting: function () {
            this.$store.commit('TOGGLE_SETTING');
        },
        moveUp: function () {
            this.isFormUp = true;
        },
        moveDown: function () {
            this.isFormUp = false;
        },
        userinfoFunc: function (event) {
            let that = this;
            let target = event.target;

            if (that.isFormWrong()) {
                return;
            }

            target.classList.add('submit-close');

            that.$store.commit('TOGGLE_LOADING');

            sendData(that.userinfoUrl, {
                phone_number: that.phone_number,
                name: that.name,
                id_number: that.id_number,
                academy: that.academy,
                address: that.address
            }).then(function (data) {
                that.$store.commit('TOGGLE_LOADING');

                if (data === 'update_userinfo_success') {

                    // 将更新后的用户信息存入 this.$store.state.user 对象
                    that.$store.state.user.phone_number = that.phone_number;
                    that.$store.state.user.name = that.name;
                    that.$store.state.user.id_number = that.id_number;
                    that.$store.state.user.academy = that.academy;
                    that.$store.state.user.address = that.address;

                    alert('恭喜您，信息已更新 ~');
                    that.$store.commit('TOGGLE_SETTING');
                } else {
                    alert('未知错误 ~');
                    that.$store.commit('TOGGLE_SETTING');
                    return;
                }

                console.log(data);
                target.classList.remove('submit-close');

            }).catch(function (e) {
                that.$store.commit('TOGGLE_LOADING');
                target.classList.remove('submit-close');
                alert(e);
            });
        },
        isFormWrong: function () {
            let that = this;

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
    },
    watch: {
        isShowSetting: function () {
            let that = this;
            let user = that.$store.state.user;

            // 获取之前注册的信息，并显示，以供参考
            that.phone_number = user.phone_number;
            that.name = user.name;
            that.id_number = user.id_number;
            that.academy = user.academy;
            that.address = user.address;

            that.$el.classList.add('setting-up');

            if (that.isShowSetting) {
                setTimeout(function () {
                    that.$el.classList.add('setting-out');
                }, 600);
            } else {
                setTimeout(function () {
                    that.$el.classList.remove('setting-out');
                    that.$el.classList.remove('setting-up');
                }, 400);
            }
            that.$el.classList.toggle('show-setting');
        }
    }
}
</script>


<style>
.setting {
    position: fixed;
    top: 0;
    z-index: -1;
    width: 100%;
    height: 100%;
    background: #CF9B61;
    display: flex;
    justify-content: center;
    align-items: center;

    transform: scale(0.5);
    opacity: 0;
    transition: 0.4s 0.6s;
}

.setting-up {
    z-index: 99;
}

.setting-out {
    transition: 0.4s;
}

.setting .return-to-home {
    color: rgba(255, 255, 255, 0.6);
}

.setting .form {
    position: relative;
    box-sizing: border-box;
    width: 100%;
    height: 100%;
    padding-top: 20%;
    color: #FFF;
    transition: 0.6s;
}

.show-setting {
    transform: scale(1);
    opacity: 1;
    z-index: 9999;
}
</style>
