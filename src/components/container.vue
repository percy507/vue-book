<template>
    <section class="container">
        <overlay></overlay>
        <vHeader></vHeader>
        <vContent></vContent>
    </section>
</template>

<script>
import overlay from './overlay.vue';
import vHeader from './header.vue';
import vContent from './content/content.vue';

export default {
    name: 'container',
    computed: {
        isShowSidebar: function () {
            return this.$store.state.isShowSidebar
        }
    },
    components: {
        overlay,
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
    padding-top: 50px;
    background: #FFF;
    transition: 0.6s;
}

.slide {
    transform: translateX(250px);
}
</style>