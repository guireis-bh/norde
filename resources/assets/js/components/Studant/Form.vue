<template>
<block-form 
 title="Novo Estudante"
 subtitle="Informações Familiares"
 :helper="helper"
 :submit="submit"
 >
 <div class="row">
    <vue-family :familyID="inputs.family_id ? inputs.family_id : false" />
    <div class="col-md-6">
        <vue-select
            id="responsible_kinship"
            :options="[
                {
                    value: 'parent',
                    text: 'Pai/Mãe'
                },
                {
                    value: 'grandparent',
                    text: 'Avô/Avó'
                },
                {
                    value: 'parent_sibling',
                    text: 'Tio/Tia'
                },
                {
                    value: 'other',
                    text: 'Outro'
                },
            ]"
            :model.sync="inputs.responsible_kinship"
            label="Parentesco"
            empty="Nenhum"
            info="Selecione o parentesco entre o responsável e o aluno"
        />
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Outro</label>
            <input id="other_kinship" name="other_kinship" v-model="inputs.other_kinship" type="text" class="form-control" :disabled="inputs.responsible_kinship !== 'other'">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Responsável</label>
            <select id="responsible_id" class="form-control" v-model="inputs.responsible_id" @focus="loadResponsibles">
                <option value="">Nenhum</option>
                <option v-for="responsible in responsibles" :value="responsible.value" :key="responsible.value">
                    {{ responsible.text }}
                </option>
            </select>
            <p>
                Selecione o responsável pelo aluno
            </p>
        </div>
    </div>
    <div class="row"></div>
    <vue-user :userID="inputs.user_id ? inputs.user_id : false" :hidden="['salute']"/>
    <div class="row"></div>
    <vue-address :addressID="inputs.address_id ? inputs.address_id : false" />
</div>
<div class="box-adicional-familia">
    <div class="row">
        <div class="col-md-12">
            <div class="cabecalho-box-adicional-estudante">
                <h1>Detalhes do Estudante</h1>
            </div>
        </div>
    </div>
    <div class="detalhe-estudante">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group" :class="{ 'has-error': hasError.entry_date }">
                    <label>Data de Início</label>
                    <input id="entry_date" v-model="inputs.entry_date" name="entry_date" type="date" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" :class="{ 'has-error': hasError.grade }">
                    <label>Grade / Ano</label>
                    <input id="grade" name="grade" v-model="inputs.grade" type="date" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <vue-select
                id="school_id"
                label="Selecione uma escola"
                :options="this.schools"
                :model.sync="inputs.school_id"
                :error.sync="hasError.school_id"
                />
            </div>
        </div>
        <hr class="hr-estilizado">
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.info }">
                <label>Informacões Adicionais</label>
                <textarea id="info" name="info" v-model="inputs.info" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <vue-subjects :userID="inputs.user_id ? inputs.user_id : false" label="Assuntos"/>
        </div>
        <div class="col-md-6">
            <vue-select
                id="service_id"
                :options="this.services"
                :model.sync="inputs.service_id"
                :error.sync="hasError.service_id"
                label="Serviço Padrão"
                empty="Selecione uma opção"
                info="Esses serviços serão exibidos em grupo no menu de seleção de Serviços, no momento em que estiver agendando aulas para esse estudante."
            />
        </div>
        <hr class="hr-estilizado">
        <div class="col-md-6">
            <vue-select
                id="teacher_id"
                :model.sync="inputs.teacher_id"
                :error.sync="hasError.teacher_id"
                :options="this.teachers"
                label="Professores"
                empty="Selecione um professor"
                info="Estudantes serão incluídos na lista de estudantes, na lista de Professores selecionados."
            />
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.colorpicker }">
                <label>Cor do calendário</label>
                <div id="cp2" class="input-group colorpicker-component">
                    <span class="input-group-addon seleciona-cor"><i></i></span>
                    <input id="cor_calendario" v-model="inputs.calendar_color" name="estudante-cor-calendar" type="text" value="#1BDAA8" class="form-control" />
                </div>
            </div>
        </div>
        <div class="row"></div>
        <hr class="hr-estilizado">
        <h1 class="titulo-notificacao">Detalhes de Pagamento</h1>
        <div class="col-md-6">
            <vue-select
                id="payment_method"
                name="payment_method"
                :model.sync="inputs.payment_method"
                :error.sync="hasError.payment_method"
                :options="[
                    {
                        value: 'default',
                        text: 'Usar valor padrão'
                    },
                    {
                        value: 'custom',
                        text: 'Outro valor'
                    }
                ]"
                label="Métodos de pagamento"
            />
        </div>
        <div class="col-md-6">
            <div id="hiddenFormPagamento" class="form-group" :class="{ 'has-error': hasError.payment_value }">
                <label>Defina o valor do pagamento</label>
                <input id="payment_value" name="payment_value" v-money="money" v-model="inputs.payment_value" class="form-control" type="text">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" :class="{ 'has-error': hasError.discount }">
                <label>Desconto do Estudante %</label>
                <input id="discount" name="discount" v-model="inputs.discount" disabled="disabled" type="number" class="form-control">
            </div>
        </div>
    </div>
</div>
<div class="row"></div>
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
            <router-link :to="{ name: 'studant-list' }" class="btn btn-warning">
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
</block-form>
</template>

