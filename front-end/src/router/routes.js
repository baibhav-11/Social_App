const routes = [{
            path: '/',
            component: () =>
                import ('layouts/MainLayout.vue'),
            children: [{
                    path: '',
                    component: () =>
                        import ('pages/Homepage.vue')
                },
                {
                    path: '/ForgotPassword',
                    component: () =>
                        import ('pages/PageForgotPassword.vue')
                },
                {
                    path: '/login',
                    component: () =>
                        import ('src/pages/PageLogin.vue')
                },
                {
                    path: '/register',
                    component: () =>
                        import ('src/pages/PageRegister.vue')
                },
                {
                    path: '/reset-password',
                    component: () =>
                        import ('src/pages/PageResetPassword.vue')
                },
                // {
                //   path: '/Post',
                //   component: () =>
                //   import('pages/PagePost.vue')
                // }
            ]
        },
        {
            path: '/post',
            component: () =>
                import ('layouts/MainLayout.vue'),
            children: [{
                path: '',
                name: 'post',
                component: () =>
                    import ('src/pages/PagePost.vue')
            }],
            meta: { requiresAuth: true, name: 'Post' }
        },
    ]
    //Always kepp this at last one
if (process.env.MODE !== 'ssr') {
    routes.push({
        path: '*',
        component: () =>
            import ('pages/Error404.vue')
    })
}

export default routes