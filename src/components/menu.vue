<template>
    <section class="menu-list">
        <h1>分类</h1>
        <ul>
            <li class="book-species" v-for="(item,index) in Object.keys(menu_list)" v-on:click="changeContent($event)">
                <span>{{item}}</span>
            </li>
        </ul>
    </section>
</template>

<script>
export default {
    name: 'menu',
    data() {
        return {
            menu_list: {
                '公共课': 'public_class',
                '编程': 'programming',
                '电路电子': 'electric',
                '其它': 'other_books'
            }
        }
    },
    methods: {
        changeContent: function (e) {
            let type = this.menu_list[e.target.innerText.trim()];
            this.$store.commit('TOGGLE_SIDEBAR');
            this.$store.commit('CHANGE_CONTENTTYPE', type);
        }
    }
}
</script>

<style lang="stylus">
.menu-list
    box-sizing: border-box;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    width: 250px;
    height: 100%;
    padding-top: 100px;
    background: #333;
    transition: 1s;

    h1 {
        text-align: center;
        font-size: 2em;
        color: #FFF;
    }

    ul {
        padding: 0;
    }

    li {
        font-size: 1.4em;
        font-weight: bolder;
        color: #a6adb3;
        line-height: 2.4;
        list-style: none;
        margin-top: 10px;
        border-bottom: 2px solid #a6adb3;
    }

    li span {
        color: #fff;
        margin-left: 40px;
    }
</style>