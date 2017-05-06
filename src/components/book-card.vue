<template>
    <div class="book-card" @click="toggleCard">
        <div class="book-details">
            <div>书名：{{bookTitle}}</div>
            <div>作者：{{bookAuthor}}</div>
            <div>库存量：{{restNumber}}</div>
        </div>
        <figure>
            <img v-bind:src="picUrl">
        </figure>
    </div>
</template>

<script>
export default {
    name: 'book-card',
    props: ['bookTitle', 'bookAuthor', 'picUrl', 'restNumber'],
    methods: {
        toggleCard: function () {
            this.$store.commit('TOGGLE_CARD');
        }
    }
}
</script>

<style lang="stylus">
.book-card {
    box-sizing: border-box;
    position: fixed;
    max-width: 800px;
    width: 100%;
    height: 100%;
    z-index: 5;
    padding-bottom: 60px;
    background: rgba(228,246,255,0.9);
    backface-visibility: hidden;
    overflow-y: scroll;

    figure {
        width: 80%;
        margin: 0 auto;
    }

    figure img{
        width: 100%;
    }   
}

.book-details{
    box-sizing: border-box;
    width: 80%;
    margin: 0px auto;
    padding: 10px 0;
    
    div{
        line-height 1.6;
        font-size: 1.2em;
        font-weight: bold;
        color: rgb(3,169,244);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}
</style>