<template>
    <div id="app">
        <vMenu></vMenu>
        <vContainer></vContainer>
    </div>
</template>

<script>
import vMenu from './components/menu.vue';
import vContainer from './components/container.vue';

export default {
    name: 'app',
    components: {
        vMenu,
        vContainer
    }
} 
</script>
    
<style>
html,
body,
#app {
    height: 100%;
}

body {
    margin: 0;
}

#app {
    position: relative;
    left: 0;
    z-index: 5;
    height: 100%;
    background: #FFF;
    max-width: 800px;
    min-width: 300px;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
}
</style>