let endpoints = {
    basePath: process.env.APP_URL,
    api: {
        path: 'api',
        oauth: {
            token: 'oauth/token',
            ping: 'ping'
        },
        schools: {
            index: 'schools'
        },
        services: {
            index: 'services'
        },
        subjects: {
            index:  'subjects',
            create: 'subjects',
            patch: 'subjects',
            getByUser: 'subjects/user/#id'
        },
        teachers: {
            index: 'teachers'
        },
        users: {
            index:  'users',
            create: 'users',
            update: 'users/#id',
            delete: 'users/#id',
            send_created_email: 'send-created-mail/#id',
            change_password: 'user/change-password'
        },
        permissions: {
            list: 'user/permissions'
        },
        configs: {
            index:  'configs',
            create: 'configs',
            get: 'configs/#id',
            patch: 'configs/user/#id',
            put: 'configs/user/#id/#slug'
        },
        address: {
            index:  'address',
            create: 'address',
            update: 'address/#id',
            delete: 'address/#id'
        },
        employeeTypes: {
            index: 'employee-types'
        },
        employees: {
            index:  'employees',
            create: 'employees',
            update: 'employees/#id',
            delete: 'employees/#id'
        },
        families: {
            index:  'families',
            create: 'families',
            update: 'families/#id',
            delete: 'families/#id',
            responsibles: 'responsibles'
        },
        relatives: {
            index:  'relatives',
            create: 'relatives',
            update: 'relatives/#id',
            delete: 'relatives/#id'
        },
        studants: {
            index:  'studants',
            create: 'studants',
            update: 'studants/#id',
            delete: 'studants/#id'
        },
        schedules: {
            index:  'schedules',
            create: 'schedules',
            update: 'schedules/#id',
            delete: 'schedules/#id'
        },
        schedules_studants: {
            index: 'schedules/#id/studants',
            create: 'schedules/#id/studant',
            update: 'schedules/studant/#id',
            delete: 'schedules/studant/#id',
        }
    }
}

export default endpoints