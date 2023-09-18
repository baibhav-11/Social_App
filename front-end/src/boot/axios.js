import axios from 'axios'

import { LocalStorage as SessionStorage } from 'quasar'

export default ({ Vue, router }) => {

    // Add a request interceptor
    axios.defaults.baseURL = "http://127.0.0.1:8000/api"

axios.interceptors.request.use(function(config) {
        // Do something before request is sent
        var token = SessionStorage.getItem('token');

        if (token === null) {
            let location = window.location.hash;
            var res1 = location.split("#/");
            var res2 = location.split("/");

            let allowedPath = ['/login', '/#/login', '/forget-password', '#/forget-password', '#/confirm-password-reset-code', '#/reset-password'];
            
            if (allowedPath.indexOf('#/'+res2[1]) === -1) {
                if(!res1 || res1[2]  == "undefined"){
                    // window.location.href = '/#/login?redirect_to='+window.location.hash
                    router.push({
                        path: '/',
                        query: { redirect: window.location.hash.substring(1) }
                    })
                }
            }
        } else {
            token = JSON.parse(token)
            if (token) {
                config.headers.Authorization = 'Bearer ' + token
            }
        }
        return config;
    });

    axios.interceptors.response.use(function(response) {
        return response;
    }, function(error) {

        if (401 === error.response.status) {
            SessionStorage.remove('token');
            // window.location.href = '/#/login?redirect='+window.location.hash
            // router.push(login)

            // console.log("window.location",window.location.hash)
            // console.log("window.location",window.location.hash.substring(1))

            // console.log("router", router);

            router.push({
                path: '/login',
                query: { redirect: window.location.hash.substring(1) }
            })
            
        } else {
            return Promise.reject(error);
        }

    });

    Vue.prototype.$axios = axios
    // axios.interceptors.request.use(function(config) {
    //     // Do something before request is sent
    //     var token = SessionStorage.getItem('token');

    //     if (token === null) {
    //         let location = window.location.hash;
    //         var res1 = location.split("#/");
    //         var res2 = location.split("/");

    //         let allowedPath = ['/login', '/#/login','/register', '/#/register'];

    //         if (allowedPath.indexOf('#/' + res2[1]) === -1) {
    //             if (!res1 || res1[2] == "undefined") {
    //                 router.push({
    //                     path: '/',
    //                     query: { redirect: window.location.hash.substring(1) }
    //                 })
    //             }
    //         }
    //     } else {
    //         token = JSON.parse(token)
    //         if (token) {
    //             config.headers.Authorization = 'Bearer ' + token
    //         }
    //     }

    //     return config;
    // });

    // axios.interceptors.response.use(function(response) {
    //     return response;
    // }, function(error) {

    //     if (401 === error.response.status) {
    //         SessionStorage.remove('token');

    //         router.push({
    //             path: '/login',
    //             query: { redirect: window.location.hash.substring(1) }
    //         })

    //     } else {
    //         return Promise.reject(error);
    //     }

    // });

    Vue.prototype.$axios = axios
}