<template>
    <div class="content" @scroll="scrollLoad">
        <div class="books">
            <transition name="fade">
                <book-card v-show="isShowCard" v-bind:book-title="bookCard[0]" v-bind:book-author="bookCard[1]" v-bind:picUrl="bookCard[2]" v-bind:rest-number="bookCard[3]"></book-card>
            </transition>
            <book-item v-for="(book,index) in books" key="index" v-bind:book-title="book[0]" v-bind:book-author="book[1]" v-bind:picUrl="book[2]" v-bind:rest-number="book[3]" @click.native="whichBook(book)"></book-item>
            <div class="load-more" @click="loadmore">{{ load_message }}</div>
        </div>
    </div>
</template>

<script>
import bookCard from './book-card.vue';
import bookItem from './book-item.vue';
import getData from '../common/getdata.js';

// 初始化检测位置，值为未滑动时 book.getBoundingClientRect().top 的值
let initPos = 56;

const data = {
    books: null,
    bookCard: [null, null, null, null],
    // 默认设置为一个包含4个元素的数组，防止出错    
    data_num: 10,
    request_count: 1,
    url: 'http://localhost/book/new/backend/getdata.php',
    load_message: '加载更多~'
};

export default {
    name: 'content',
    props: ['keyword'],
    data: function () {
        return data;
    },
    computed: {
        type: function () {
            return this.$store.state.contentType;
        },
        isShowCard: function () {
            return this.$store.state.isShowCard;
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
            if (this.type == 'search') {
                return;
            }
            this.request_count++;
            let queryObj = {
                type: this.type,
                data_num: this.data_num,
                request_count: this.request_count
            };
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
                console.log('获取数据失败~');
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
    mounted: function () {
        this.request_count = 1;
        let that = this;
        let queryObj = {
            type: this.type,
            data_num: this.data_num,
            request_count: this.request_count
        };
        that.$store.commit('TOGGLE_LOADING');
        getData(that.url, queryObj).then(function (result) {
            console.log('mounted~');
            result = result.trim();
            if (result == 'nothing') {
                that.books = [];
                that.load_message = '没有了~';
            } else {
                that.books = JSON.parse(result);
            }
            that.$store.commit('TOGGLE_LOADING');
        }).catch(function () {
            console.log('获取数据失败~');
        });
    },
    watch: {
        keyword: function () {
            this.request_count = 1;
            this.load_message = '没有了~';
            let that = this;
            if (!(this.type == 'search' && this.keyword)) {
                return;
            }
            let queryObj = {
                type: this.type,
                data_num: this.data_num,
                request_count: this.request_count,
                keyword: this.keyword
            };
            that.$store.commit('TOGGLE_LOADING');
            getData(this.url, queryObj).then(function (result) {
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
                console.log('获取数据失败~');
            });
        },
        type: function () {
            this.request_count = 1;
            this.load_message = '加载更多~';
            let that = this;
            if (this.type == 'search') {
                return;
            }
            let queryObj = {
                type: this.type,
                data_num: this.data_num,
                request_count: this.request_count
            };
            that.$store.commit('TOGGLE_LOADING');
            getData(this.url, queryObj).then(function (result) {
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
                console.log('获取数据失败~');
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

<style lang="">
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