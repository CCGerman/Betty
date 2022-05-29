import { createStore } from "vuex"
import auth from '../modules/auth/store/index.js'
import settings from '../modules/settings/store/index.js'

export const store = createStore({
    modules: {
        auth,
        settings
    }
})