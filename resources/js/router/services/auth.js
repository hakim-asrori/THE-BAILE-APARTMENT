export default [
    {
        path: '/sign',
        name: 'auth.login',
        component: () => import("../../core/AuthCore.vue"),
        meta: {
            requiresAuth: false
        }
    }
]
