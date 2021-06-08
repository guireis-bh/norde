<template>
<div class="row">
    <list 
    slug="familiares"
    title="Lista de Familiares"
    :fields="fields"
    :items="relatives"
    rowRouter="relative-view"
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
  name: 'RelativeList',
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
                colmd: 'col-md-2'
            },
            {
                label: 'Celular',
                column: 'cellphone',
                colmd: 'col-md-2'
            },
            {
                label: 'Familia',
                column: 'family',
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
                route: 'relative-form',
                text: 'Adicionar famíliar',
                icon: 'user'
            },
            {
                route: 'studant-list',
                text: 'Listar estudantes',
                icon: 'list'
            },
            {
                route: 'studant-form',
                text: 'Adicionar estudante',
                icon: 'user'
            }
        ]
      }
  },
  computed: {
      relatives() {
          let relatives = this.$store.getters.relatives
          let parsedRelatives = []
          Object.keys(relatives).forEach(key => {
              parsedRelatives[key] = {
                id: relatives[key].id,
                name: relatives[key].user.name,
                surname: relatives[key].user.surname,
                email: relatives[key].user.email,
                cellphone: relatives[key].user.cellphone,
                family: relatives[key].family.name,
                actions: [
                    {
                        route: 'relative-edit',
                        icon: 'pencil'
                    },
                    {
                        icon: 'remove',
                        func: this.deleteOne
                    }
                ]
              }
          })
          return parsedRelatives
      }
  },
  methods: {
      ...mapActions([
          'loadRelatives',
          'deleteRelative'
      ]),
      deleteOne(id) {
          this.$confirm({
                    title: 'Tem certeza?',
                    content: 'Você realmente deseja excluir este familiar?'
                })
                .then(() => {
                    this.deleteRelative(id)
                        .then(res => this.loadRelatives(true))
                })
                .catch(() => {
                    this.$notify({
                            type: 'warning',
                            content: 'Registro não deletado.'
                        })
                })
      },
      load() {
          this.loadRelatives()
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