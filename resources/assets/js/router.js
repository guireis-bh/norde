import Vue from 'vue'
import Router from 'vue-router'
import PermissionManager from './objects/permission_manager'
import Dashboard from './components/Dashboard.vue'
import Login from './components/Login.vue'
import Calendar from './components/Calendar.vue'
import Employee from './components/Employee/index.vue'
import EmployeeList from './components/Employee/List.vue'
import EmployeeForm from './components/Employee/Form.vue'
import EmployeeView from './components/Employee/View.vue'
import Relative from './components/Relative/index.vue'
import RelativeList from './components/Relative/List.vue'
import RelativeForm from './components/Relative/Form.vue'
import RelativeView from './components/Relative/View.vue'
import Studant from './components/Studant/index.vue'
import StudantList from './components/Studant/List.vue'
import StudantForm from './components/Studant/Form.vue'
import StudantView from './components/Studant/View.vue'
import Schedule from './components/Schedule/index.vue'
import ScheduleList from './components/Schedule/List.vue'
import ScheduleForm from './components/Schedule/Form.vue'
import ScheduleView from './components/Schedule/View.vue'
import Config from './components/Config/index.vue'
import ConfigPersonal from './components/Config/Personal.vue'
import ConfigChangePassword from './components/Config/ChangePassword.vue'
Vue.use(Router)

let router = new Router({
  // mode: 'history',
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: {
        guest: true
      }
    },
    {
      path: '/',
      name: 'home',
      component: Dashboard,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/calendar',
      name: 'calendar',
      component: Calendar,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/funcionarios',
      name: 'employee',
      component: Employee,
      children: [
        { 
          name: 'employee-list',
          path: '',
          component: EmployeeList,
          meta: {
            permissions: {
              hasAtLeastOne: [
                'list admins',
                'list supervisors',
                'list teachers'
              ]
            }
          }
        },
        { 
          name: 'employee-form',
          path: 'adicionar',
          component: EmployeeForm,
          meta: {
            permissions: {
              hasAtLeastOne: [
                'add admin',
                'add supervisor',
                'add teacher',
              ]
            }
          }
        },
        { 
          name: 'employee-view',
          path: 'visualizar/:id',
          component: EmployeeView,
          meta: {
            permissions: {
              hasAtLeastOne: [
                'view admins',
                'view supervisors',
                'view teachers',
              ]
            }
          }
        },
        { 
          name: 'employee-edit',
          path: 'editar/:id',
          component: EmployeeForm,
          meta: {
            permissions: {
              hasAtLeastOne: [
                'update admin',
                'update supervisor',
                'update teacher',
              ]
            }
          }
        }
      ],
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/familiares',
      name: 'relative',
      component: Relative,
      children: [
        { 
          name: 'relative-list',
          path: '',
          component: RelativeList,
          mete: {
            permissions: {
              hasAll: [
                'list relatives',
              ]
            }
          }
        },
        { 
          name: 'relative-form',
          path: 'adicionar',
          component: RelativeForm,
          meta: {
            permissions: {
              hasAll: [
                'add relative'
              ]
            }
          }
        },
        { 
          name: 'relative-view',
          path: 'visualizar/:id',
          component: RelativeView,
          meta: {
            permissions: {
              hasAll: [
                'view relatives'
              ]
            }
          }
        },
        { 
          name: 'relative-edit',
          path: 'editar/:id',
          component: RelativeForm,
          meta: {
            permissions: {
              hasAll: [
                'update relative'
              ]
            }
          }
        }
      ],
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/alunos',
      name: 'studant',
      component: Studant,
      children: [
        { 
          name: 'studant-list',
          path: '',
          component: StudantList,
          meta: {
            permissions: {
              hasAll: [
                'list studants',
              ]
            }
          }
        },
        { 
          name: 'studant-form',
          path: 'adicionar',
          component: StudantForm,
          meta: {
            permissions: {
              hasAll: [
                'add studant',
              ]
            }
          }
        },
        { 
          name: 'studant-view',
          path: 'visualizar/:id',
          component: StudantView,
          meta: {
            permissions: {
              hasAll: [
                'view studants'
              ]
            }
          }
        },
        { 
          name: 'studant-edit',
          path: 'editar/:id',
          component: StudantForm,
          meta: {
            permissions: {
              hasAll: [
                'update studant'
              ]
            }
          }
        }
      ],
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/cronogramas',
      name: 'schedule',
      component: Schedule,
      children: [
        { 
          name: 'schedule-list',
          path: '',
          component: ScheduleList,
          meta: {
            permissions: {
              hasAll: [
                'list schedules',
              ]
            }
          }
        },
        { 
          name: 'schedule-form',
          path: 'adicionar',
          component: ScheduleForm,
          meta: {
            permissions: {
              hasAll: [
                'add schedule',
              ]
            }
          }
        },
        { 
          name: 'schedule-view',
          path: 'visualizar/:id',
          component: ScheduleView,
          meta: {
            permissions: {
              hasAll: [
                'view schedules'
              ]
            }
          }
        },
        { 
          name: 'schedule-edit',
          path: 'editar/:id',
          component: ScheduleForm,
          meta: {
            permissions: {
              hasAll: [
                'update schedule'
              ]
            }
          }
        }
      ],
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/config',
      name: 'config',
      component: Config,
      children: [
        { 
          name: 'config-personal',
          path: 'dados-pessoais',
          component: ConfigPersonal
        },
        { 
          name: 'config-change-password',
          path: 'alterar-senha',
          component: ConfigChangePassword
        }
      ],
      meta: {
        requiresAuth: true
      }
    },
  ]
})

router.beforeEach((to, from, next) => {
  PermissionManager.validateRouterAccess(to, from, next)
})

export default router