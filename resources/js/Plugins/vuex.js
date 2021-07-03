import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex)
const store = new Vuex.Store({
    state: {
        count: 0,
        FileDrawerNav: false,
        FileBucket: Array,
        DetailDrawerDialog: false
    },
    mutations: {
        increment(state) {
            state.count++
        },
        stateFileDrawerNav(state) {
            state.FileDrawerNav = !state.FileDrawerNav
            if (state.FileDrawerNav === false) {
                state.FileBucket = null
            }
        },
        stateFileBucket(state, { model, id, item }) {
            const activebucket = {
                model: model, id:id
            }
            state.FileBucket = activebucket
        },
        stateDetailDrawerDialog(state) {
            state.DetailDrawerDialog = !state.DetailDrawerDialog
        }
    }
})
export default store