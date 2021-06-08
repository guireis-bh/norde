import endpoints from '../objects/endpoints'
let moment = require('moment')
let formatTime = 'MM-DD-YYYY H:m:s'

/**
 * Address Vuex component
 */
export default {
    state: {
        address: [],
        lastLoad: {
            address: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.address
         * @param {object} state 
         * @param {object} address Objeto address
         */
        SET_ADDRESS(state, address) {
            state.address = address
        }
    },
    actions: {
        /**
         * Carrega uma lista de esudantes
         * @param {object} param0 
         * @param {boolean} force
         */
        loadAddress({ commit, getters }, force) {
            if(getters.hasLoaded('address', force)) {
                return
            }
            let endpoint = 'api.address.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_ADDRESS', res.data)
                    commit('SET_LAST_LOAD', 'address')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria um endereço
         * @param {void} param0 
         * @param {object} address 
         */
        createAddress({}, address) {
            let endpoint = 'api.address.create'
            return axios.post(endpoints.get({endpoint}), address)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Atualiza um endereço
         * @param {void} param0 
         * @param {object} address 
         */
        updateAddress({}, address) {
            let endpoint = 'api.address.update'
            let params = {id: address.id}
            return axios.put(endpoints.get({endpoint, params}), address)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta um endereço
         * @param {void} param0 
         * @param {number} id 
         */
        deleteAddress({}, id) {
            let endpoint = 'api.address.delete'
            let params = {id: id}
            return axios.delete(endpoints.get({endpoint, params}))
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        }
    },
    getters: {
        address: store => store.address,
        addressByID: store => {
            return id => store.address.filter(the => the.id === id)[0]
        }
    }
}