<template>
    <div class="help"
         @click="toggleHelp">
        <div class="help-container">
            <h1>公告</h1>
            <div>为了保证我们能准确送书到您的寝室，请务必保证自己填写的信息准确无误，防止尴尬。</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'help',
    computed: {
        isShowHelp: function () {
            return this.$store.state.isShowHelp;
        }
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
}

.help-container h1 {
    text-align: center;
}

.help-container div {
    line-height: 1.6;
    text-indent: 2em;
    margin: 10px 20px;
    font-size: 1.2em;
}

.show-help {
    transform: scale(1);
    opacity: 1;
    z-index: 9999;
}
</style>
