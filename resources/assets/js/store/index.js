let deepmerge = require('deepmerge')
let merge = (objs) => {
    if(objs.length < 2) {
        return objs[0]
    }

    let ret = deepmerge(objs[0], objs[1])
    if(objs.length > 2) {
        let len = objs.length - 1
        for(let i = 2; i <= len; i++) {
            ret = deepmerge(ret, objs[i])
        }
    }
    return ret
}
/**
 * Main file for vuex store configurations
 */
import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate';
import global from './global'
import users from './users'
import configs from './configs'
import address from './address'
import subjects from './subjects'
import studants from './studants'
import schedules from './schedules'
import families from './families'
import relatives from './relatives'
import employees from './employees'
import teachers from './teachers'
import services from './services'
import schools from './schools'

Vue.use(Vuex)

let store = merge([
    global,
    users,
    configs,
    address,
    studants,
    schedules,
    families,
    relatives,
    services,
    schools,
    employees,
    subjects,
    teachers,
    {
        plugins: [createPersistedState()]
    }
])
export default new Vuex.Store(store)