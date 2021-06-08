import endpoints from '../objects/endpoints'

/**
 * Family Vuex Component
 */
export default {
    state: {
        families: [],
        lastLoad: {
            families: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.families
         * 
         * @param {object} state 
         * @param {object} families 
         */
        SET_FAMILIES(state, families) {
            state.families = families
        }
    },
    actions: {
        /**
         * Carrega uma lista de familias
         * 
         * @param {object} param0
         * @param {boolean} force
         */
        loadFamilies({ commit, getters }, force) {
            if(getters.hasLoaded('families', force)) {
                return
            }
            let endpoint = 'api.families.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_FAMILIES', res.data)
                    commit('SET_LAST_LOAD', 'families')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },

        /**
         * Cria uma nova familia
         * 
         * @param {*} family 
         */
        createFamily({}, family) {
            let endpoint = 'api.families.create'
            return axios.post(endpoints.get({endpoint}), family)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Atualiza uma familia
         * @param {void} param0 
         * @param {object} family 
         */
        updateFamily({}, family) {
            let endpoint = 'api.families.update'
            let params = {id: family.id}
            return axios.put(endpoints.get({endpoint, params}), family)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta uma familia
         * @param {void} param0 
         * @param {number} id 
         */
        deleteFamily({}, id) {
            let endpoint = 'api.families.delete'
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
        families: store => store.families,
        responsibles: store => {
            return id => store.families.filter(the => the.id == id)[0]
        },
        familyByID: store => {
            return id => store.families.filter(the => the.id == id)[0]
        }
    }
}