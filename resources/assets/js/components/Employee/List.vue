<template>
<div class="row">
    <list 
        slug="employees"
        title="Lista de Funcionários"
        :fields="fields"
        :items="employees"
        rowRouter="employee-view"
    />

    <search :links="links" />
</div>
</template>

<script>
import Vue from 'vue'
import { mapActions } from 'vuex'
import { MessageBox, Notification } from 'uiv'
import List from '../Block/List.vue'
import Search from '../Block/Search.vue'

Vue.prototype.$confirm = MessageBox.confirm
Vue.prototype.$notify = Notification.notify

export default {
  name: 'EmployeeList',
  data() {
      return {
        fields: [
            {
                label: 'Nome',
                column: 'name',
                colmd: 'col-md-2'
            },
            {
                label: 'Email',
                column: 'email',
                colmd: 'col-md-2'
            },
            {
                label: 'Telefone',
                column: 'homephone',
                colmd: 'col-md-2'
            },
            {
                label: 'Celular',
                column: 'cellphone',
                colmd: 'col-md-2'
            },
            {
                label: 'Tipo',
                column: 'role',
                colmd: 'col-md-1'
            },
            {
                label: 'Ações',
                column: 'actions',
                colmd: 'col-md-1'
            }
        ],
        links: [
            {
                route: 'employee-form',
                text: 'Adicionar Funcionario',
                icon: 'user'
            }
        ]
      }
  },
  computed: {
      employees() {
          let employees = this.$store.getters.employees
          let parsedEmployess = [];
          Object.keys(employees).forEach(key => {
              parsedEmployess[key] = {
                id: employees[key].id,
                name: employees[key].user.name,
                email: employees[key].user.email,
                homephone: employees[key].user.homephone,
                cellphone: employees[key].user.cellphone,
                role: this.getEmployeeTypeName(employees[key].type_id),
                actions: [
                    {
                        route: 'employee-edit',
                        icon: 'pencil'
                    },
                    {
                        icon: 'remove',
                        func: this.deleteOne
                    }
                ]
              }
          })
          return parsedEmployess
      }
  },
  methods: {
      ...mapActions([
          'loadEmployees',
          'loadEmployeeTypes',
          'deleteEmployee'
      ]),
      getEmployeeTypeName(id) {
          return this.$store.getters.employeeTypeByID(id).name
      },
      deleteOne(id) {
          this.$confirm({
                    title: 'Tem certeza?',
                    content: 'Você realmente deseja excluir este funcionário?'
                })
                .then(() => {
                    this.deleteEmployee(id)
                        .then(res => this.loadEmployees(true))
                })
                .catch(() => {
                    this.$notify({
                            type: 'warning',
                            content: 'Registro não deletado.'
                        })
                })
      },
      load() {
          this.loadEmployees()
          this.loadEmployeeTypes()
      }
  },
  beforeMount() {
      this.load()
  },
  components: {
    'list': List,
    'search': Search
  }
}
</script>