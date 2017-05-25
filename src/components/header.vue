<template>
    <div class="app-header">
        <header class="header">
            <span class="icon icon-menu"
                  @click="toggleSidebar">
                <svg version="1.1"
                     xmlns="http://www.w3.org/2000/svg"
                     width="32"
                     height="32"
                     viewBox="0 0 32 32">
                    <title>menu</title>
                    <path d="M2 6h28v6h-28zM2 14h28v6h-28zM2 22h28v6h-28z"></path>
                </svg>
            </span>
            <span class="icon icon-search"
                  @click="toggleSearch">
                <svg version="1.1"
                     xmlns="http://www.w3.org/2000/svg"
                     width="32"
                     height="32"
                     viewBox="0 0 32 32">
                    <title>search</title>
                    <path d="M31.008 27.231l-7.58-6.447c-0.784-0.705-1.622-1.029-2.299-0.998 1.789-2.096 2.87-4.815 2.87-7.787 0-6.627-5.373-12-12-12s-12 5.373-12 12 5.373 12 12 12c2.972 0 5.691-1.081 7.787-2.87-0.031 0.677 0.293 1.515 0.998 2.299l6.447 7.58c1.104 1.226 2.907 1.33 4.007 0.23s0.997-2.903-0.23-4.007zM12 20c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"></path>
                </svg>
            </span>
            <h1 @click="changeContent">教材一览</h1>
        </header>
        <input id="search-box"
               type="text"
               @focus="clearKeyword"
               @blur="toggleSearch"
               v-model.lazy="keyword">
    </div>
</template>

<script>

export default {
    name: 'header',
    data: function () {
        return {
            isFocus: false,
            keyword: ''
        }
    },
    methods: {
        toggleSidebar: function () {
            this.$store.commit('TOGGLE_SIDEBAR');
        },
        changeContent: function () {
            this.$store.commit('CHANGE_CONTENTTYPE', 'home');
        },
        clearKeyword: function () {
            this.keyword = '';
        },
        toggleSearch: function () {
            let searchBox = this.$el.querySelector('#search-box');
            let appHeader = this.$el.querySelector('.header');

            this.isFocus = this.isFocus ? false : true;

            if (this.isFocus) {
                searchBox.focus();
            } else {
                searchBox.value = '';
                searchBox.blur();
            }

            appHeader.classList.toggle('show-search');
            this.$store.commit('CHANGE_CONTENTTYPE', 'search');
        }
    },
    watch: {
        keyword: function () {
            this.$store.commit('CHANGE_KEYWORD', this.keyword);
        }
    }
}

</script>

<style lang="">
.header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 22;
    max-width: 800px;
    width: 100%;
    max-height: 50px;
    margin: 0 auto;
    background: #03a9f4;
    overflow: hidden;
    transition: 0.6s;
}

.header h1 {
    font-size: 2em;
    font-weight: bolder;
    font-family: title;
    opacity: 0.8;
    text-align: center;
    color: #FFF;
    margin: 7px 60px;
}

.icon {
    position: absolute;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
}

.icon-menu {
    left: 0;
}

.icon-search {
    right: 0;
    z-index: 11111;
}

svg {
    fill: #FFF;
    width: 26px;
    height: 26px;
}

.show-search {
    transform: translateX(calc(-100% + 60px));
}

#search-box {
    box-sizing: border-box;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 11;
    width: calc(100% - 55px);
    height: 50px;
    border: 5px solid #03a9f4;
    background: #e4f6ff;
    padding: 3px 15px;
    font-size: 1.4em;
}

#search-box:focus {
    outline: none;
}
</style>