import store from './store'

let logout = () => {
    store.commit('CLEAR_STATE')
    location.reload()
}

const menus = [
    {
        id: 'dashboard',
        label: 'Dashboard',
        route: 'dashboard'
    },
    {
        id: 'studants',
        label: 'Alunos',
        route: 'studant-list',
        children: [
            [
                {
                    label: 'Alunos',
                    route: 'studant-list',
                    permission: 'list studants'
                },
                {
                    label: 'Familiar',
                    route: 'relative-list',
                    permission: 'list relatives'
                }
            ],
            [
                {
                    label: 'Adicionar Alunos',
                    route: 'studant-form',
                    permission: 'add studant'
                },
                {
                    label: 'Adicionar Familiar',
                    route: 'relative-form',
                    permission: 'add relative'
                }
            ]
        ]
    },
    {
        id: 'employee',
        label: 'Funcionarios',
        route: 'employee-list',
        children: [
            {
                label: 'Listar Funcionários',
                route: 'employee-list',
                permission: 'list admins'
            },
            {
                label: 'Adicionar Funcionário',
                route: 'employee-form',
                permission: 'add admin'
            }
        ]
    },
    {
        id: 'schedule',
        label: 'Cronogramas',
        route: 'schedule-list',
        children: [
            {
                label: 'Listar Cronogramas',
                route: 'schedule-list',
                permission: 'list schedules'
            },
            {
                label: 'Adicionar Cronograma',
                route: 'schedule-form',
                permission: 'add schedule'
            }
        ]
    },
    {
        id: 'config',
        label: 'Configurações',
        route: 'config',
        children: [
            {
                label: 'Alterar informações pessoais',
                route: 'config-personal'
            },
            {
                label: 'Alterar Senha',
                route: 'config-change-password'
            },
            {
                label: 'Sair',
                action: logout
            }
        ]
    }
]
export default menus