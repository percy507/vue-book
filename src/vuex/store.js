import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    isShowSidebar: false,
    isLoading: false,
    contentType: 'home',
    symbol: '_&_', // 定义分割书名和作者名的标识符，标识符必须唯一并且不被包含于书名或作者名中
    keyword: '',
    isShowCard: false,
    isShowLogin: true,
    isShowHelp: false,
    isShowBookList: false,
    // user 对象用来存储登录成功后从服务器接收到的数据
    user: {
        phone_number: '',
        name: '',
        id_number: '',
        academy: '',
        address: ''
    },
    user_state: ''
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
    CHANGE_KEYWORD(state, keyword) {
        state.keyword = keyword;
    },
    TOGGLE_CARD(state) {
        state.isShowCard = state.isShowCard ? false : true;
    },
    TOGGLE_LOGIN_PAGE(state) {
        state.isShowLogin = state.isShowLogin ? false : true;
    },
    CHANGE_USER_STATE(state, user_state) {
        state.user_state = user_state;
    },
    TOGGLE_HELP(state) {
        state.isShowHelp = state.isShowHelp ? false : true;
    },
    TOGGLE_BOOK_LIST(state) {
        state.isShowBookList = state.isShowBookList ? false : true;
    }
}

export default new Vuex.Store({
    state,
    mutations
})