<script>
import { mapActions } from 'vuex'
import { VMoney } from 'v-money'
import money from '../../config/money'
import UserFormPipeline from '../../objects/user_form_pipeline'
import BlockForm from './../Block/Form.vue'
import BlockSelect from './../Block/Select.vue'
import BlockFamily from './../Block/Family.vue'
import BlockUserForm from './../Block/User/Form.vue'
import BlockAddressForm from './../Block/Address/Form.vue'
import BlockConfigForm from './../Block/Config/Form.vue'
import BlockSubjectForm from './../Block/Subject/Form.vue'

export default {
  name: 'StudantForm',
  data() {
      return {
          helper: {
            title: 'Adicionar um novo aluno',
            subtitle: 'Este formulário irá lhe auxiliar na criação de um novo aluno.'
          },
          responsibles: [],
          inputs: {
            id: "",
            address_id: "",
            user_id: "",
            family_id: "",
            responsible_id: "",
            responsible_kinship: "",
            other_kinship: "",
            entry_date: "",
            school_id: "",
            grade: "",
            subject: "",
            info: "",
            service_id: "",
            teacher_id: "",
            calendar_color: "",
            payment_method: "",
            payment_value: "",
            discount: ""
          },
          hasError: {
            entry_date: false,
            grade: false,
            subject: false,
            info: false,
            colorpicker: false,
            payment_value: false,
            discount: false,
          },
          money,
         configs: {}
      }
  },
  computed: {
      schools() {
          let schools = this.$store.getters.schools
          let results = []
          schools.forEach((el, inx) => {
              results[inx] = {
                  value: el.id,
                  text: el.name
              }
          })
          return results;
      },
      teachers() {
          let teachers = this.$store.getters.teachers
          let results = []
          teachers.forEach((el, inx) => {
              results[inx] = {
                  value: el.id,
                  text: el.user.salute + ' ' + el.user.name + ' ' + el.user.surname
              }
          })
          return results;
      },
      services() {
          let services = this.$store.getters.services
          let results = []
          services.forEach((el, inx) => {
              results[inx] = {
                  value: el.id,
                  text: el.name
              }
          })
          return results;
      }
  },
  methods: {
    ...mapActions([
        'createStudant',
        'updateStudant',
        'loadSchools',
        'loadTeachers',
        'loadServices',
        'loadStudants',
        'loadConfigs'
    ]),
    setUserID(id) {
        this.inputs.user_id = id
    },
    setFamilyID(id) {
        this.inputs.family_id = id
    },
    submit() {
        let FamilyComponent = this.$children[0].$children[0]
        let UserComponent = this.$children[0].$children[2]
        let AddressComponent = this.$children[0].$children[3]
        let SubjectComponent = this.$children[0].$children[5]
        let ConfigComponent = this.$children[0].$children[9]
        let role = 'studant'
        UserFormPipeline({
            UserComponent,
            AddressComponent,
            SubjectComponent,
            ConfigComponent
        }, role, this,
        user => {
            Object.keys(this.hasError).forEach(key => {
                this.hasError[key] = false
            })
            return FamilyComponent.submit()
                .then(family => {
                    this.setFamilyID(family.id)
                    return this.inputs.id ?
                        this.updateStudant(this.inputs) : this.createStudant(this.inputs)
                })
        },
        res => {
            if(res.status === 201) {
                this.loadStudants(true)
                this.$router.push({ name: 'studant-list' })
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
    loadResponsibles() {
        let familyID = this.$children[0].$children[0].inputs.id
        if(isNaN(familyID)) {
            return false
        }
        let relatives = this.$store.getters.responsibles(familyID).relatives
        let results = []
        relatives.forEach((el, inx) => {
            results[inx] = {
                value: el.id,
                text: el.user.salute + ' ' + el.user.name + ' ' + el.user.surname
            }
        })

        this.responsibles = results
    },
    load() {
        this.loadSchools()
        this.loadTeachers()
        this.loadServices(true)
        this.loadConfigs()
        if(this.$route.params.id) {
          let studant = this.$store.getters.studantByID(this.$route.params.id)
          this.inputs.id = studant.id
          this.inputs.user_id = studant.user_id
          this.inputs.address_id = studant.user.address_id
          this.inputs.family_id = studant.family_id
          this.inputs.relative_id = studant.relative_id
          this.inputs.responsible_kinship = studant.responsible_kinship
          this.inputs.other_kinship = studant.other_kinship
          this.inputs.entry_date = studant.entry_date
          this.inputs.school_id = studant.school_id
          this.inputs.grade = studant.grade
          this.inputs.subject = studant.subject
          this.inputs.info = studant.info
          this.inputs.service_id = studant.service_id
          this.inputs.teacher_id = studant.teacher_id
          this.inputs.calendar_color = studant.calendar_color
          this.inputs.payment_method = studant.payment_method
          this.inputs.payment_value = studant.payment_value
          this.inputs.discount = studant.discount

          let configs = this.$store.getters.configsByUserID(studant.user_id)
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
      'vue-family': BlockFamily,
      'vue-config': BlockConfigForm,
      'vue-subjects': BlockSubjectForm       
  },
  directives: {
      money: VMoney
  }
}
</script>