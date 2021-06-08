import endpoints from '../objects/endpoints'

/**
 * Configs Vuex component
 */
export default {
    state: {
        configs: [],
        lastLoad: {
            configs: {
                time: null,
                interval: 5
            }
        }
    },
    mutations: {
        /**
         * Seta o @var state.configs
         * @param {object} state 
         * @param {object} configs Objeto configs
         */
        SET_CONFIGS(state, configs) {
            state.configs = configs
        }
    },
    actions: {
        /**
         * Carrega uma lista de configurações
         * @param {object} param0 
         * @param {boolean} force
         */
        loadConfigs({ commit, getters }, force) {
            if(getters.hasLoaded('configs', force)) {
                return
            }
            let endpoint = 'api.configs.index'
            return axios.get(endpoints.get({endpoint}))
                .then(res => {
                    commit('SET_CONFIGS', res.data)
                    commit('SET_LAST_LOAD', 'configs')
                    return res.data
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria uma config
         * @param {void} param0 
         * @param {object} config 
         */
        createConfig({}, configs) {
            let endpoint = 'api.configs.create'
            return axios.post(endpoints.get({endpoint}), configs)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Cria configurações em massa
         * @param {void} param0 
         * @param {object} configs 
         */
        patchConfigs({}, {configs, userID}) {
            let endpoint = 'api.configs.patch'
            let params = {id: userID}
            return axios.patch(endpoints.get({endpoint, params}), configs)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Atualiza ou cria configuração
         * @param {void} param0 
         * @param {object} param1 
         */
        putConfig({}, {config, slug, userID}) {
            let endpoint = 'api.configs.put'
            let params = {id: userID, slug: slug}
            return axios.put(endpoints.get({endpoint, params}), config)
                .then(res => {
                    return res
                })
                .catch(err => {
                    throw err.response
                })
        },
        /**
         * Deleta um endereço
         * @param {void} param0 
         * @param {number} id 
         */
        deleteConfig({}, id) {
            let endpoint = 'api.configs.delete'
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
        configs: store => store.configs,
        configsByUserID: store => {
            return id => store.configs.filter(
                // Criar maneira de bloquear configs sensiveis
                the => the.user_id == id && the.key !== 'temporary_password'
            )
        },
    }
}