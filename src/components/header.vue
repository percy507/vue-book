<template>
    <header class="app-header">
        <span class="icon icon-menu" @click="toggleSidebar"></span>
        <span class="icon icon-search" v-on:click="toggleSearch"></span>
        <h1 @click="changeContent">教材一览</h1>
    </header>
</template>

<script>

export default {
    name: 'header',
    data: function () {
        return {
            isFocus: false
        }
    },
    methods: {
        toggleSidebar: function () {
            this.$store.commit('TOGGLE_SIDEBAR');
        },
        changeContent: function () {
            this.$store.commit('CHANGE_CONTENTTYPE', 'home');
        },
        toggleSearch: function () {
            this.isFocus = this.isFocus ? false : true;

            let searchBox = document.getElementById('search-box');
            if (this.isFocus) {
                searchBox.focus();
            } else {
                searchBox.blur();
            }

            this.$el.classList.toggle('show-search');
            this.$store.commit('CHANGE_CONTENTTYPE', 'search');
        }
    }
}

</script>

<style lang="">
.app-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 22;
    max-width: 800px;
    width: 100%;
    min-height: 50px;
    margin: 0 auto;
    background: #03a9f4;
    overflow: hidden;
    transition: 0.6s;
}

.app-header h1 {
    font-size: 2em;
    font-weight: bolder;
    font-family: title;
    opacity: 0.8;
    text-align: center;
    color: #FFF;
    margin: 10px 60px;
}

.icon {
    position: absolute;
    display: block;
    width: 60px;
    height: 50px;
    font-size: 1.6em;
    line-height: 50px;
    text-align: center;
    color: #FFF;
}

.icon-menu {
    left: 0;
}

.icon-search {
    right: 0;
    z-index: 11111;
}

.show-search {
    transform: translateX(calc(-100% + 60px));
}
</style>