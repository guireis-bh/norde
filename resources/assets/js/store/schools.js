import endpoints from '../objects/endpoints'

/**
 * Service Vuex Component
 */
export default {
    state: {
        schools: [],
        lastLoad: {
            schools: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.schools
         * @param {object} state 
         * @param {object} schools 
         */
        SET_SCHOOLS(state, schools) {
            state.schools = schools
        }
    },
    actions: {
        /**
         * Carrega uma lista de escolas
         * 
         * @param {object} param0
         * @param {boolean} force
         */
        loadSchools({ commit, getters }, force) {
            if(getters.hasLoaded('schools', force)) {
                return
            }
            let endpoint = 'api.schools.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_SCHOOLS', res.data)
                    commit('SET_LAST_LOAD', 'schools')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        }
    },
    getters: {
        schools: store => store.schools
    }
}