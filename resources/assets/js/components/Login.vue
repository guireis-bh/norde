<template>
<section class="justify-content-md-center">
	<!--Loader-->
	<div id="loaderDiv" class="loaderDiv col-md-12"> 
		<div class="loader"></div>
	</div>
	<div class="container-fluid justify-content-md-center">
		<br/>
		<br/>
		<div class="row text-center">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">
				<img src="/images/norde.png"  class="logoSession"/>
				<br/>
                <form action="#" @submit.prevent="submit" >
                    <div class="box boxSession">
                        <div class="row">
                            <div class="col-md-12">
                                <h1>Logar  <!-- <i class="glyphicon glyphicon-question-sign pull-right iconMain" aria_hidden="true"></i> --></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group margin-bottom-sm">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope" aria_hidden="true"></i></span>
                                    <input class="form-control" id="email" v-model="email" type="text" placeholder="Endereço de Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock" aria_hidden="true"></i></span>
                                    <input class="form-control"  id="password" v-model="password" type="password" placeholder="Senha">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br/>
                                <button type="submit" id="btnLogin" class="btn btn-default btn-primay">LOGAR</button>
                                <br/><br/>
                                <!--<a href="registrar.html"><strong> Registrar </strong></a><br/>-->
                                <a href="aluno/registrar.html"><strong> Registrar usuário - Aluno </strong></a><br/>
                                <a href="familiar/registrar.html"><strong> Registrar usuário - Familiar</strong></a><br/>
                                <a href="funcionario/registrar.html"><strong> Registrar usuário - Funcionario</strong></a><br/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
			<div class="col-md-3">
			</div>
		</div>
	</div>
</section>
</template>

<script>
import {mapActions} from 'vuex'

export default {
    name: 'Login',
    data() {
        return {
            email: "",
            password: ""
        }
    },
    methods: {
        ...mapActions([
            'login'
        ]),
        submit(e) {
            let self = this
            this.login({
                username: this.email,
                password: this.password
            })
            .then((res) => {
                if(res.status === 200) {
                    self.redirect(res.data.redirect)
                } else {
                    alert(res.data.message)
                }
            })
        },
        redirect(path) {
            this.$router.push({path: path})
        }
    },
    mounted() {
        console.log('Login is monted')
    }
}
</script>