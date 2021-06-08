import endpoints from '../objects/endpoints'
import config from '../config/default.js'
const merge = require('deepmerge')

/**
 * User Vuex component
 */

export default {
    state: {
        user: {
        },
        users: [],
        lastLoad: {
            users: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Metodo adaptado p/ setar a resposta da API
         * @param {object} state 
         * @param {object} data 
         */
        SET_AUTH_USER(state, data) {
            state.user = {
                created_at: data.created_at,
                email: data.email,
                id: data.id,
                name: data.name,
                updated_at: data.updated_at,
                oauth: data.oauth
            }
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.oauth.access_token
        },
        /**
         * 
         * @param {*} state 
         * @param {*} permissions 
         */
        SET_USER_PERMISSIONS(state, permissions) {
            state.user.permissions = permissions
        },
        /**
         * Seta o @var state.users
         * 
         * @param {object} state 
         * @param {object} users 
         */
        SET_USERS(state, users) {
            state.users = users
        }
    },
    actions: {
        /**
         * Executa o login e define os valores do @var state.user
         * @param {object} commit Objecto passado pela action
         * @param {object} user Objeto user {email: 'some@email.com', password: 'userdogname'}
         */
        login ({ commit }, user) {
            let oauth = config.oauth_client
            let endpoint = 'api.oauth.token'
            return axios.post(endpoints.get({endpoint}), merge(oauth, user))
                .then(res => {
                    if(res.status === 200) {
                        commit('SET_AUTH_USER', res.data)
                        let endpoint = 'api.permissions.list'
                        axios.get(endpoints.get({endpoint})).then(res => {
                            if(res.status === 200) {
                                commit('SET_USER_PERMISSIONS', res.data)
                            }
                        })
                    }
                    return res
                })
                .catch(err => {
                    return err.response
                })
        },
        /**
         * Verifica se o login ainda está ativo
         * 
         * @param {*} param0 
         */
        verify({commit}) {
            let endpoint = 'api.oauth.ping'
            return axios.get(endpoints.get({endpoint}))
                .catch(err => {
                    commit('CLEAR_STATE')
                    throw err.response
                })
        },
        /**
         * Carrega uma lista de usuarios
         * @param {object} param0
         * @param {boolean} force
         */
        loadUsers({commit, getters}, force) {
            if(getters.hasLoaded('address', force)) {
                return
            }
            let endpoint = 'api.users.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_USERS', res.data)
                    commit('SET_LAST_LOAD', 'users')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria um novo usuário
         * 
         * @param {void} param0
         * @param {object} user
         */
        createUser({}, user) {
            let endpoint = 'api.users.create'
            return axios.post(endpoints.get({endpoint}), user)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Altera a senha do usuário
         * 
         * @param {void} param0
         * @param {object} passwords
         */
        changeUserPassword({}, passwords) {
            let endpoint = 'api.users.change_password'
            return axios.put(endpoints.get({endpoint}), passwords)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Atualiza um usuário
         * @param {void} param0
         * @param {object} user 
         */
        updateUser({}, user) {
            let endpoint = 'api.users.update'
            let params = {id: user.id}
            return axios.put(endpoints.get({endpoint, params}), user)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Envia um email de confimação ao novo usuário
         * @param {void} param0 
         * @param {number} userID 
         */
        sendCreatedEmail({}, userID) {
            let endpoint = 'api.user.send_created_email'
            let params = {id: userID}
            return axios.get(endpoints.get({endpoint, params}))
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta um usuário
         * @param {void} param0 
         * @param {number} id 
         */
        deleteUser({}, id) {
            let endpoint = 'api.users.delete'
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
        user: store => store.user,
        userByID: store => {
            return id => store.users.filter(the => the.id == id)[0]
        }
    }
}