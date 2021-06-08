<template>
    <block-form 
    title="Novo Funcionário"
    subtitle="Informações do funcinário"
    :helper="helper"
    :submit="submit"
    >
        <vue-user :userID="inputs.user_id ? inputs.user_id : false" />
        <div class="row"></div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.bio }">
                <label>Bio</label>
                <textarea v-model="inputs.bio"  name="bio" class="form-control" rows="4"></textarea>
                <p id="descBio">Sera exibido no perfil do funcionário e pode aparecer em alguns add-ons.</p>
            </div>
        </div>
        <div class="row"></div>
        <vue-address :addressID="inputs.address_id ? inputs.address_id : false" />
        <div class="row"></div>
        <div class="box-bloco-adicional">
            <h1>Detalhes do Funcionário</h1>
            <div class="row"></div>
            <div class="col-md-6">
                <vue-select
                    id="type_id"
                    label="Cargo"
                    :options="employeeTypes"
                    :model.sync="inputs.type_id"
                    :error="hasError.type_id"
                    :change="changeSalaryType"
                />
            </div>
            <div class="col-md-6">
                <vue-subjects label="Assuntos" :userID="inputs.user_id ? inputs.user_id : false" />
            </div>
            <div class="row"></div>
            <div class="col-md-6">
                <div class="form-group" :class="{ 'has-error': hasError.hiring_date }">
                    <label>Data de Contratação</label>
                    <input v-model="inputs.hiring_date" name="hiring_date" type="date" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <vue-select
                    id="salary_type"
                    label="Tipo de salário"
                    :options="[
                        {
                            value: 'custom',
                            text: 'Defina um valor no perfíl'
                        },
                        {
                            value: 'default',
                            text: 'Use a lista padrão de salários'
                        }
                    ]"
                    :model.sync="inputs.salary_type"
                    :error="hasError.salary_type"
                    :change="changeSalaryType"
                    info="Escolha um método que definira o salário a ser pago."
                />
            </div>
            <div class="col-md-6">
                <div class="form-group" :class="{ 'has-error': hasError.class }">
                    <label>Defina o valor do salário</label>
                    <input v-model.lazy="inputs.salary" v-money="money" name="salary" class="form-control" type="text" :disabled="disabledSalaryInput">
                </div>
            </div>
            <div class="col-md-6">
                <div class="boxAdicional-campoTexto">
                    <label>Informações Adicionais</label>
                    <textarea id="subject_descriptionInp" class="form-control" rows="4"></textarea>
                </div>
            </div>
            <div class="row"></div>
            <div class="container-fluid">
                <h1 id="blocoAdicional">Detalhes de pagamento</h1>
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-error': hasError.bank_name }">
                        <label>Nome do Banco</label>
                        <input v-model="inputs.bank_name" name="bank_name" type="text" class="form-control">
                    </div>
                </div>
                    <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-error': hasError.bank_office }">
                        <label>Agência</label>
                        <input v-model="inputs.bank_office" name="bank_office" v-mask="['###', '###-#', '###-##']" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-error': hasError.bank_account }">
                        <label>Conta</label>
                        <input v-model="inputs.bank_account" name="bank_account" v-mask="['###-#', '####-#', '#####-#', '######-#']" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" :class="{ 'has-error': hasError.bank_city }">
                        <label>Cidade do Banco</label>
                        <input v-model="inputs.bank_city" name="bank_city" type="text" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <vue-config
            title="Configurações de conta"
            :fields="[
                {
                    label: 'Habilitar login',
                    type: Boolean,
                    colClass: 'md-6',
                    key: 'user_login',
                    value: this.configs.hasOwnProperty('user_login') ?
                        this.configs.user_login : 0
                }
            ]"
        />
        <div class="box-botao">
            <ul class="list-unstyled list-inline">
                <li>
                    <router-link :to="{ name: 'employee-list' }" class="btn btn-warning">
                        Cancelar
                    </router-link>
                </li>
                <li>
                    <button type="submit" name="submit" class="btn btn-primary"><i class=""></i>
                        Cadastrar
                    </button>
                </li>
            </ul>
        </div>
        </div>
    </block-form>
</template>

