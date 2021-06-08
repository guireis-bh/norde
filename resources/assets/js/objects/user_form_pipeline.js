let UserFormPipeline = ({
    UserComponent,
    AddressComponent,
    SubjectComponent,
    ConfigComponent
}, role, self, endCallback, redirectCallback) => {
    return AddressComponent.submit()
        .then(address => {
            if(SubjectComponent) {
                UserComponent.setSubjectsIDs(SubjectComponent.getIDs())
            }
            if(role) {
                UserComponent.setRole(role)
            }
            UserComponent.setAddressID(address.id)
            return UserComponent.submit()
        })
        .then(user => {
            self.setUserID(user.id)
            if(ConfigComponent) {
                ConfigComponent.setUserID(user.id)
                ConfigComponent.submit().then(configs => {
                    configs.forEach(val => {
                        self.configs[val.key] = val.value
                    })
                })
            }
            return endCallback(user)
        })
        .then(res => {
            if(redirectCallback) {
                redirectCallback(res)
            }
        })
        .catch(err => {
            console.error(err)
            UserComponent.submit()
            return endCallback(user)
        })
}

export default UserFormPipeline