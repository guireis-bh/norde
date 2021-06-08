<template>
<div id="Calendar">
    <Header />
    <div class="modal fade" id="modalEvent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="eventTitulo" class="modal-title">Evento</h4>
                    <div class="row">
                        <div class="col-md-6">  <h4><small id="eventDatas"> </small></h4> </div>
                        <div class="col-md-6 eventStatus">

                        </div>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong> Serviço : </strong><br /> <p id="eventServico"></p>
                        </div>
                        <div class="col-md-6">
                            <strong> Local: </strong><br /> <p id="eventLocal"></p>
                        </div>
                        <div class="col-md-6">
                            <strong> Professor : </strong> <br /> <p id="eventProfessor"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Salario : </strong><br /><p id="eventSalario"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Duração : </strong> <br /> <p id="eventDuracao"></p>
                        </div>
                        <br />
                        <div class="col-md-12">
                            <strong>Criado em: </strong><br /> <p id="eventCriado"></p>
                        </div>
                        <div class="col-md-12">
                            <strong>Modificado em: </strong><br /> <p id="eventModificado"></p>
                        </div>
                    </div>
                    <h1></h1>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Estudantes : </strong>
                            <p id="eventEstudantes"></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Custo :</strong>
                            <p id="eventCustos"></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Status :</strong>
                            <p id="eventEstudanteStatus"></p>
                        </div>
                    </div>
                    <h1></h1>
                </div>
                <div class="modal-footer text-center">
                    <!-- <button type="button" id="btnEventoDeletar" class="btn btn-danger  pull-left">Deletar</button> -->
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                    <button type="button" id="btnEventoEditar" class="btn btn-default pull-left">Editar</button>
                    <button type="button" id="btnEventoCompletar" class="btn btn-success pull-right">Completar</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="box">
                        <div id='calendar'></div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="box" style="padding: 0px;">
                            <!--Date picker-->
                            <div class="row">
                                <div class="col-md-1">
                                    <div id="datepicker" class="datePickerStyle"></div>
                                    <input type="hidden" id="hiddenDatePicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="box">
                            <div class="form-group textCenter"><!--Pesquisas-->
                                <select class="form-control selectLista estudante_professorInp"> <!--Funcionario-->
                                </select>
                                <select class="form-control selectLista local_padraoInp"> <!--local-->
                                </select>
                                <select class="form-control selectLista servico_padraoInp"> <!--Servico-->
                                </select>
                                <select class="form-control selectLista nomeEstudante"> <!--Estudante-->
                                </select>
                                <select class="form-control selectLista estudanteFamiliarInp"> <!--Familia-->
                                </select>
                                <button class="btn btn-default btnLista" onclick="window.location.reload()">Limpar</button>
                                <button type="submit" class="btn btn-default btn-primary btnSearch">Aceitar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</template>

<script>
import Header from './Block/Header.vue'

export default {
  name: 'Calendar',
  mounted() {
    console.log('Calendar is monted')
  },
  components: {
    Header,
  }
}
</script>