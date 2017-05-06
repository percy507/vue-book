<template>
    <div class="loading" v-show="show">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'loading',
    data: function () {
        return {
            show: false
        }
    },
    computed: {
        isLoading: function () {
            return this.$store.state.isLoading;
        }
    },
    watch: {
        isLoading: function () {
            this.show = this.show ? false : true;
        }
    }
}
</script>

<style>
.loading {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 9;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(222, 222, 222, 0.3);
}

.spinner {
    position: relative;
    top: -70px;
    width: 60px;
    height: 60px;
}

.double-bounce1,
.double-bounce2 {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #333;
    opacity: 0.6;
    position: absolute;
    top: 0;
    left: 0;

    -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
    animation: sk-bounce 2.0s infinite ease-in-out;
}

.double-bounce2 {
    -webkit-animation-delay: -1.0s;
    animation-delay: -1.0s;
}

@-webkit-keyframes sk-bounce {
    0%,
    100% {
        -webkit-transform: scale(0.3)
    }
    50% {
        -webkit-transform: scale(1.0)
    }
}

@keyframes sk-bounce {
    0%,
    100% {
        transform: scale(0.3);
        -webkit-transform: scale(0.3);
    }
    50% {
        transform: scale(1.0);
        -webkit-transform: scale(1.0);
    }
}
</style>