import endpoints from '../objects/endpoints'

/**
 * Service Vuex Component
 */
export default {
    state: {
        services: [],
        lastLoad: {
            services: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.services
         * @param {object} state 
         * @param {object} services 
         */
        SET_SERVICES(state, services) {
            state.services = services
        }
    },
    actions: {
        /**
         * Carrega uma lista de serviços
         * @param {object} param0
         * @param {boolean} force
         */
        loadServices({ commit, getters }, force) {
            if(getters.hasLoaded('services', force)) {
                return
            }
            let endpoint = 'api.services.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_SERVICES', res.data)
                    commit('SET_LAST_LOAD', 'services')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        }
    },
    getters: {
        services: store => store.services
    }
}