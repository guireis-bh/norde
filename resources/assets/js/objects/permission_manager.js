import store from '../store'

/**
 * Obejeto p/ manipulação de permissions
 */
let PermissionManager = {
    /**
     * Token do usuário autenticado
     */
    token: null,
    /**
     * Permissões do usuário logado
     */
    permissions: null,
    /**
     * Carrega o token do usuário logado
     */
    loadToken() {
        try {
            this.token = store.state.user.oauth.access_token
            if(!this.token) {
                this.token = false
            } else {
                window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token
            }
        } catch (err) {
            this.token = false
            setTimeout(this.loadToken, 5000)
        }
    },
    /**
     * Carrega as permissões do usuário logado
     */
    loadPermissions() {
        try {
            this.permissions = store.state.user.permissions
        } catch (err) {
            loadPermissions(this.loadToken, 5000)
        }
    },
    /**
     * Valida se uma rota é permitida ao usuário logado
     * @param {object} to 
     * @param {object} from
     * @param {object} next 
     */
    validateRouterAccess(to, from, next) {
        this.loadToken()
        this.loadPermissions()
        if(this.requiresAuth(to, from, next) === true) {
            this.validatePermission(to, from, next)
        } else {
            this.isGuestAccess(to, next)
        }
    },
    /**
     * Verifica se é necessário autenticação. Caso seja, e o usuário não esteja
     * logado, redireciona para o login
     * @param {object} to 
     * @param {object} next  
     */
    requiresAuth(to, next) {
        if(to.matched.some(record => record.meta.requiresAuth)) {
            if(this.token === false) {
                return next({
                    name: 'login',
                    params: { nextUrl: to.fullPath }
                })
            } else {
                return true
            }
        }
    },
    /**
     * Verifica se é acessivel a visitantes e procede conforme
     * @param {object} to
     * @param {object} next 
     */
    isGuestAccess(to, next) {
        if(to.matched.some(record => record.meta.guest)) {
            if(this.token === false) {
                return next()
            } else {
                return next({name: 'dashboard'})
            }
        } else {
            return next()
        }
    },
    /**
     * Valida a permissão do usuário para a página
     * @param {object} to 
     * @param {object} from
     * @param {object} next 
     */
    validatePermission(to, from, next) {
        let permitted = false
        if(typeof to.meta.permissions === 'undefined') {
            permitted = true
        } else if(typeof to.meta.permissions.hasAtLeastOne !== 'undefined') {
            to.meta.permissions.hasAtLeastOne.filter(permission => {
                if(this.permissions.includes(permission)) {
                    permitted = true
                }
            })
        } else if(typeof to.meta.permissions.hasAll !== 'undefined') {
            permitted = true
            to.meta.permissions.hasAll.filter(permission => {
                if(!this.permissions.includes(permission)) {
                    permitted = false
                }
            })
        }
        if(permitted === true) {
            return next()
        } else {
            this.hasFail(from, next)
        }
    },
    /**
     * Valida se o usuário logado possui a permissão em questão
     * @param {string} permission 
     */
    hasPermission(permission) {
        return this.permissions.includes(permission)
    },
    /**
     * Redireciona a página caso não passe em alguma validação
     * @param {object} from
     * @param {object} next
     */
    hasFail(from, next) {
        if(from.name === null) {
            return next({name: 'dashboard'})
        } else {
            return next({name: from.name})
        }
    }
}

export default PermissionManager