export default [
    {
        path: '/login',
        name: 'login',
        component: () => import('../modules/auth/LoginView.vue'),
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
