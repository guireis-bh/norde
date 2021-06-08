<template>
<block-form 
    title="Alterar senha"
    subtitle="Escolha uma nova senha a ser utilizada no login"
    :helper="helper"
    :submit="submit"
>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Senha anterior *</label>
                <input id="old" name="old" v-model="inputs.old" type="password" class="form-control">
            </div>
        </div>
        <div class="row"></div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nova senha *</label>
                <input id="password" name="password" v-model="inputs.password" type="password" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Repita a nova senha *</label>
                <input id="repassword" name="repassword" v-model="inputs.repassword" type="password" class="form-control">
            </div>
        </div>
    </div>
 
    <div class="box-botao">
        <ul class="list-unstyled list-inline">
            <li>
                <router-link :to="{ name: 'dashboard' }" class="btn btn-warning">
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
import BlockForm from '../Block/Form.vue'

export default {
  name: 'ConfigChangePassword',
  data() {
      return {
          helper: {
            title: 'Alterar senha',
            subtitle: 'Aqui você pode alterar senha de usuário.'
          },
          inputs: {
            old: '',
            password: '',
            repassword: ''
          }
      }
  },
  methods: {
    ...mapActions([
        'changeUserPassword'
    ]),
    submit() {
        this.changeUserPassword(this.inputs)
            .then(res => {
                alert('Senha alterada')
            })
            .catch(err => {
                alert('Senha não alterada')
            })
    }
  },
  components: {
      'block-form': BlockForm
  }
}
</script>