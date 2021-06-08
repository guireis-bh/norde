<template>
    <vue-view
        title="Informações do estudante"
        subtitle="Detalhes das informações dos estudantes"
        :helper="helper"
        :links="links"
    >
        <vue-user :user="studant.user" />
        <div class="row"></div>
        <vue-address :id="studant.user.address_id" />
        <div class="row"></div>
    </vue-view>
</template>

<script>
import BlockView from '../Block/View.vue'
import BlockUserView from '../Block/User/View.vue'
import BlockAddressView from '../Block/Address/View.vue'

export default {
    name: 'StudantView',
    data() {
      return {
        links: [
            {
                route: 'studant-list',
                text: 'Listar Estudantes',
                icon: 'list'
            },
            {
                route: 'studant-form',
                text: 'Adicionar Estudante',
                icon: 'user'
            }
        ],
        helper: {
            title: 'Informações',
            subtitle: 'Aqui você pode visualizar um geral das informações do estudante.'
        },
      }
    },
    computed: {
      studant() {
          return this.$store.getters.studantByID(this.$route.params.id)
      }
    },
    components: {
        'vue-view': BlockView,
        'vue-user': BlockUserView,
        'vue-address': BlockAddressView
    }
}
</script>