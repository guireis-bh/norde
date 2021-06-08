let moment = require('moment')
let formatTime = 'MM-DD-YYYY H:m:s'

export default {
    mutations: {
        SET_LAST_LOAD(state, who) {
            state.lastLoad[who].time = moment().format(formatTime).toString()
        },
        /**
         * Limpa o state do VueJS
         * @param {*} state 
         */
        CLEAR_STATE(state) {
            Object.keys(state).forEach(key => {
                if(key !== 'lastLoad') {
                    state[key] = state[key].hasOwnProperty('length') ? [] : {}
                    if(state.lastLoad.hasOwnProperty(key)) {
                        state.lastLoad[key].time = null
                    }
                }
            })
        }
    },
    getters: {
        /**
         * Valida se é necessário carregar os dados via API
         */
        hasLoaded: store => {
            return (what, force = false) => {
                if(force !== true) {
                    let diff = moment().diff(
                        moment(store.lastLoad[what].time, formatTime),
                        'minutes'
                    )
                    if(diff < store.lastLoad[what].interval) {
                        return true
                    }
                }
                return false
            }
        }
    }
}