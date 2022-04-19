import { createRouter, createWebHistory } from "vue-router"

import clients from './clients.js'
import home from './home.js'
import appointments from './appointments.js'
import billing from './billing.js'
import settings from './settings.js'
import treatments from './treatments.js'
import products from './products.js'
import auth from './auth.js'

const notFound = { 
    path: '/:pathMatch(.*)*', 
    name: 'NotFound', 
    component: {
        template: '<h3 class="py-5">Not found</h3>'
    } 
}

const routes = [
    home,
    clients,
    appointments,
    billing,
    settings,
    treatments,
    products,
    ...auth,
    notFound
]

export const router = createRouter({
    history: createWebHistory('/'),
    routes
})