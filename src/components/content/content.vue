<template>
    <div class="content"
         @scroll="scrollLoad">
        <div class="books">
            <transition name="fade">
                <book-card v-show="isShowCard"
                           :book-title="bookCard[0]"
                           :book-author="bookCard[1]"
                           :picUrl="bookCard[2]"
                           :rest-number="bookCard[3]"></book-card>
            </transition>
            <book-item v-for="(book,index) in books"
                       :key="index"
                       :book-title="book[0]"
                       :book-author="book[1]"
                       :picUrl="book[2]"
                       :rest-number="book[3]"
                       @click.native="whichBook(book)"></book-item>
            <div class="load-more"
                 @click="loadmore">{{ load_message }}</div>
        </div>
    </div>
</template>

<script>
import bookCard from './book-card.vue';
import bookItem from './book-item.vue';
import getData from '../../common/getdata.js';

// 初始化检测位置，值为未滑动时 book.getBoundingClientRect().top 的值
let initPos = 56;

const data = {
    books: null,
    // 默认设置为一个包含4个元素的数组，防止出错   
    bookCard: [null, null, null, null],
    data_num: 16,
    request_count: 1,
    url: 'http://localhost/book/new/server/getdata.php',
    load_message: '加载更多~'
};

export default {
    name: 'content',
    data: function () {
        return data;
    },
    computed: {
        type: function () {
            return this.$store.state.contentType;
        },
        keyword: function () {
            return this.$store.state.keyword;
        },
        isShowCard: function () {
            return this.$store.state.isShowCard;
        },
        user_state: function () {
            return this.$store.state.user_state;
        },
        isShowLogin: function () {
            return this.$store.state.isShowLogin;
        }
    },
    components: {
        bookCard,
        bookItem
    },
    methods: {
        whichBook: function (book) {
            this.bookCard = book;
        },
        loadmore: function () {
            let that = this;

            that.request_count++;

            let queryObj = {
                type: that.type,
                data_num: that.data_num,
                request_count: that.request_count,
                user_state: that.user_state
            };

            if (that.user_state === 'login_success') {
                queryObj.academy = that.$store.state.user.academy;
            }

            if (that.type == 'search') {
                queryObj.keyword = that.keyword;
            }

            that.$store.commit('TOGGLE_LOADING');

            getData(that.url, queryObj).then(function (result) {
                console.log('loadmore~');

                result = result.trim();

                if (result == 'nothing') {
                    that.load_message = '没有了~';
                } else {
                    that.books = that.books.concat(JSON.parse(result));
                }

                that.$store.commit('TOGGLE_LOADING');
            }).catch(function () {
                alert('获取数据失败~');
                that.$store.commit('TOGGLE_LOADING');
            });
        },
        scrollLoad: function () {
            throttle(scan, 50)();
        }
    },
    updated: function () {
        // 默认直接显示四个 book，剩下的滑动时再加载       
        let books = document.querySelectorAll('.book-item');

        books.forEach(function (el, index) {
            if (index == 0 || index == 1 || index == 2 || index == 3) {
                el.classList.add('show');
            }
        });
    },
    watch: {
        isShowLogin: function () {
            let that = this;

            if (that.isShowLogin === true) {
                return;
            }

            that.request_count = 1;

            let queryObj = {
                type: that.type,
                data_num: that.data_num,
                request_count: that.request_count,
                user_state: that.user_state
            };

            if (that.user_state === 'login_success') {
                queryObj.academy = that.$store.state.user.academy;
            }

            that.$store.commit('TOGGLE_LOADING');

            getData(that.url, queryObj).then(function (result) {
                console.log(that.user_state);

                result = result.trim();

                if (result == 'nothing') {
                    that.books = [];
                    that.load_message = '没有了~';
                } else {
                    that.books = JSON.parse(result);
                }

                that.$store.commit('TOGGLE_LOADING');
            }).catch(function () {
                alert('获取数据失败~');
                that.$store.commit('TOGGLE_LOADING');
            });
        },
        keyword: function () {
            let that = this;

            that.request_count = 1;
            that.load_message = '加载更多~';

            if (!(that.type == 'search' && that.keyword)) {
                return;
            }

            // 关键字只允许有中文、字母、数字以及空格
            if (!that.keyword.match(/^[\u4E00-\u9FCC\w ]+$/)) {
                alert('关键字只允许有中文、字母、数字以及空格哦 ~');
                return;
            }

            let queryObj = {
                type: that.type,
                data_num: that.data_num,
                request_count: that.request_count,
                keyword: that.keyword,
                user_state: that.user_state
            };

            if (that.user_state === 'login_success') {
                queryObj.academy = that.$store.state.user.academy;
            }

            that.$store.commit('TOGGLE_LOADING');

            getData(that.url, queryObj).then(function (result) {
                console.log('keyword search ~');

                result = result.trim();

                if (result == 'nothing') {
                    that.books = [];
                    that.load_message = '没有了~';
                } else {
                    that.books = JSON.parse(result);
                }

                that.$store.commit('TOGGLE_LOADING');
            }).catch(function () {
                alert('获取数据失败~');
                that.$store.commit('TOGGLE_LOADING');
            });
        },
        type: function () {
            let that = this;

            // 处理 search 的逻辑在上面
            if (that.type == 'search') {
                return;
            }

            that.request_count = 1;
            that.load_message = '加载更多~';

            // 每次页面类型发生变化时，要及时清除 keyword 的值
            that.$store.commit('CHANGE_KEYWORD', '');

            let queryObj = {
                type: that.type,
                data_num: that.data_num,
                request_count: that.request_count,
                user_state: that.user_state
            };

            if (that.user_state === 'login_success') {
                queryObj.academy = that.$store.state.user.academy;
            }

            that.$store.commit('TOGGLE_LOADING');

            getData(that.url, queryObj).then(function (result) {
                console.log('watching type~');

                result = result.trim();

                if (result == 'nothing') {
                    that.books = [];
                    that.load_message = '没有了~';
                } else {
                    that.books = JSON.parse(result);
                }

                that.$store.commit('TOGGLE_LOADING');
            }).catch(function () {
                alert('获取数据失败~');
                that.$store.commit('TOGGLE_LOADING');
            });
        }
    }
}

