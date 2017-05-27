<template>
    <div class="help">
        <div class="return-to-home"
             @click="toggleHelp">&lt; 返回</div>
        <div class="help-container">
            <h1>公告</h1>
            <pre v-text="message"></pre>
        </div>
    </div>
</template>

<script>
import getData from '../../common/getdata.js';

export default {
    name: 'help',
    data: function () {
        return {
            message: '',
            messageUrl: 'http://localhost/book/new/server/get-help-message.php'
        };
    },
    computed: {
        isShowHelp: function () {
            return this.$store.state.isShowHelp;
        }
    },
    mounted: function () {
        let that = this;

        getData(that.messageUrl).then(function (result) {
            that.message = JSON.parse(result)[0];
        }).catch(function (e) {
            alert(e);
        });
    },
    methods: {
        toggleHelp: function () {
            this.$store.commit('TOGGLE_HELP');
        }
    },
    watch: {
        isShowHelp: function () {
            let that = this;

            that.$el.classList.add('help-up');

            if (that.isShowHelp) {
                setTimeout(function () {
                    that.$el.classList.add('help-out');
                }, 600);
            } else {
                setTimeout(function () {
                    that.$el.classList.remove('help-out');
                    that.$el.classList.remove('help-up');
                }, 400);
            }
            that.$el.classList.toggle('show-help');
        }
    }
}
</script>

<style>
.help {
    position: fixed;
    top: 0;
    z-index: -1;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;

    transform: scale(0.5);
    opacity: 0;
    transition: 0.4s 0.6s;
}

.help-up {
    z-index: 99;
}

.help-out {
    transition: 0.4s;
}

.help-container {
    width: 100%;
    height: 100%;
    background: #F0F4C1;
    color: #6C3A27;
    overflow-y: scroll;
}

.help-container h1 {
    font-size: 1.6em;
    text-align: center;
}

.help-container pre {
    line-height: 1.8;
    margin: 10px 20px;
    font-size: 16px;
    white-space: pre-wrap;
}

.show-help {
    transform: scale(1);
    opacity: 1;
    z-index: 9999;
}
</style>
