import endpoints from '../objects/endpoints'
import FormatMoney from '../objects/format_money'
let deepmerge = require('deepmerge')

/**
 * Employee Vuex Component
 */
export default {
    state: {
        employees: [],
        employeeTypes: [],
        lastLoad: {
            employees: {
                time: null,
                interval: 5
            },
            employeeTypes: {
                time: null,
                interval: 120
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.employees
         * 
         * @param {object} state 
         * @param {object} employees 
         */
        SET_EMPLOYEES(state, employees) {
            state.employees = []
            employees.forEach(el => {
                el.salary = el.salary.toFixed(2)
                state.employees.push(el)
            });
        },
        /**
         * Seta o @var state.employeeTypes
         * 
         * @param {object} state 
         * @param {object} employeeTypes 
         */
        SET_EMPLOYEE_TYPES(state, employeeTypes) {
            state.employeeTypes = employeeTypes
        }
    },
    actions: {
        /**
         * Carrega uma lista de funcionarios
         * @param {object} param0
         * @param {boolean} force
         */
        loadEmployees({ commit, getters }, force) {
            if(getters.hasLoaded('employees', force)) {
                return
            }
            let endpoint = 'api.employees.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_EMPLOYEES', res.data)
                    commit('SET_LAST_LOAD', 'employees')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Carrega os tipos de funcionários e seus valores padrões
         * @param {object} param0 
         * @param {boolean} force
         */
        loadEmployeeTypes({ commit, getters }, force) {
            if(getters.hasLoaded('employeeTypes', force)) {
                return
            }
            let endpoint = 'api.employeeTypes.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_EMPLOYEE_TYPES', res.data)
                    commit('SET_LAST_LOAD', 'employeeTypes')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria um novo funcionario
         * 
         * @param {void} param0 
         * @param {object} employee 
         */
        createEmployee({}, employee) {
            employee = deepmerge(
                employee,
                {salary: FormatMoney.toFloat(employee.salary)}
            )
            let endpoint = 'api.employees.create'
            return axios.post(endpoints.get({endpoint}), employee)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Update um novo funcionario
         * 
         * @param {void} param0 
         * @param {object} employee 
         */
        updateEmployee({}, employee) {
            employee = deepmerge(
                employee,
                {salary: FormatMoney.toFloat(employee.salary)}
            )
            let endpoint = 'api.employees.update'
            let params = {id: employee.id}
            return axios.put(endpoints.get({endpoint, params}), employee)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta um funcionário
         * @param {void} param0 
         * @param {number} id 
         */
        deleteEmployee({}, id) {
            let endpoint = 'api.employees.delete'
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
        employees: store => store.employees,
        employeeTypes: store => store.employeeTypes,
        employeeByID: store => {
            return id => store.employees.filter(the => the.id == id)[0]
        },
        employeeTypeByID: store => {
            return id => store.employeeTypes.filter(the => the.id == id)[0]
        }
    }
}