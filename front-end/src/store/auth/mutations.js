import { Loading } from "quasar"

export function setAuthUser(state, payload) {
    Loading.hide()

    state.authUser = payload

}