<script>
import { mapActions } from 'vuex'
import { mask } from 'vue-the-mask'
import { VMoney } from 'v-money'
import money from '../../config/money'
import UserFormPipeline from '../../objects/user_form_pipeline'
import BlockForm from '../Block/Form.vue'
import BlockSelect from '../Block/Select.vue'
import BlockUserForm from '../Block/User/Form.vue'
import BlockAddressForm from '../Block/Address/Form.vue'
import BlockConfigForm from '../Block/Config/Form.vue'
import BlockSubjectForm from '../Block/Subject/Form.vue'

export default {
  name: 'EmployeeForm',
  data() {
      return {
          helper: {
            title: 'Criação de funcionário',
            subtitle: 'Este formulário irá lhe auxiliar a criação de um novo funcionário admin, supervisor ou professor.'
          },
          inputs: {
            id: false,
            address_id: false,
            user_id: "",
            type_id: "",
            hiring_date: "",
            salary_type: "",
            salary: "",
            bank_name: "",
            bank_office: "",
            bank_account: "",
            bank_city: ""
          },
          hasError: {
            bio: false,
            hiring_date: false,
            salary: false,
            name: false,
            class: false,
            type: false,
            bank_name: false,
            bank_office: false,
            bank_account: false,
            bank_city: false
          },
          money,
          configs: {},
          disabledSalaryInput: false
      }
  },
  computed: {
      employeeTypes() {
          let employeeTypes = this.$store.getters.employeeTypes
          let results = []
          employeeTypes.forEach((el, inx) => {
              results[inx] = {
                  value: el.id,
                  text: el.name,
                  role: el.role,
                  default: el.default_salary
              }
          })
          return results;
      }
  },
  methods: {
    ...mapActions([
        'createEmployee',
        'updateEmployee',
        'loadEmployees',
        'loadEmployeeTypes',
        'loadTeachers',
        'loadConfigs'
    ]),
    setUserID(id) {
        this.inputs.user_id = id
    },
    submit() {
        let UserComponent = this.$children[0].$children[0]
        let AddressComponent = this.$children[0].$children[1]
        let SubjectComponent = this.$children[0].$children[3]
        let ConfigComponent = this.$children[0].$children[5]
        let role = this.employeeTypes.filter(et => et.value == this.inputs.type_id)[0]
        UserFormPipeline({
            UserComponent,
            AddressComponent,
            SubjectComponent,
            ConfigComponent
        }, role ? role.role : null, this,
        user => {
            Object.keys(this.hasError).forEach(key => {
                this.hasError[key] = false
            })
            return this.inputs.id ?
                this.updateEmployee(this.inputs) : this.createEmployee(this.inputs)
        },
        res => {
            if(res.status === 201) {
                this.loadEmployees(true)
                this.loadTeachers(true)
                this.$router.push({ name: 'employee-list' })
            }
        }).catch(err => {
            if(typeof err.data !==  'undefined') {
                Object.keys(err.data).forEach(key => {
                    this.hasError[key] = true
                })
            } else {
                console.error(err)
            }
        })
    },
    changeSalaryType() {
        if(this.inputs.salary_type === 'default') {
            this.disabledSalaryInput = true
            this.inputs.salary = this.employeeTypes.filter(et => et.value == this.inputs.type_id)[0].default
        } else {
            this.disabledSalaryInput = false
        }
    },
    load() {
        this.loadEmployeeTypes()
        this.loadConfigs()
        if(this.$route.params.id) {
            let employee = this.$store.getters.employeeByID(this.$route.params.id)
            this.inputs.id = employee.id
            this.inputs.user_id = employee.user_id
            this.inputs.address_id = employee.user.address_id
            this.inputs.type_id = employee.type_id
            this.inputs.hiring_date = employee.hiring_date
            this.inputs.salary_type = employee.salary_type
            this.inputs.salary = employee.salary
            this.inputs.bank_name = employee.bank_name
            this.inputs.bank_office = employee.bank_office
            this.inputs.bank_account = employee.bank_account
            this.inputs.bank_city = employee.bank_city

            let configs = this.$store.getters.configsByUserID(employee.user_id)
            configs.forEach(el => {
                this.configs[el.key] = el.value == 1 ? true : false
            })
        }
    }
  },
  beforeMount() {
      this.load()
  },
  components: {
      'block-form': BlockForm,
      'vue-user': BlockUserForm,
      'vue-address': BlockAddressForm,
      'vue-select': BlockSelect,
      'vue-config': BlockConfigForm,
      'vue-subjects': BlockSubjectForm
  },
  directives: {
      mask,
      money: VMoney
  }
}
</script>