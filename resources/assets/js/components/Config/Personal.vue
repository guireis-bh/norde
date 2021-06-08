<template>
<block-form 
    title="Configurações de usuário"
    subtitle="Change your infos"
    :helper="helper"
    :submit="submit"
>
    <div class="row">
        <vue-user :userID="inputs.user_id ? inputs.user_id : false"/>
        <div class="row"></div>
        <vue-address :addressID="inputs.address_id ? inputs.address_id : false"/>
        <div class="row"></div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Informações Adicionais</label>
                <textarea class="form-control" rows="4"></textarea>
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
                <router-link :to="{ name: 'relative-list' }" class="btn btn-warning">
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
import { mask } from 'vue-the-mask'
import UserFormPipeline from '../../objects/user_form_pipeline'
import BlockForm from '../Block/Form.vue'
import BlockUserForm from '../Block/User/Form.vue'
import BlockAddressForm from '../Block/Address/Form.vue'
import BlockConfigForm from '../Block/Config/Form.vue'

export default {
  name: 'ConfigPersonal',
  data() {
      return {
          helper: {
            title: 'Configurações de usuários',
            subtitle: 'Aqui você pode alterar suas configurações de usuário.'
          },
          inputs: {
            id: null,
            user_id: null,
            address_id: null
          },
          configs: {}
      }
  },
  methods: {
    ...mapActions([
        'loadConfigs',
        'loadAddress',
        'loadUsers'
    ]),
    setUserID(id) {
        this.inputs.user_id = id
    },
    submit() {
        let UserComponent = this.$children[0].$children[0]
        let AddressComponent = this.$children[0].$children[1]
        let ConfigComponent = this.$children[0].$children[2]
        UserFormPipeline({
            UserComponent,
            AddressComponent,
            ConfigComponent
        }, null, this,
        user => {
            this.loadUsers(true)
            this.loadAddress(true)
            this.loadConfigs(true)
            return user
        })
    },
    load() {
        this.loadUsers()
        this.loadAddress()
        this.loadConfigs()
        let user = this.$store.getters.userByID(this.$store.getters.user.id)
        this.inputs.user_id = user.id
        this.inputs.address_id = user.address_id
        
        let configs = this.$store.getters.configsByUserID(user.user_id)
        configs.forEach(el => {
            this.configs[el.key] = el.value == 1 ? true : false
        })
    }
  },
  beforeMount() {
      this.load()
  },
  components: {
      'block-form': BlockForm,
      'vue-user': BlockUserForm,
      'vue-address': BlockAddressForm,
      'vue-config': BlockConfigForm
  },
  directives: {
      mask
  }
}
</script>