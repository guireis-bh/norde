import config from '../config/default.js'

/**
 * Arquivo pra manipular endpoints
 */
export default {
    /**
     * Retorena uma uri formada a partir da string configurada em
     * /config/default.js. Podendo utilizar a substituição de hash
     * pelos valores passados no object @var data
     * 
     * @param {string} endpoint 
     * @param {object} data
     */
    get({endpoint, params}) {
        let endpoints = endpoint.split('.')
        let uri = config.endpoints.basePath + '/'
        uri = uri + config.endpoints[endpoints[0]].path + '/'
        uri = uri + config.endpoints[endpoints[0]][endpoints[1]][endpoints[2]]
        if(typeof params === 'object') {
            Object.keys(params).forEach(key => {
                uri = uri.replace('#' + key, params[key])
            })
        }
        return uri.indexOf('?') === -1 ? uri + '?t=' + Date.now() : uri
    }
}