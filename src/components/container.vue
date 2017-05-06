<template>
    <section class="container">
        <overlay :isLoading="isLoading"></overlay>
        <loading :isLoading="isLoading"></loading>
        <input id="search-box" type="text" v-model.lazy="keyword">
        <vHeader></vHeader>
        <vContent v-bind:keyword="keyword.trim()"></vContent>
    </section>
</template>

<script>
import overlay from './overlay.vue';
import loading from './loading.vue';
import vHeader from './header.vue';
import vContent from './content.vue';

export default {
    name: 'container',
    data: function () {
        return {
            isLoading: false,
            keyword: ''
        }
    },
    computed: {
        isShowSidebar: function () {
            return this.$store.state.isShowSidebar
        }
    },
    components: {
        overlay,
        loading,
        vHeader,
        vContent
    },
    watch: {
        isShowSidebar: function () {
            this.$el.classList.toggle('slide');
        }
    }
}

</script>

<style>
.container {
    position: relative;
    left: 0;
    z-index: 5;
    height: 100%;
    padding-top: 56px;
    background: #FFF;
    transition: 0.8s;
}

.slide {
    transform: translateX(250px);
}

#search-box {
    box-sizing: border-box;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 11;
    width: calc(100% - 55px);
    height: 56px;
    border: 5px solid #03a9f4;
    background: #e4f6ff;
    padding: 3px 15px;
    font-size: 1.4em;
}

#search-box:focus {
    outline: none;
}
</style>