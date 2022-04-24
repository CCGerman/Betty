export default [
    {
        path: '/login',
        name: 'login',
        component: () => import('../views/LoginView.vue'),
        props: true
    },
    {
        path: '/logout',
        name: 'logout',
        component: {
            template: `
        <h3 class="py-5">Citas</h3>
        <router-view />
        `
        }
    }
]
