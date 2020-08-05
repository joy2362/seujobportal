// src/plugins/vuetify.js

import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import { TiptapVuetifyPlugin } from 'tiptap-vuetify'
import 'tiptap-vuetify/dist/main.css'
import 'vuetify/dist/vuetify.min.css'
const vuetify = new Vuetify()
Vue.use(Vuetify)

const opts = {}
Vue.use(TiptapVuetifyPlugin, {
    vuetify,
    iconsGroup: 'mdi'
})
export default new Vuetify({
    icons: {
        iconfont: 'mdi',
    },
})
