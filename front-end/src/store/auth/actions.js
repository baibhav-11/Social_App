import axios from 'axios'

import { LocalStorage as SessionStorage, Loading} from 'quasar'

export function login({ commit }, payload) {
    Loading.show()

    return new Promise((resolve, reject) => {
        axios
            .post("/login", payload)
            .then(response => {

                SessionStorage.set('token', JSON.stringify(response.data.token))
                SessionStorage.set('authUserData', JSON.stringify(response.data.authUser))

                commit('setAuthUser', response.data.authUser)

                resolve(true)
            })
            .catch(err => {
                Loading.hide()
                reject(err)
            })
    })

}


export function logout({ commit }, payload) {
    Loading.show()
    return new Promise((resolve, reject) => {
        axios
        .get("/logout", payload)
        .then(response => {
                Loading.hide()
                SessionStorage.remove('token')
                SessionStorage.remove('authUserData')
                resolve(true)
            })
            .catch(err => {
                Loading.hide()
                reject(err)
            })
    })
}


// Check User is authorized or not
export function checkAuthUser({ context, state }) {

    return new Promise((resolve, reject) => {
        var token = JSON.parse(SessionStorage.getItem('token'))
        var authUserData = JSON.parse(SessionStorage.getItem('authUserData'))

        if (token === null) {
            reject(false)
        } else {
            if (state.authUser.id === undefined || authUserData === null) {

                this.dispatch('auth/fetchAuthUser')
                    .then(res => {
                        resolve(res.data)
                    })
                    .catch(err => {
                        console.log("ERROR fetchAuthUser", err)
                    })
            } else
                resolve(token)
        }
    })
}

export function register({ commit }, payload) {
    Loading.show()

    let formData = new FormData()
    if(payload.attachment){
        formData.append('attachment', payload.attachment)
    }
    formData.append('first_name', payload.first_name)
    formData.append('last_name', payload.last_name)
    formData.append('email', payload.email)
    formData.append('password', payload.password)
    formData.append('c_password', payload.c_password)

    return new Promise((resolve, reject) => {
        axios
            .post("/register", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            })
            .then(response => {
                Loading.hide()
                resolve(true)
            })
            .catch(err => {
                Loading.hide()
                reject(err)
            })
    })

}
export function forgotpassword({ commit }, payload) {
    Loading.show()

    console.log("payload", payload)

    return new Promise((resolve, reject) => {
        axios
            .post("/forgot-password", payload)
            .then(response => {
                Loading.hide()

                console.log("Response ", response)
                
                
                resolve(response)
            })
            .catch(err => {
                Loading.hide()
                reject(err)
            })
    })

}

export function resetpassword({ commit }, payload) {
    Loading.show()

    console.log("payload", payload)

    return new Promise((resolve, reject) => {
        axios
            .post("/reset-password", payload)
            .then(response => {
                Loading.hide()

                console.log("Response ", response)
                
                
                resolve(response)
            })
            .catch(err => {
                Loading.hide()
                reject(err)
            })
    })

}


export function fetchAuthUser({ state, commit }) {
    return new Promise((resolve, reject) => {
        axios
        .get("/authuser")
            .then(response => {
                SessionStorage.set('authUserData', JSON.stringify(response.data))
                commit('setAuthUser', response.data)
                resolve(response)
            })
            .catch(err => {
                reject(err)
            })
    })
}
