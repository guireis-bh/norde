<template>
    <div id="form-user">
        <h1>Dados Pessoais</h1>
        <div class="col-md-6" v-show="!isHidden('salute')">
            <vue-select
            id="salute"
            label="Saudação"
            :options="[
                {
                    value: 'Sr.',
                    text: 'Sr.'
                },
                {
                    value: 'Sra.',
                    text: 'Sra.'
                },
                {
                    value: 'Dr.',
                    text: 'Dr.'
                },
                {
                    value: 'Dra.',
                    text: 'Dra.'
                },
            ]"
            :model.sync="inputs.salute"
            :error="hasError.salute"
            />
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.name }">
                <label>Nome *</label>
                <input id="name" name="name" v-model="inputs.name" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.surname }">
                <label>Sobrenome *</label>
                <input id="surname" name="surname" v-model="inputs.surname" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.email }">
                <label>Email *</label>
                <input id="email" name="email" v-model="inputs.email" type="email" class="form-control">
                <span><small>Este e-mail deverá ser utilizado ao registrar o familiar</small></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.birthday }">
                <label>Data de Nascimento</label>
                <input id="birthday" name="birthday" v-model="inputs.birthday" type="date" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.rg }">
                <label>RG</label>
                <input id="rg" name="rg" v-model="inputs.rg" type="text" class="form-control" v-mask="'##.###.###-X'">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.cpf }" v-mask="'###.###.###-##'">
                <label>CPF</label>
                <input id="cpf" name="cpf" v-model="inputs.cpf" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.cellphone }">
                <label>Celular</label>
                <input id="cellphone" name="cellphone" v-model="inputs.cellphone" v-mask="'(##) #####-####'" type="tel" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.homephone }">
                <label>Telefone Residencial</label>
                <input id="homephone" name="homephone" v-model="inputs.homephone" v-mask="'(##) ####-####'" type="tel" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.workphone }">
                <label>Telefone de trabalho</label>
                <input id="workphone" name="workphone" v-model="inputs.workphone" v-mask="['(##) ####-####', '(##) #####-####']" type="tel" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Origem</label>
                <input v-model="inputs.know_from" name="know_from" placeholder="Indicação, mídias sociais, etc." type="text" class="form-control">
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import { mask } from 'vue-the-mask'
import BlockSelect from '../Select.vue'

export default {
    name: 'BlockUserForm',
    data() {
        return {
            inputs: {
                id: null,
                address_id: null,
                salute: "",
                name: "",
                surname: "",
                email: "",
                birthday: "",
                rg: "",
                cpf: "",
                cellphone: "",
                homephone: "",
                workphone: "",
                know_from: "",
                role: "",
                subjects: []
            },
            hasError: {
                salute: false,
                name: false,
                surname: false,
                email: false,
                birthday: false,
                rg: false,
                cpf: false,
                cellphone: false,
                homephone: false,
                workphone: false
            }
        }
    },
    props: {
        userID: {
            type: [Number, Boolean],
            required: false
        },
        hidden: {
            type: [Array],
            default: () => {
                return []
            },
            required: false
        }
    },
    methods: {
        ...mapActions([
            'createUser',
            'updateUser',
            'loadUsers'
        ]),
        setRole(role) {
            this.inputs.role = role
        },
        setAddressID(id) {
            this.inputs.address_id = id
        },
        setSubjectsIDs(ids) {
            this.inputs.subjects = ids
        },

        submit() {
            this.hasError = {
                salute: false,
                name: false,
                surname: false,
                email: false,
                birthday: false,
                rg: false,
                cpf: false,
                cellphone: false,
                homephone: false,
                workphone: false
            }
            return new Promise(resolve => {
                    resolve(this.inputs.id ? 
                        this.updateUser(this.inputs) : this.createUser(this.inputs))
                })
                .then(res => {
                    if(res.status === 201) {
                        this.inputs.id = res.data.id
                        return res.data
                    }
                })
                .catch(err => {
                    if(typeof err.data !==  'undefined') {
                        Object.keys(err.data).forEach(key => {
                            this.hasError[key] = true
                        })
                    } else {
                        console.error(err)
                    }
                })
        },
        isHidden(input) {
            return this.hidden.filter(el => el === input).length > 0
        },
        load() {
            this.loadUsers()
            if(this.userID) {
                let user = this.$store.getters.userByID(this.userID)
                this.inputs.id = user.id
                this.inputs.address_id = user.address_id
                this.inputs.salute = user.salute
                this.inputs.name = user.name
                this.inputs.surname = user.surname
                this.inputs.email = user.email
                this.inputs.birthday = user.birthday
                this.inputs.rg = user.rg
                this.inputs.cpf = user.cpf
                this.inputs.cellphone = user.cellphone
                this.inputs.homephone = user.homephone
                this.inputs.workphone = user.workphone
                this.inputs.know_from = user.know_from
                this.inputs.role = user.role
            }
        }
    },
    beforeMount() {
        this.load()
    },
    directives: {
        mask        
    },
    components: {
        'vue-select': BlockSelect
    }
}
</script>