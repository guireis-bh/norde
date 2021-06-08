<template>
    <div id="form-user">
        <h1>Dados Pessoais</h1>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nome</label>
                {{ user.salute }} {{ user.name }} {{ user.surname }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Email</label>
                {{ user.email }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Data de Nascimento</label>
                {{ user.birthday }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>RG</label>
                {{ user.rg }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>CPF</label>
                {{ user.cpf }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Celular</label>
                {{ user.cellphone }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Telefone Residencial</label>
                {{ user.homephone }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Telefone de trabalho</label>
                {{ user.workphone }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Origem</label>
                {{ user.know_from }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BlockUserView',
    props: {
        user: {
            type: Object,
            required: true
        }
    }    
}
</script>