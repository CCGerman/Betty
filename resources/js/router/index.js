import { createRouter, createWebHistory } from "vue-router"

import clients from '../modules/clients/router/clients.js'
import home from './home.js'
import appointments from '../modules/appointments/router/appointments.js'
import billing from './billing.js'
import settings from './settings.js'
import treatments from '../modules/treatments/router/treatments.js'
import products from '../modules/products/router/products.js'
import auth from '../modules/auth/router/auth.js'

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