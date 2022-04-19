require('./bootstrap');
import Vue from 'vue'
import { createApp } from 'vue'

import { router } from './router/index.js'
import HomeView from './views/HomeView.vue'

import { store } from './store/index'

const App = createApp(HomeView)
    .use(router)
    .use(store)
    .mount('#app-entry')