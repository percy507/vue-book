<template>
    <div class="book-item">
        <figure @click="toggleCard">
            <img v-bind:src="picUrl"> </figure>
        <div class="rest-number">库存量：
            <span>{{restNumber}}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'book-item',
    props: ['bookTitle', 'bookAuthor', 'picUrl', 'restNumber'],
    methods: {
        toggleCard: function () {
            this.$store.commit('TOGGLE_CARD');
        }
    }
} 
</script>

<style lang="stylus">
.book-item {
    box-sizing: border-box;
    width: 50%;
    padding: 20px;
    display: inline-block;
    opacity: 0;
    transform: scale(0.6);
    transition: 0.5s;
}

.show {
    transform: scale(1);
    opacity: 1;
}

.book-item figure {
    margin: 0;
}

.book-item img {
    width: 100%;
}

.rest-number {
    text-align: center;
    font-size: 1.2em;
    font-weight: bold;
    line-height: 1.8;
    color: #666;
}



/*
.book-item:nth-child(odd) .rest-number {    
    border-right: 3px solid #03a9f4;
}
.book-item:nth-child(even) .rest-number {   
    border-left: 3px solid #03a9f4;
}
*/

.rest-number span {
    color: #03a9f4;
}
</style>