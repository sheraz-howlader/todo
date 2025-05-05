import {createRouter, createWebHistory} from "vue-router";
import {AuthStore} from "@/stores/modules/auth";

const routes = [
    {
        path: '/',
        name: 'login',
        component: () => import('../components/Login.vue'),
    },
    {
        path: '/todo',
        name: 'todo',
        component: () => import('../components/ToDo.vue'),
        meta: {
            auth: true
        }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const isAuthenticated = AuthStore().hasToken;
    const requiresAuth = to.matched.some(record => record.meta.auth);

    if (to.path === '/' && isAuthenticated) {
        next('/todo')
            console.log('You are logged in')
        return;
    }

    if (requiresAuth && !isAuthenticated) {
        next('/')
            console.log('please login first')
        return;
    }
    next();
});

export default router
