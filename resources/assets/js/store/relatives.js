import endpoints from '../objects/endpoints'

/**
 * Family Vuex Component
 */
export default {
    state: {
        relatives: [],
        lastLoad: {
            relatives: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.relatives
         * 
         * @param {object} state 
         * @param {object} relatives 
         */
        SET_RELATIVES(state, relatives) {
            state.relatives = relatives
        }
    },
    actions: {
        /**
         * Carrega uma lista de familiares
         * 
         * @param {object} param0
         * @param {boolean} force
         */
        loadRelatives({ commit, getters }, force) {
            if(getters.hasLoaded('services', force)) {
                return
            }
            let endpoint = 'api.relatives.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_RELATIVES', res.data)
                    commit('SET_LAST_LOAD', 'services')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },

        /**
         * Cria um novo familiar
         * 
         * @param {*} param0 
         * @param {*} relative 
         */
        createRelative({}, relative) {
            let endpoint = 'api.relatives.create'
            return axios.post(endpoints.get({endpoint}), relative)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Update um familiar
         * 
         * @param {void} param0 
         * @param {object} relative 
         */
        updateRelative({}, relative) {
            let endpoint = 'api.relatives.update'
            let params = {id: relative.id}
            return axios.put(endpoints.get({endpoint, params}), relative)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta um familiares
         * @param {void} param0 
         * @param {number} id 
         */
        deleteRelative({}, id) {
            let endpoint = 'api.relatives.delete'
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
        relatives: store => store.relatives,
        relativeByID: store => {
            return id => store.relatives.filter(the => the.id == id)[0]
        },
    }
}