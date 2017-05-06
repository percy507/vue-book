import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    isShowSidebar: false,
    isLoading: false,
    contentType: 'home',
    isShowCard: false
};

const mutations = {
    TOGGLE_SIDEBAR(state) {
        state.isShowSidebar = state.isShowSidebar ? false : true;
    },
    TOGGLE_LOADING(state) {
        state.isLoading = state.isLoading ? false : true;
    },
    CHANGE_CONTENTTYPE(state, type) {
        state.contentType = type;
    },
    TOGGLE_CARD(state) {
        state.isShowCard = state.isShowCard ? false : true;
    },
}

export default new Vuex.Store({
    state,
    mutations
})