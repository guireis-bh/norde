<template>
    <div>
        <h1 v-show="title">{{ title }}</h1>
        <div v-for="field in fields" :class="'col-' + field.colClass" :key="field.key">
            <div class="form-group" v-switch="field.type">
                <label>{{ field.label }}</label>
                <toggle-button v-case="Boolean" :id="field.key" :name="field.key" :v-model="inputs[field.key] ? true : false" />
                <input v-case="String" :id="field.key" :name="field.key" v-model="inputs[field.key]" type="text" class="form-control" />
                <input v-case="Number" :id="field.key" :name="field.key" v-model="inputs[field.key]" type="number" class="form-control" />
            </div>
        </div>
        <div class="row"></div>
    </div>
</template>

<script>
import Vue from 'vue'
import { MessageBox, Notification } from 'uiv'
import { mapActions } from 'vuex'
import VSwitch from 'v-switch-case'
import { ToggleButton } from 'vue-js-toggle-button'

Vue.use(VSwitch)
Vue.prototype.$confirm = MessageBox.confirm
Vue.prototype.$notify = Notification.notify

export default {
    name: 'BlockConfigForm',
    data() {
        return {
            user_id: null,
            configsCreated: null
        }
    },
    props: {
        fields: {
            type: Array,
            required: true
        },
        title: {
            type: String,
            required: false
        }
    },
    methods: {
        ...mapActions([
            'putConfig',
            'loadConfigs',
            'sendCreatedEmail'
        ]),
        setUserID(ID) {
            return this.user_id = ID
        },
        submit() {
            if(this.configsCreated) {
                return new Promise(resolve => {
                    resolve(this.configsCreated)
                })
            }
            let userID = this.user_id
            let configs = []
            let count = this.fields.length
            return new Promise((resolve, reject) => {
                this.fields.forEach((val, inx) => {
                    let slug = val.key
                    let config = {
                        user_id: userID,
                        key: val.key,
                        value: this.inputs[val.key],
                        type: typeof val.type()
                    }
                    this.putConfig({config, slug, userID})
                        .then(res => {
                            if(res.status === 201) {
                                configs.push(res.data)
                            }
                            if(--count === 0) {
                                resolve(configs)
                                this.loadConfigs(true)
                            }
                        })
                        .catch(err => {
                            reject(err)
                        })
                })
            })
        },
        verifyIfUserWasEnabled() {
            this.configsCreated.forEach(val => {
                if(val.key === 'user_login') {
                    this.$confirm({
                        title: 'Enviar email',
                        content: 'Você deseja enviar um email com o login para o novo usuário?'
                    })
                    .then(() => {
                        this.sendCreatedEmail(this.user_id)
                            .then(res => {
                                if(res.status === 200) {
                                    this.$notify({
                                        type: 'success',
                                        content: 'Email enviado com sucesso.'
                                    })
                                }
                            })
                    })
                    .catch(() => {
                        this.$notify({
                                type: 'danger',
                                content: 'Email não enviado.'
                            })
                    })
                }
            })

        }
    },
    computed: {
        inputs() {
            let inputs = {}

            this.fields.forEach((el, inx) => {
                inputs[el.key] = el.value
            })
            return inputs
        }
    },
    components: {
        ToggleButton
    }
}
</script>