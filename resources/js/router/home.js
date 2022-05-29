import Logged from "../modules/auth/components/Logged.vue"

export default {
    path: '/',
    name: 'home',
    component: {
        template: `
        <h3 class="py-5">Home</h3>
        <h4>En construcción</h4>
        <logged />
        <router-view />
        `,
        components: {
            Logged
        }
    },
}
