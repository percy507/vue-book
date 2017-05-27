<template>
    <div class="book-list">
        <div class="book-list-container">
            <div class="return-to-home"
                 @click="toggleBookList">&lt; 返回</div>
            <h1>我的书单</h1>
            <transition-group name="book-slide"
                              tag="ul">
                <li v-for="(book,index) in books"
                    :key="book.id">
                    <span class="remove-book"
                          @click="removeBook(index)">
                        <svg version="1.1"
                             xmlns="http://www.w3.org/2000/svg"
                             width="512"
                             height="512"
                             viewBox="0 0 512 512">
                            <title></title>
                            <g id="icomoon-ignore">
                            </g>
                            <path d="M64 160v320c0 17.6 14.4 32 32 32h288c17.6 0 32-14.4 32-32v-320h-352zM160 448h-32v-224h32v224zM224 448h-32v-224h32v224zM288 448h-32v-224h32v224zM352 448h-32v-224h32v224z"></path>
                            <path d="M424 64h-104v-40c0-13.2-10.8-24-24-24h-112c-13.2 0-24 10.8-24 24v40h-104c-13.2 0-24 10.8-24 24v40h416v-40c0-13.2-10.8-24-24-24zM288 64h-96v-31.599h96v31.599z"></path>
                        </svg>
                    </span>
                    <div class="cart-book-number">
                        <div class="number-minus"
                             @click="minusNumber(index,$event)">
                            <svg version="1.1"
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="512"
                                 height="512"
                                 viewBox="0 0 512 512">
                                <title></title>
                                <g id="icomoon-ignore">
                                </g>
                                <path d="M0 208v96c0 8.836 7.164 16 16 16h480c8.836 0 16-7.164 16-16v-96c0-8.836-7.164-16-16-16h-480c-8.836 0-16 7.164-16 16z"></path>
                            </svg>
                        </div>
                        <div class="number-show">{{ book.wantNumber }}</div>
                        <div class="number-plus"
                             @click="plusNumber(index,$event)">
                            <svg version="1.1"
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="512"
                                 height="512"
                                 viewBox="0 0 512 512">
                                <title></title>
                                <g id="icomoon-ignore">
                                </g>
                                <path d="M496 192h-176v-176c0-8.836-7.164-16-16-16h-96c-8.836 0-16 7.164-16 16v176h-176c-8.836 0-16 7.164-16 16v96c0 8.836 7.164 16 16 16h176v176c0 8.836 7.164 16 16 16h96c8.836 0 16-7.164 16-16v-176h176c8.836 0 16-7.164 16-16v-96c0-8.836-7.164-16-16-16z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="cart-book-picture">
                        <img :src="book.url">
                    </div>
                    <div class="cart-book-title">{{ book.title }}</div>
                </li>
            </transition-group>
            <div class="submit-require"
                 @click="submitOrder($event)">确认提交（共 {{total_number}} 本）</div>
        </div>
    </div>
</template>

<script>
import sendData from '../../common/senddata.js';

