<template>
    <div class="book-card"
         @click="toggleCard">
        <div class="book-details">
            <div>书名：{{bookTitle}}</div>
            <div>作者：{{bookAuthor}}</div>
            <div>库存量：{{restNumber}}</div>
        </div>
        <div class="i-want"
             v-if="this.user_state === 'login_success'"
             @click="iWant">{{msg}}</div>
        <figure>
            <img :src="picUrl">
        </figure>
    </div>
</template>

<script>
export default {
    name: 'book-card',
    props: ['bookTitle', 'bookAuthor', 'picUrl', 'restNumber'],
    data: function () {
        return {
            hasSelect: false,
            msg: ''
        };
    },
    computed: {
        user_state: function () {
            return this.$store.state.user_state;
        },
        isShowCard: function () {
            return this.$store.state.isShowCard;
        },
        symbol: function () {
            return this.$store.state.symbol;
        },
        value: function () {
            return this.bookTitle + this.symbol + this.bookAuthor + this.symbol + this.picUrl + this.symbol + this.restNumber + this.symbol + 1;
        }
    },
    methods: {
        toggleCard: function () {
            this.$store.commit('TOGGLE_CARD');
        },
        iWant: function () {
            let sessionStorage = window.sessionStorage;
            let len = sessionStorage.length;

            // 若书不存在于 sessionStorage，则存入
            if (!this.hasSelect) {
                sessionStorage.setItem(len, this.value);
                this.hasSelect = true;
            }
        }
    },
    watch: {
        isShowCard: function () {
            if (this.hasSelect) {
                this.msg = '已选';
            }
        },
        // 注意这里最好监听 value 属性，因为如果监听 isShowCard 属性时，value 属性可能来不及及时更新成最新值，所以会出错
        value: function () {
            let that = this;

            // 如果 book card 被打开
            if (that.isShowCard) {
                that.hasSelect = false;

                // 遍历检查书是否存在于 sessionStorage
                window.sessionStorage.forEach(function (ele) {

                    if (ele === that.value) {
                        that.hasSelect = true;
                    }
                });

                if (that.hasSelect) {
                    that.msg = '已选';
                } else {
                    that.msg = '我想要';
                }
            }
        }
    }
}
</script>

<style lang="stylus">
.book-card {
    box-sizing: border-box;
    position: fixed;
    max-width: 800px;
    width: 100%;
    height: 100%;
    z-index: 5;
    padding-bottom: 60px;
    background: rgba(228,246,255,0.9);
    backface-visibility: hidden;
    overflow-y: scroll;

    figure {
        width: 80%;
        margin: 0 auto;
    }

    figure img{
        width: 100%;
    }   
}

.book-details{
    box-sizing: border-box;
    width: 80%;
    margin: 0px auto;
    padding: 10px 0;
    
    div{
        line-height 1.6;
        font-size: 1.2em;
        font-weight: bold;
        color: rgb(3,169,244);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}

.i-want{
    width: 100px;
    height: 40px;
    margin: 0 auto 20px;
    line-height: 40px;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    background: #51c1f0;
    color: #fbfbfb;
    border-radius: 5px;
}
</style>