<template>
    <div class="overlay" @click="toggleSidebar">
    </div>
</template>

<script>
export default {
    name: 'overlay',
    computed: {
        isShowSidebar: function () {
            return this.$store.state.isShowSidebar
        }
    },
    methods: {
        toggleSidebar: function () {
            this.$store.commit('TOGGLE_SIDEBAR');
        }
    },
    watch: {
        isShowSidebar: function () {
            this.$el.classList.toggle('show-overlay');
        }
    }
}
</script>

<style lang="">
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    display: none;
    width: 100%;
    height: 100%;
    background: #ddd;
    opacity: 0.7;
}

.show-overlay {
    display: block;
}
</style>