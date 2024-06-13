export default [
    {
        path: '/auth/login',
        name: 'auth.login',
        component: () => import("../../views/auth/LoginView.vue"),
        meta: {
            requiresAuth: false
        }
    }
]
