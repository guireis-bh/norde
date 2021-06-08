import endpoints from '../objects/endpoints'

/**
 * Schedule Vuex component
 */
export default {
    state: {
        schedules: [],
        lastLoad: {
            schedules: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.schedules
         * @param {object} state 
         * @param {object} schedules Objeto schedules
         */
        SET_SCHEDULES(state, schedules) {
            state.schedules = schedules
        }
    },
    actions: {
        /**
         * Carrega uma lista de cronogramas
         * @param {object} param0 
         * @param {boolean} force
         */
        loadSchedules({ commit, getters }, force) {
            if(getters.hasLoaded('schedules', force)) {
                return
            }
            let endpoint = 'api.schedules.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_SCHEDULES', res.data)
                    commit('SET_LAST_LOAD', 'schedules')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Carrega uma lista de alunos de um cronograma
         * @param {object} param0
         * @param {integer} id
         */
        loadSchedulesStudants({ commit, getters }, id) {
            let endpoint = 'api.schedules_studants.index'
            let params = {id: id}
            return axios.get(endpoints.get({endpoint, params}))
                .then(res => {
                    if(res.status === 200) {
                        return res.data
                    }
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria um cronograma
         * @param {void} param0 
         * @param {object} schedule 
         */
        createSchedule({}, schedule) {
            let endpoint = 'api.schedules.create'
            return axios.post(endpoints.get({endpoint}), schedule)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria um aluno no cronograma
         * @param {void} param0 
         * @param {object} scheduleStudant
         */
        createScheduleStudant({}, scheduleStudant) {
            let endpoint = 'api.schedules_studants.create'
            let params = {id: scheduleStudant.schedule_id}
            return axios.post(endpoints.get({endpoint, params}), scheduleStudant)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Atualiza um cronograma
         * @param {void} param0 
         * @param {object} schedule 
         */
        updateSchedule({}, schedule) {
            let endpoint = 'api.schedules.update'
            let params = {id: schedule.id}
            return axios.put(endpoints.get({endpoint, params}), schedule)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Atualiza um cronograma do aluno
         * @param {void} param0 
         * @param {object} scheduleStudants
         */
        updateScheduleStudant({}, scheduleStudant) {
            let endpoint = 'api.schedules_studants.update'
            let params = {id: scheduleStudant.id}
            return axios.put(endpoints.get({endpoint, params}), scheduleStudant)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta um cronograma
         * @param {void} param0 
         * @param {number} id 
         */
        deleteSchedule({}, id) {
            let endpoint = 'api.schedules.delete'
            let params = {id: id}
            return axios.delete(endpoints.get({endpoint, params}))
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta um cronograma
         * @param {void} param0 
         * @param {number} id 
         */
        deleteScheduleStudant({}, id) {
            let endpoint = 'api.schedules_studants.delete'
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
        schedules: store => store.schedules,
        schedules_studants: store => store.schedules_studants,
        scheduleByTeacherID: store => {
            return id => store.schedules.filter(the => the.teacher_id == id)
        },
        schedulesStudantsByScheduleID: store => {
            return id => store.schedules_studants.filter(the => the.schedule_id == id)
        },
        schedulesStudantsByStudantID: store => {
            return id => store.schedules_studants.filter(the => the.studant_id == id)
        }
    }
}