import VueRouter from 'vue-router'
import helper from './services/helper'
let routes = [{
        path: '/',
        component: require('./layouts/index/pages.vue'),
        name: 'index',
    },
    {
        path: '/view/:id',
        name: 'view',
        props: true,
        component: require('./views/pages/show.vue')
    },
    {
        path: '/',
        component: require('./layouts/default-page'),
        meta: {
            requiresAuth: true,
            adminAuth: true,
            userAuth: false

        },
        children: [
            // {
            //     path: '/',
            //     component: require('./views/pages/home')
            // },
            {
                path: '/home',
                component: require('./views/pages/home')
            },
            {
                path: '/blank',
                component: require('./views/pages/blank')
            },
            {
                path: '/excel',
                component: require('./views/excel')
            },
            {
                path: '/single',
                component: require('./views/excel/single')
            },
            {
                path: '/configuration',
                component: require('./views/configuration/configuration')
            },
            {
                path: '/post',
                component: require('./views/post/index'),
            },
            {
                path: '/post/:id/edit',
                component: require('./views/post/edit')
            },
            {
                path: '/post/:id',
                component: require('./views/post/show')
            },
            {
                path: 'all',
                component: require('./views/post/viewPosts')
            },
            {
                path: '/task',
                component: require('./views/task/index')
            },
            {
                path: '/task/:id/edit',
                component: require('./views/task/edit')
            },
            {
                path: '/user',
                component: require('./views/user/index')
            },
        ]
    },
    {
        path: '/',
        component: require('./layouts/user/default-page'),
        meta: {
            requiresAuth: true,
            userAuth: true,
            adminAuth: false
        },
        children: [
            // {
            //     path: '/',
            //     component: require('./views/pages/home')
            // },
            {
                path: '/userlogin',
                component: require('./views/pages/home')
            },
        ]
    },
     {
         path: '/',
         component: require('./layouts/tnc/default-page'),
         meta: {
             requiresAuth: true,
             userAuth: false,
             adminAuth: false,
             userloginAuth:true
         },
         children: [
             {
                 path: '/terms',
                 component: require('./views/student/tnc')
             },
         ]
     },

    // {
    //     path: '/',
    //     component: require('./layouts/login-security/auth_layout'),
    //     // meta: { requiresAuth: true },
    //     children: [{
    //             path: '/login',
    //             component: require('./views/authenticate/login')
    //         },
    //         {
    //             path: '/security',
    //             component: require('./views/authenticate/security')
    //         },
    //     ]
    // },
    {
        path: '/',
        component: require('./layouts/guest-page'),
        meta: {
            requiresGuest: true
        },
        children: [{
                path: '/login',
                component: require('./views/auth/login')
            },

            // {
            //     path: '/password',
            //     component: require('./views/auth/password')
            // },
            {
                path: '/register',
                component: require('./views/auth/register')
            },
            // {
            //     path: '/auth/:token/activate',
            //     component: require('./views/auth/activate')
            // },
            // {
            //     path: '/password/reset/:token',
            //     component: require('./views/auth/reset')
            // },
            // {
            //     path: '/auth/social',
            //     component: require('./views/auth/social-auth')
            // },
        ]
    },
    {
        path: '*',
        component: require('./layouts/error-page'),
        children: [{
            path: '*',
            component: require('./views/errors/page-not-found')
        }]
    }
];

const router = new VueRouter({
    routes,
    linkActiveClass: 'active',
    mode: 'history'
});

router.beforeEach((to, from, next) => {

    if (to.matched.some(m => m.meta.requiresAuth)) {
        return helper.check().then(response => {
            if (!response) {
                return next({
                    path: '/login'
                })
            } else if (to.matched.some(m => m.meta.adminAuth)) {
                return helper.authUser().then(res => {
                    if (res.type == "EXECUTIVE_MEMBER") {
                        return next()
                    } else {
                        return next({
                            path: '/userlogin'
                        })
                    }
                })
            } else if (to.matched.some(m => m.meta.userAuth)) {
                return helper.authUser().then(res => {
                    if (res.type == "STUDENT") {
                        if (res.form_status == "N.A.") {
                            return next({
                                path:'/terms'
                            })
                        }
                        return next()
                    } else {
                        return next({
                            path: '/home'
                        })
                    }
                })
            }
                else if (to.matched.some(m => m.meta.userloginAuth)) {
                    return helper.authUser().then(res => {
                        if (res.type == "STUDENT" ) {
                            if ( res.form_status == "N.A.") {
                                return next()
                            }
                            return next({
                                path:'/userlogin'
                            })
                        } else {
                            return next({
                                path: '/home'
                            })
                        }
                    })
            } else {
                return next()
            }
        })
    }
    //  if (to.matched.some(m => m.meta.requiresAuth)) {
    //      return helper.check().then(response => {
    //          if (!response) {
    //              return next({
    //                  path: '/login'
    //              })
    //         }
    //             //  else{
    //                 //  }

    //          return next()
    //      })
    //  }

    if (to.matched.some(m => m.meta.requiresGuest)) {
        return helper.check().then(response => {
            if (response) {
                //  return next({
                //  path: '/userlogin'
                // })
                return helper.authUser().then(res => {
                    if (res.type == "EXECUTIVE_MEMBER") {
                        return next({
                            path: '/home'
                        })

                    } else {
                        return next({
                            path: '/userlogin'
                        })
                    }
                })
            }

            return next()
        })
    }

     return next()
});

export default router;