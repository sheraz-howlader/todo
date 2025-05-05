import { defineStore } from 'pinia'

import state from "./state";
import actions from "./actions"; // Update this import

export const AuthStore = defineStore('auth', {
    state,
    actions,
})
