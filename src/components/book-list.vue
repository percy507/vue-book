<template>
    <div class="book-list">
        <div class="book-list-container">
            <h1>我的书单</h1>
            <ul>
                <li v-for="(book,index) in books"
                    key="index">{{ book }}</li>
            </ul>
            <div class="submit-require"
                 @click="toggleBookList">确认提交</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'book-list',
    data: function () {
        return {
            books: []
        }
    },
    computed: {
        isShowBookList: function () {
            return this.$store.state.isShowBookList;
        },
        symbol: function () {
            return this.$store.state.symbol;
        }
    },
    methods: {
        toggleBookList: function () {
            this.$store.commit('TOGGLE_BOOK_LIST');
        }
    },
    watch: {
        isShowBookList: function () {
            let that = this;

            that.$el.classList.add('book-list-up');

            if (that.isShowBookList) {
                // 重置
                that.books = [];

                window.sessionStorage.forEach(function (ele) {
                    let title = ele.split(that.symbol)[0];

                    that.books.push(title);
                });
            }

            if (that.isShowBookList) {
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
.book-list {
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

.book-list-up {
    z-index: 99;
}

.book-list-out {
    transition: 0.4s;
}

.book-list-container {
    width: 100%;
    height: 100%;
    background: #F0F4C1;
    color: #6C3A27;

    overflow-y: auto;
}

.book-list-container h1 {
    text-align: center;
}

.book-list-container ul {
    padding: 0;
    margin: 0;
}

.book-list-container li {
    list-style: none;
    font-size: 1.2em;
    line-height: 1.6;
    margin-left: 20px;
}

.submit-require {
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

.show-book-list {
    transform: scale(1);
    opacity: 1;
    z-index: 9999;
}
</style>