export default {
    name: 'book-list',
    data: function () {
        return {
            books: [],
            total_number: '',
            submitUrl: 'http://localhost/book/new/server/submit-order.php'
        }
    },
    computed: {
        isShowBookList: function () {
            return this.$store.state.isShowBookList;
        },
        symbol: function () {
            return this.$store.state.symbol;
        },
        order: function () {
            let arr = [];

            this.books.forEach(function (book) {
                let obj = {};
                obj.title = book.title;
                obj.author = book.author;
                obj.wantNumber = book.wantNumber;

                arr.push(obj);
            });

            return arr;
        }
    },
    methods: {
        toggleBookList: function () {
            this.$store.commit('TOGGLE_BOOK_LIST');
        },
        minusNumber: function (index) {
            let that = this;
            let book = that.books[index];

            if (book.wantNumber <= 1) {
                return;
            }

            book.wantNumber--;

            // 为了确保下次能显示上次编辑的数量，将数量同步更新到 sessionStorage
            window.sessionStorage.forEach(function (ele, i) {
                if (index === i) {
                    let arr = ele.split(that.symbol);
                    arr[4] = book.wantNumber;

                    let value = arr.join(that.symbol);

                    sessionStorage.setItem(index, value);
                }
            });
        },
        plusNumber: function (index) {
            let that = this;
            let book = that.books[index];

            if (book.wantNumber >= book.restNumber) {
                return;
            }

            book.wantNumber++;

            // 为了确保下次能显示上次编辑的数量，将数量同步更新到 sessionStorage
            window.sessionStorage.forEach(function (ele, i) {
                if (index === i) {
                    let arr = ele.split(that.symbol);
                    arr[4] = book.wantNumber;

                    let value = arr.join(that.symbol);

                    sessionStorage.setItem(index, value);
                }
            });
        },
        removeBook: function (index) {
            let sessionStorage = window.sessionStorage;
            let len = sessionStorage.length;

            // 为了保证 sessionStorage 的类数组特性，所以删除指定数据后，应该将后面的数据依次前移
            sessionStorage.removeItem(index);
            for (let i = index; i < len - 1; i++) {
                sessionStorage.setItem(i, sessionStorage.getItem(i + 1));
            }
            sessionStorage.removeItem(len - 1);

            this.books.splice(index, 1);
            this.total_number--;
        },
        submitOrder: function (event) {
            let that = this;
            let target = event.target;

            if (window.sessionStorage.length === 0) {
                return;
            }

            target.classList.add('submit-close');

            let dataObj = {
                phone_number: that.$store.state.user.phone_number,
                order_details: JSON.stringify(that.order)
            };

            that.$store.commit('TOGGLE_LOADING');

            sendData(that.submitUrl, dataObj).then(function (result) {

                if (result === 'success') {
                    alert('提交成功，请静待消息 ~');

                    // 提交成功后清空 sessionStorage 数据
                    window.sessionStorage.clear();
                } else {
                    alert('未知错误 ~');
                }

                target.classList.remove('submit-close');

                that.$store.commit('TOGGLE_LOADING');
                that.$store.commit('TOGGLE_BOOK_LIST');
            }).catch(function (e) {
                alert(e);

                target.classList.remove('submit-close');

                that.$store.commit('TOGGLE_LOADING');
                that.$store.commit('TOGGLE_BOOK_LIST');
            });

        }
    },
    watch: {
        isShowBookList: function () {
            let that = this;

            if (that.isShowBookList) {
                that.$el.classList.add('book-list-up');

                // 重置
                that.books = [];

                window.sessionStorage.forEach(function (ele, index) {
                    let arr = ele.split(that.symbol);
                    let obj = {};
                    obj.id = index;
                    obj.title = arr[0];
                    obj.author = arr[1];
                    obj.url = arr[2];
                    obj.restNumber = arr[3];
                    obj.wantNumber = arr[4];

                    that.books.push(obj);
                });

                that.total_number = window.sessionStorage.length;

                setTimeout(function () {
                    that.$el.classList.add('book-list-out');
                }, 600);
            } else {
                setTimeout(function () {
                    that.$el.classList.remove('book-list-out');
                    that.$el.classList.remove('book-list-up');
                }, 400);
            }

            that.$el.classList.toggle('show-book-list');
        }
    }
}
</script>

<style>
.return-to-home {
    position: absolute;
    z-index: 9999;
    top: 20px;
    left: 20px;
    color: rgba(111, 111, 111, 0.6);
    font-size: 16px;
}

.book-list {
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

.book-list-up {
    z-index: 99;
}

.book-list-out {
    transition: 0.4s;
}

.book-list-container {
    width: 100%;
    height: 100%;
    background: #EEE;
    color: #666;

    overflow-x: hidden;
    overflow-y: auto;
}

.book-list-container h1 {
    font-size: 1.6em;
    text-align: center;
    margin-bottom: 30px;
}

.book-list-container ul {
    padding: 0;
    margin: 0;
    margin-bottom: 60px;
}

.book-list-container li {
    position: relative;
    box-sizing: border-box;
    width: 100%;
    height: 110px;
    margin: 16px auto;
    background: #FFF;
    list-style: none;

    transition: 0.4s;
}

.book-slide-leave-to {
    transform: translateX(200%);
}

.remove-book {
    position: absolute;
    right: 20px;
    top: 15px;
    z-index: 99;
    width: 26px;
    height: 26px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.remove-book svg {
    fill: #aaa;
    width: 20px;
    height: 20px;
}

.cart-book-number {
    box-sizing: border-box;
    position: absolute;
    right: 20px;
    bottom: 15px;
    z-index: 99;
    width: 80px;
    height: 26px;
    border: 1px solid #ccc;
    display: flex;
}


.cart-book-number div {
    box-sizing: border-box;
    width: 24px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.cart-book-number svg {
    fill: #aaa;
    width: 12px;
    height: 12px;
}

.number-minus {
    border-right: 1px solid #ccc;
}

.number-plus {
    border-left: 1px solid #ccc;
}

.svg-close {
    fill: #ccc;
}

.cart-book-number .number-show {
    color: #888;
    font-size: 12px;
    flex-grow: 1;
}

.cart-book-picture {
    position: absolute;
    left: 20px;
    z-index: 1111;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 66px;
    height: 100%;
    overflow: hidden;
}

.cart-book-picture img {
    width: 100%;
}

.cart-book-title {
    margin: 0 70px 10px 110px;
    padding-top: 15px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 14px;
}

.submit-require {
    position: absolute;
    bottom: 0;
    z-index: 9999;
    width: 100%;
    height: 40px;
    line-height: 40px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    background: #51c1f0;
    color: #fbfbfb;
}

.show-book-list {
    transform: scale(1);
    opacity: 1;
    z-index: 9999;
}
</style>

