import endpoints from '../objects/endpoints'
import FormatMoney from '../objects/format_money'
let deepmerge = require('deepmerge')

/**
 * Studant Vuex component
 */
export default {
    state: {
        studants: [],
        lastLoad: {
            studants: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.studants
         * @param {object} state 
         * @param {object} studant Objeto studants
         */
        SET_STUDANTS(state, studants) {
            state.studants = []
            studants.forEach(el => {
                el.payment_value = el.payment_value.toFixed(2)
                state.studants.push(el)
            });
        }
    },
    actions: {
        /**
         * Carrega uma lista de esudantes
         * @param {object} param0 
         * @param {boolean} force
         */
        loadStudants({ commit, getters }, force) {
            if(getters.hasLoaded('studants', force)) {
                return
            }
            let endpoint = 'api.studants.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_STUDANTS', res.data)
                    commit('SET_LAST_LOAD', 'studants')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria um estudante
         * @param {void} param0 
         * @param {object} studant 
         */
        createStudant({}, studant) {
            studant = deepmerge(
                studant,
                {payment_value: FormatMoney.toFloat(studant.payment_value)}
            )
            let endpoint = 'api.studants.create'
            return axios.post(endpoints.get({endpoint}), studant)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Atualiza um estudante
         * @param {void} param0 
         * @param {object} studant 
         */
        updateStudant({}, studant) {
            studant = deepmerge(
                studant,
                {payment_value: FormatMoney.toFloat(studant.payment_value)}
            )
            let endpoint = 'api.studants.update'
            let params = {id: studant.id}
            return axios.put(endpoints.get({endpoint, params}), studant)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta um estudante
         * @param {void} param0 
         * @param {number} id 
         */
        deleteStudant({}, id) {
            let endpoint = 'api.studants.delete'
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
        studants: store => store.studants,
        studantByID: store => {
            return id => store.studants.filter(the => the.id == id)[0]
        },
    }
}