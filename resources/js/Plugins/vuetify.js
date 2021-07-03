import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/lib/util/colors'

Vue.use(Vuetify)

const opts = {
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
    theme: {
        // // default
        // themes: {
        //     light: {
        //         accent: "#82B1FF",
        //         error: "#FF5252",
        //         info: "#2196F3",
        //         primary: "#1976D2",
        //         secondary: "#424242",
        //         success: "#4CAF50",
        //         warning: "#FB8C00",
        //     },
        //     dark: {
        //         accent: "#FF4081",
        //         error: "#FF5252",
        //         info: "#2196F3",
        //         primary: "#2196F3",
        //         secondary: "#424242",
        //         success: "#4CAF50",
        //         warning: "#FB8C00",
        //     },
        // },
        // // end default
        // // bulma
        themes: {
            light: {
                primary: "#00d1b2",
                secondary: "#424242",
                success: "#4CAF50",
                warning: "#FB8C00",
                accent: "#82B1FF",
                error: "#FF5252",
                info: "#2196F3",
            },
            dark: {
                primary: colors.teal.accent4,
            },
        },
        // end bulma
    },
}

export default new Vuetify(opts)