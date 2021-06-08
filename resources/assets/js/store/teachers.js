import endpoints from '../objects/endpoints'
let moment = require('moment')
let formatTime = 'MM-DD-YYYY H:m:s'
/**
 * Family Vuex Component
 */
export default {
    state: {
        teachers: [],
        lastLoad: {
            teacher: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.teachers
         * 
         * @param {object} state 
         * @param {object} teachers 
         */
        SET_TEACHERS(state, teachers) {
            state.teachers = teachers
            state.lastLoad.teacher.time = moment().format(formatTime).toString()
        }
    },
    actions: {
        /**
         * Carrega uma lista de professores
         * @param {object} param0
         * @param {boolean} force
         */
        loadTeachers({ commit, state }, force) {
            if(force !== true) {
                let diff = moment().diff(
                    moment(state.lastLoad.teacher.time, formatTime),
                    'minutes'
                )
                if(diff < state.lastLoad.teacher.interval) {
                    return
                }
            }
            let endpoint = 'api.teachers.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_TEACHERS', res.data)
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },
    },
    getters: {
        teachers: store => store.teachers,
        teacherByID: store => {
            return id => store.teachers.filter(the => the.id == id)[0]
        }
    }
}