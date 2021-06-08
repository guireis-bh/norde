<template>
<div id="Dashboard">
    <Header/>
    <section>
        <div class="row">
            <!--Loader-->
            <div id="loaderDiv" class="loaderDiv col-md-12">
                <div class="loader"></div>
            </div>
            <!-- Containers abaixo-->
            <!--Container Updates -->
            <div class="col-md-6">
                <div class="container-fluid">
                    <div class="box dashFaturaDiv">
                        <h1>Atualizações <small> v.Alpha 0.1.9 - 09/05/2018</small></h1>
                        <h3>
                            <b>-</b>Correção de lista de alunos no professor<br />
                            <b>-</b>Professores podem selecionar qualquer aluno disponível<br />
                            <b>-</b>Correção no envio de erros e sugestões<br />
                            <b>-</b>Correção no cadastro de eventos em serie<br />
                            <b>-</b>Correção no filtro de relatórios de aulas<br />
                            <b>-</b>Correção no filtro de relatórios de aulas no calendário<br />
                        </h3>
                        <a href="change-log.php" class="btn btn-default "> Ver todas as atualizaçoes </a>
                    </div>
                </div>
            </div>
                    <!--Container grafico 2-->
            <div class="col-md-6">
                <div class="container-fluid text-center">
                    <div class="box dashGraphDiv">
                        <h1>Ultimas Faturas</h1>
                        <canvas id="chart2" width="400" height="225"></canvas>
                    </div>
                </div>
            </div>
            <!--Container grafico 3-->
            <div class="col-md-6">
                <div class="container-fluid text-center">
                    <div class="box dashGraphDiv">
                        <h1>Ultimos Pagamentos</h1>
                        <canvas id="chart3" width="400" height="225"></canvas>
                    </div>
                </div>
            </div>
            <!--Container grafico 1-->
            <div class="col-md-6">
                <div class="container-fluid">
                    <div class="box dashGraphDiv text-center">
                        <h1>Ultimas Aulas</h1>
                        <canvas id="chart1" width="400" height="225"></canvas>
                    </div>
                </div>
            </div>
                    <!--Container Estatisticas -->
            <div class="col-md-6">
                <div class="container-fluid">
                    <div class="box dashFaturaDiv">
                        <h1>Estatísticas</h1>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h2> Estudantes Ativos</h2>
                                <span class="dashBold" id="estudantesAtivos">0</span>
                            </div>
                            <div class="col-md-4">
                                <h2> Professores Ativos</h2>
                                <span class="dashBold" id="professoresAtivos">0</span>
                            </div>
                            <div class="col-md-4">
                                <h2>Total de Faturas</h2>
                                <span class="dashBold" id="totalFaturas">R$ 0.00</span>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h2> Aulas de estudantes</h2>
                                <span class="dashBold" id="aulasEstudantes">0</span>
                            </div>
                            <div class="col-md-4">
                                <h2>Horas de estudantes</h2>
                                <span class="dashBold" id="horasEstudantes">0</span>
                            </div>
                            <div class="col-md-4">
                                <h2> Pagamentos</h2>
                                <span class="dashBold" id="pagamentosTotais"> R$ 0.00</span>
                            </div>
                            <br />
                        </div>
                    </div>
                    <!-- <button type="button" class="btn btn-default btn-primary" id="sendEmail">Enviar email</button>-->
                </div>
            </div>
            <!--Container Faturas -->
            <div class="col-md-6">
                <div class="container-fluid">
                    <div class="box dashFaturaDiv">
                        <h1>Faturas Atrasadas</h1>
                        <div class="row text-center">
                            <div class="col-md-3 dashBold">Fatura</div>
                            <div class="col-md-3 dashBold">Cliente</div>
                            <div class="col-md-3 dashBold">Data</div>
                            <div class="col-md-3 dashBold">Balanço</div>
                        </div>
                        <div class="htmlAtrasos">
                        </div>
                        <h1></h1>
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
  name: 'Dashboard',
  mounted() {
    console.log('Dashboard is monted')
  },
  components: {
    Header,
  }
}
</script>
