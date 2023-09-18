import axios from 'axios'

import { LocalStorage as SessionStorage } from 'quasar'

export function Postcreate({ commit }, payload) {

    console.group("Form Data", payload)

    let formData = new FormData()
    if(payload.attachment){
        formData.append('attachment', payload.attachment)
        let type = payload.attachment.type.split("/");
        formData.append('type', type[0])
    }
    formData.append('name', payload.name)
    formData.append('detail', payload.detail)

    return new Promise((resolve, reject) => {
        axios
            .post('/posts', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            })
            .then(response => {
                this.dispatch('Post/Postget')
                resolve(true)
            })
            .catch(err => {
                reject(err)
            })
    })

}

export function Postget({ commit }, payload) {

    return new Promise((resolve, reject) => {
        axios
            .get("/posts", payload)
            .then(response => {
                commit('setPosts', response.data)
                resolve(true)
            })
            .catch(err => {
                reject(err)
            })
    })

}


export function like({ commit }, payload) {

    return new Promise((resolve, reject) => {
        axios
            .post("/like", payload)
            .then(response => {
                commit('setlike', response.data)
                resolve(true)
            })
            .catch(err => {
                reject(err)
            })
    })

}

export function dislike({ commit }, payload) {

    return new Promise((resolve, reject) => {
        axios
            .post("/dislike", payload)
            .then(response => {
                commit('disLike', response.data)
                resolve(true)
            })
            .catch(err => {
                reject(err)
            })
    })

}

export function comment({ commit }, payload) {

    return new Promise((resolve, reject) => {
        axios
            .post("/comment", payload)
            .then(response => {
                commit('comment', response.data)
                resolve(response)
            })
            .catch(err => {
                reject(err)
            })
    })
}

// export function reply({ commit }, payload) {

//     return new Promise((resolve, reject) => {
//         axios
//             .post("/comment", payload)
//             .then(response => {
//                 // commit('comment', response.data)
//                 resolve(response)
//             })
//             .catch(err => {
//                 reject(err)
//             })
//     })

// }
