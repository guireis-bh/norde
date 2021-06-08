<template>
    <vue-view
        title="Informações do Funcionário"
        subtitle="Detalhes das informações dos funcionários"
        :helper="helper"
        :links="links"
    >
        <vue-user :user="employee.user" />
        <div class="row"></div>
        <vue-address :id="employee.user.address_id" />
        <div class="row"></div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Bio</label>
                <p>{{ employee.bio }}</p>
            </div>
        </div>
        <div class="row"></div>
        <h1>Detalhes do Funcionário</h1>
        <div class="row"></div>
        <div class="col-md-6">
            <label> Tipo de Funcionário </label>
            {{ getEmployeeTypeName(employee.type_id) }}
        </div>
        <!--<div class="col-md-6">
            <vue-subjects label="Assuntos"/>
        </div> -->
        <div class="row"></div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Data de Contratação</label>
                {{ employee.hiring_date }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Salário</label>
                {{ formatMoney(employee.salary) }}
            </div>
        </div>
        <div class="row"></div>
        <h1 id="blocoAdicional">Detalhes de pagamento</h1>
        <div class="row"></div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nome do Banco</label>
                {{ employee.bank_name }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Agência</label>
                {{ employee.bank_office }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Conta</label>
                {{ employee.bank_account }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Cidade do Banco</label>
                {{ employee.bank_city }}
            </div>
        </div>
    </vue-view>
</template>

<script>
import FormatMoney from '../../objects/format_money'
import BlockView from '../Block/View.vue'
import BlockUserView from '../Block/User/View.vue'
import BlockAddressView from '../Block/Address/View.vue'

export default {
  name: 'EmployeeView',
  data() {
      return {
        links: [
            {
                route: 'employee-list',
                text: 'Listar Funcionarios',
                icon: 'list'
            },
            {
                route: 'employee-form',
                text: 'Adicionar Funcionario',
                icon: 'user'
            }
        ],
        helper: {
            title: 'Informações',
            subtitle: 'Aqui você pode visualizar um geral das informações do funcionário.'
        },
      }
  },
  computed: {
      employee() {
          return this.$store.getters.employeeByID(this.$route.params.id)
      }
  },
  methods: {
      getEmployeeTypeName(id) {
          return this.$store.getters.employeeTypeByID(id).name
      },
      formatMoney(val) {
          return FormatMoney.toString(val)
      }
  },
  components: {
      'vue-view': BlockView,
      'vue-user': BlockUserView,
      'vue-address': BlockAddressView
  }
}
</script>