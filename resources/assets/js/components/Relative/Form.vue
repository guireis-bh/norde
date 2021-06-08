<template>
<block-form 
 title="Novo Familiar"
 subtitle="Informações de Contato"
 :helper="helper"
 :submit="submit"
 >
    <div class="row">
        <vue-family :familyID="inputs.family_id ? inputs.family_id : false" />
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
import BlockForm from './../Block/Form.vue'
import BlockUserForm from './../Block/User/Form.vue'
import BlockAddressForm from './../Block/Address/Form.vue'
import BlockFamily from './../Block/Family.vue'
import BlockConfigForm from './../Block/Config/Form.vue'

export default {
  name: 'RelativeForm',
  data() {
      return {
          helper: {
            title: 'Criação de familiar',
            subtitle: 'Este formulário irá lhe auxiliar a criação de um familiar responsável que poderá ser vinculado a algum aluno.'
          },
          inputs: {
            id: null,
            user_id: null,
            address_id: null,
            family_id: null
          },
          configs: {}
      }
  },
  methods: {
    ...mapActions([
        'createRelative',
        'updateRelative',
        'loadRelatives',
        'loadFamilies',
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
        let UserComponent = this.$children[0].$children[1]
        let AddressComponent = this.$children[0].$children[2]
        let ConfigComponent = this.$children[0].$children[3]
        let role = 'relative'
        UserFormPipeline({
            UserComponent,
            AddressComponent,
            ConfigComponent
        }, role, this,
        user => {
            return FamilyComponent.submit()
                .then(family => {
                    this.setFamilyID(family.id)
                    return this.inputs.id ?
                        this.updateRelative(this.inputs) : this.createRelative(this.inputs)
                })
        },
        res => {
            if(res.status === 201) {
                this.loadRelatives(true)
                this.loadFamilies(true)
                this.$router.push({ name: 'relative-list' })
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
    load() {
        this.loadRelatives()
        this.loadFamilies()
        this.loadConfigs()
        if(this.$route.params.id) {
            let relative = this.$store.getters.relativeByID(this.$route.params.id)
            this.inputs.id = relative.id
            this.inputs.user_id = relative.user_id
            this.inputs.address_id = relative.user.address_id
            this.inputs.family_id = relative.family_id
            
            let configs = this.$store.getters.configsByUserID(relative.user_id)
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
      'vue-family': BlockFamily,
      'vue-config': BlockConfigForm
  },
  directives: {
      mask
  }
}
</script>