// 优化 scroll event，提升性能
function throttle(callback, wait) {
    return function () {
        let time, doScroll = true;
        if (doScroll) {
            doScroll = false;
            time = setTimeout(function () {
                time = null;
                callback.call();
            }, wait);
        }
    };
}

// 判断元素是否在可视区域内（Viewport）
function isElementInViewport(el) {
    var rect = el.getBoundingClientRect();
    return (rect.top >= 0 && rect.left >= 0 && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && rect.right <= (window.innerWidth || document.documentElement.clientWidth));
}

function scan() {
    let books = document.querySelectorAll('.book-item');
    books.forEach(function (el, index) {
        if (isElementInViewport(el)) {
            el.classList.add('show');
        }
    });
}
</script>

<style>
.content {
    height: 100%;
    overflow-y: auto;
}

.books {
    position: relative;
}

.load-more {
    box-sizing: border-box;
    width: 100%;
    height: 50px;
    margin-bottom: 56px;
    line-height: 50px;
    border-top: 1px solid #ddd;
    text-align: center;
    font-size: 1.4em;
    font-weight: bold;
    color: #666;
}

.fade-enter {
    opacity: 0;
    transform: scale(0.7);
}

.fade-enter-active {
    transition: 0.3s;
}

.fade-leave {
    opacity: 1;
    transform: scale(1);
}

.fade-leave-active {
    opacity: 0;
    transform: scale(0.7);
    transition: 0.3s;
}

.b-lazy {
    opacity: 0;
}

.b-lazy.b-loaded {
    opacity: 1;
}
</style>