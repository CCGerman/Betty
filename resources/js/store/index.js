import { createStore } from "vuex"
import auth from '../modules/auth/store/index.js'

export const store = createStore({
    modules: {
        auth
    }
})