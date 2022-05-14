import Logged from "../modules/auth/components/Logged.vue"

export default {
    path: '/facturacion',
    name: 'billing',
    component: {
        template: `
        <h3 class="py-5">Facturacion</h3>
        <h4>En construcción</h4>
        <logged />
        <router-view />
        `,
        components: {
            Logged

        }
    }
}