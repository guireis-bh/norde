<template>
<div class="row">
    <list 
    slug="alunos"
    title="Lista de Estudantes"
    :fields="fields"
    :items="studants"
     rowRouter="studant-view"
    />

    <search :links="links" />
</div>
</template>

<script>
import Vue from 'vue'
import { MessageBox, Notification } from 'uiv'
import { mapActions } from 'vuex'
import List from '../Block/List.vue'
import Search from '../Block/Search.vue'

Vue.prototype.$confirm = MessageBox.confirm
Vue.prototype.$notify = Notification.notify

export default {
  name: 'StudantList',
  data() {
      return {
        fields: [
            {
                label: 'Nome',
                column: 'name',
                colmd: 'col-md-2'
            },
            {
                label: 'Sobrenome',
                column: 'surname',
                colmd: 'col-md-2'
            },
            {
                label: 'Email',
                column: 'email',
                colmd: 'col-md-3'
            },
            {
                label: 'Celular',
                column: 'cellphone',
                colmd: 'col-md-2'
            },
            {
                label: 'Ações',
                column: 'actions',
                colmd: 'col-md-1'
            }
        ],
        links: [
            {
                route: 'studant-form',
                text: 'Adicionar estudante',
                icon: 'user'
            },
            {
                route: 'relative-list',
                text: 'Listar estudante',
                icon: 'list'
            },
            {
                route: 'relative-form',
                text: 'Adicionar familiar',
                icon: 'user'
            }
        ]
      }
  },
  computed: {
      studants() {
          let studants = this.$store.getters.studants
          let parsedStudants = []
          Object.keys(studants).forEach(key => {
              parsedStudants[key] = {
                id: studants[key].id,
                name: studants[key].user.name,
                surname: studants[key].user.surname,
                email: studants[key].user.email,
                homephone: studants[key].user.homephone,
                cellphone: studants[key].user.cellphone,
                actions: [
                    {
                        route: 'studant-edit',
                        icon: 'pencil'
                    },
                    {
                        icon: 'remove',
                        func: this.deleteOne
                    }
                ]
            }
          })
          return parsedStudants
      }
  },
  methods: {
      ...mapActions([
          'loadStudants',
          'deleteStudant'
      ]),
      deleteOne(id) {
          this.$confirm({
                    title: 'Tem certeza?',
                    content: 'Você realmente deseja excluir este estudante?'
                })
                .then(() => {
                    this.deleteStudant(id)
                        .then(res => this.loadStudants(true))
                })
                .catch(() => {
                    this.$notify({
                            type: 'warning',
                            content: 'Registro não deletado.'
                        })
                })
      },
      load() {
          this.loadStudants()
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