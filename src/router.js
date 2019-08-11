import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('./views/Index/'),
            children: [
                {
                    path: '/',
                    components: {
                        index_left: () => import('./views/Index/index_left.vue'),
                        index_right: () => import('./views/Index/index_right.vue'),
                    },
                },
                {
                    path: '/class/:cid',
                    components: {
                        index_left: () => import('./views/Index/index_left.vue'),
                        index_right: () => import('./views/Index/index_right.vue'),
                    },
                },
            ]
        },
        {
            path: '/admin/home',
            component: () => import('./views/Admin/'),
            children: [
                {
                    path: '/admin/home',
                    component: () => import('./views/Admin/Index/'),
                }, {
                    path: '/admin/user',
                    component: () => import('./views/Admin/Users/'),
                }, {
                    path: '/admin/Article',
                    component: () => import('./views/Admin/Article/'),
                }, {
                    path: '/admin/class',
                    component: () => import('./views/Admin/Class/'),
                }, {
                    path: '/admin/comment/:coid',
                    component: () => import('./views/Admin/Article/comment.vue'),
                },
            ]
        },
        {
            path: '/admin/',
            component: () => import('./views/Admin/Login'),
            name: 'Admin_login',
            meta: {
                title: '后台登陆程序',
            }
        },
        {
            path: '/join',
            component: () => import('./views/Login/'),

        },
        {
            path: '/login',
            component: () => import('./views/Login/login_and_reg.vue'),
            children: [
                {
                    path: '/login',
                    component: () => import('./views/Login/login.vue'),
                },
                {
                    path: '/register',
                    component: () => import('./views/Login/register.vue'),
                },
                {
                    path: '/read',
                    component: () => import('./views/Login/read.vue'),
                }
            ]
        },
        {
            path: '/article/:aid',
            component: () => import('./views/Content'),
            children: [
                {
                    path: '/article/:aid',
                    component: () => import('./views/Content/article_content'),
                },

            ]
        },

    ]
})
