<template>
    <vue-view
        title="Informações do familiar"
        subtitle="Detalhes das informações dos familiares"
        :helper="helper"
        :links="links"
    >
        <vue-user :user="relative.user" />
        <div class="row"></div>
        <vue-address :id="relative.user.address_id" />
        <div class="row"></div>
    </vue-view>
</template>

<script>
import BlockView from '../Block/View.vue'
import BlockUserView from '../Block/User/View.vue'
import BlockAddressView from '../Block/Address/View.vue'

export default {
    name: 'RelativeView',
    data() {
      return {
        links: [
            {
                route: 'relative-list',
                text: 'Listar Familiares',
                icon: 'list'
            },
            {
                route: 'relative-form',
                text: 'Adicionar Familiar',
                icon: 'user'
            }
        ],
        helper: {
            title: 'Informações',
            subtitle: 'Aqui você pode visualizar um geral das informações do familiar.'
        },
      }
    },
    computed: {
      relative() {
          return this.$store.getters.relativeByID(this.$route.params.id)
      }
    },
    components: {
        'vue-view': BlockView,
        'vue-user': BlockUserView,
        'vue-address': BlockAddressView
    }
}
</script>