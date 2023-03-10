    import Vue from 'vue'
    import Router from 'vue-router'
    
    // in development-env not use lazy-loading, because lazy-loading too many pages will cause webpack hot update too slow. so only in production use lazy-loading;
    // detail: https://panjiachen.github.io/vue-element-admin-site/#/lazy-loading
    
    Vue.use(Router)
    
    /* Layout */
    import Layout from './pages/layout/Layout'
    import studentLayout from './pages/studentLayout/Layout'
    
    /**
    * hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
    * alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
    *                                if not set alwaysShow, only more than one route under the children
    *                                it will becomes nested mode, otherwise not show the root menu
    * redirect: noredirect           if `redirect:noredirect` will no redirct in the breadcrumb
    * name:'router-name'             the name is used by <keep-alive> (must set!!!)
    * meta : {
        title: 'title'               the name show in submenu and breadcrumb (recommend set)
        icon: 'svg-name'             the icon show in the sidebar,
    }
    **/
    export const constantRouterMap = [
        {
            path: '/admin',
            name: 'admin',
            hidden: true,
            component: Vue.component('authLayout', require('./pages/auth_layout.vue')),
            children: [
                {
                path: 'login',
                name: 'login',
                component: Vue.component('login', require('./components/login.vue')),
            },
            {
                path: 'security',
                name: 'security',
                component: Vue.component('security', require('./components/security.vue')),
            },
        
        // {
        //     path: '/404',
        //     component: Vue.'',require(ort ('./pages/404')),
        //     hidden: true
        // },
        {
                path: 'dashboard',
                name: 'Dashboard',
                component: Vue.component('dashboard',require ('./pages/dashboard/index')),
                 meta: {
                    title: 'Dashboard',
                    icon: 'tachometer'
                 },
                 
            }
    ]
        
        //     {
            //         path: '/example',
            //         component: Layout,
            //         redirect: '/example/table',
            //         name: 'Example',
            //         meta: {
                //             title: 'Example',
                //             icon: 'user'
                //         },
                //         children: [{
                    //             path: 'tables',
                    //             name: 'Tables',
                    //             component: Vue.component(  'table',require ('./pages/table/index')),
                    //             meta: {
                        //                 title: 'Table',
                        //                 icon: 'table'
                        //             }
                        //         },
                        //         {
                            //             path: 'tree',
                            //             name: 'Tree',
                            //             component: Vue.component(  'tree',require ('./pages/tree/index')),
                            //             meta: {
                                //                 title: 'Tree',
                                //                 icon: 'tree'
                                //             }
                                //         }
                                //     ]
                                // },
                                
                                // {
                                    //     path: '/form',
                                    //     component: Layout,
                                    //     children: [{
                                        //         path: 'index',
                                        //         name: 'Forms',
                                        //         component: Vue.component('form',require ('./pages/form/index')),
                                        //         meta: {
                                            //             title: 'Form',
                                            //             icon: 'file-text'
                                            //         }
                                            //     }]
                                            // },
                                        },
    {
        path: '/post',
        component: Layout,
        meta: {
            title: 'Posts',
            icon: 'user'
        },
        children: [{
            path: 'index',
            name: 'Posts',
            component: Vue.component('index', require('./pages/post/index')),
            meta: {
                title: 'Add Post',
                icon: 'file-text'
            }
        },
        {
            path: 'edit/:id',
            name: 'edit',
            component: Vue.component('edit', require('./pages/post/editPost')),
            hidden:true,
            // props: true,
            meta: {
                title: 'Edit Post',
                icon: 'file-text'
            }
        },
        {
                path: 'view',
                name: 'viewPosts',
                component: Vue.component('view', require('./pages/post/viewPosts')),
                meta: {
                    title: 'Manage',
                    icon: 'file-text'
                }
            }
    ]
    },
    {
        path: '/user',
        component: Layout,
        meta: {
            title: 'User',
            icon: 'user'
        },
        children: [{
                path: 'add',
                name: 'Add',
                component: Vue.component('user', require('./pages/user/addUser')),
                meta: {
                    title: 'Add User',
                    icon: 'user-plus'
                }
            },
        ]
    },
    {
        path: '/user',
            component: studentLayout,
            meta: {
                title: 'Student',
                icon: 'user',
                layout:studentLayout,
            },
            children: [{
                path: 'profile',
                name: 'profile',
                component: Vue.component('profile', require('./pages/user/addUser')),
                meta: {
                    title: 'Profile',
                    icon: 'user'
                }
            }, ]
    },
    
    
    // {
    //     path: '*',
    //     redirect: '/404',
    //     hidden: true
    // }
]

export default new Router({
    mode: 'history',
    scrollBehavior: () => ({
        y: 0
    }),
    routes: constantRouterMap
})
