import endpoints from '../objects/endpoints'

/**
 * Subjects Vuex component
 */
export default {
    state: {
        subjects: [],
        lastLoad: {
            subjects: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.subjects
         * @param {object} state 
         * @param {object} subjects Objeto subjects
         */
        SET_SUBJECTS(state, subjects) {
            state.subjects = subjects
        }
    },
    actions: {
        /**
         * Carrega assuntos
         * @param {object} param0 
         * @param {boolean} force 
         */
        loadSubjects({ commit, getters }, force) {
            if(getters.hasLoaded('subjects', force)) {
                return
            }
            let endpoint = 'api.subjects.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_SUBJECTS', res.data)
                    commit('SET_LAST_LOAD', 'subjects')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria um assunto
         * @param {void} param0 
         * @param {object} subject 
         */
        createSubjects({}, subject) {
            let endpoint = 'api.subjects.create'
            return axios.post(endpoints.get({endpoint}), subject)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria assuntos em massa
         * @param {void} param0 
         * @param {object} param1 
         */
        patchSubjects({}, {subjects, userID}) {
            let endpoint = 'api.subjects.patch'
            let params = {id: userID}
            return axios.patch(endpoints.get({endpoint, params}), subjects)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta um assunto
         * @param {void} param0 
         * @param {number} id 
         */
        deleteSubject({}, id) {
            let endpoint = 'api.subjects.delete'
            let params = {id: id}
            return axios.delete(endpoints.get({endpoint, params}))
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        getSubjectsByUser({}, userID) {
            let endpoint = 'api.subjects.getByUser'
            let params = {id: userID}
            return axios.get(endpoints.get({endpoint, params}))
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        }
    },
    getters: {
        subjects: store => store.subjects
    }
}