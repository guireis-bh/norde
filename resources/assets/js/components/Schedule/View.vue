<template>
    <vue-view
        title="Informações do Cronograma"
        subtitle="Detalhes do cronograma"
        :helper="helper"
        :links="links"
    >
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Nome do professor(a) *</label>
                    {{ teacher.name }}
                </div>
            </div>
        </div>
        <div class="box">
            <h1>
                Horarios 
            </h1>
            <template v-for="schedule in teacher.schedules">
                <div class="row" :key="schedule.id">
                    <h2>Cronograma</h2>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Data:&nbsp;</label>{{ formatSchedule(schedule) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tempo:&nbsp;</label>{{ getScheduleDuration(schedule) }}
                        </div>
                    </div>
                    <h2>
                        Alunos
                        <span 
                            @click="showInputs(schedule.id)"
                            class="glyphicon glyphicon-plus"
                            style="cursor:pointer" aria-hidden="true">
                        </span>
                    </h2>
                    <div class="box" v-show="hasShowInputs(schedule.id)">
                        <div class="col-md-6">
                            <div class="form-group form-typehead">
                                <label>Aluno(a)</label>
                                <input
                                    id="studant"
                                    name="studant"
                                    :value="inputs.studant.name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Nome do estudante(a) (ex: 'Joazinho')."
                                    v-on:keypress.enter.prevent="supress"
                                />
                                <uiv-typehead
                                    v-model="inputs.studant"
                                    target="#studant"
                                    :data="studants"
                                    item-key="name"
                                />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tempo</label>
                                <input
                                    id="time"
                                    name="time"
                                    v-model="inputs.time"
                                    type="number"
                                    class="form-control"
                                />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button 
                                    @click="addScheduleStudant()"
                                    class="glyphicon glyphicon-check"
                                    style="margin-top: 23px; padding: 8px"
                                >
                                </button>
                            </div>
                        </div>
                    </div>
                    <list 
                        slug="schedule_studants"
                        title="Lista de Alunos"
                        :items="schedule.studants"
                        :fields="fields"
                        />
                </div>
                <h1>&nbsp;</h1>
            </template>
        </div>
    </vue-view>
</template>

<script>
import Vue from 'vue'
import { Typeahead } from 'uiv'
import { mapActions } from 'vuex'
import { MessageBox, Notification } from 'uiv'
import List from '../Block/List.vue'
import BlockView from '../Block/View.vue'

Vue.prototype.$confirm = MessageBox.confirm
Vue.prototype.$notify = Notification.notify

let moment = require('moment')

export default {
    name: 'ScheduleView',
    data() {
        return {
            links: [
                {
                    route: 'schedule-list',
                    text: 'Listar Cronogramas',
                    icon: 'list'
                },
                {
                    route: 'schedule-form',
                    text: 'Adicionar Cronograma',
                    icon: 'time'
                }
            ],
            fields: [
                {
                    label: 'Aluno(a)',
                    column: 'name',
                    colmd: 'col-md-4'
                },
                {
                    label: 'Concluido',
                    column: 'time_done',
                    colmd: 'col-md-2'
                },
                {
                    label: 'Reservado',
                    column: 'time_reserved',
                    colmd: 'col-md-2'
                },
                {
                    label: 'Ações',
                    column: 'actions',
                    colmd: 'col-md-2'
                }
            ],
            teacher: {
                id: null,
                name: ''
            },
            inputs: {
                schedule_id: null,
                studant: {
                    id: null,
                    name: ''
                },
                time: 0
            },
            helper: {
                title: 'Informações',
                subtitle: 'Aqui você pode visualizar um geral das informações do cronograma do professor.'
            }
        }
    },
    computed: {
        studants() {
            let studants = this.$store.getters.studants
            let results = []
            studants.forEach((el, inx) => {
                results[inx] = {
                    id: el.id,
                    name: el.user.name + ' ' + el.user.surname
                }
            })
            return results;
        }
    },
    methods: {
        ...mapActions([
            'loadTeachers',
            'loadSchedules',
            'loadStudants',
            'loadSchedulesStudants',
            'createScheduleStudant',
            'deleteScheduleStudant'
        ]),
        formatSchedule(schedule) {
            return moment(
                    schedule.day + ' ' + schedule.hour_begin
                )
                .format('DD/MM/YYYY HH:mm') + '-' 
                + moment(schedule.day + ' ' + schedule.hour_end).format('HH:mm')
        },
        getScheduleDuration(schedule) {
            return moment.duration({
                minutes: moment(schedule.day + ' ' + schedule.hour_begin)
                    .diff(schedule.day + ' ' + schedule.hour_end, 'minutes')
            }).humanize()
        },
        addScheduleStudant() {
            this.createScheduleStudant(
                {
                    schedule_id: this.inputs.schedule_id,
                    studant_id: this.inputs.studant.id,
                    time_reserved: moment({minutes: parseInt(this.inputs.time)}).format('HH:mm')
                }
            )
            .then(res => {
                this.loadSchedulesStudants(true)
                this.setUpScheduleStudant()
            })
        },
        deleteOne(id) {
            this.$confirm({
                    title: 'Tem certeza?',
                    content: 'Você realmente deseja excluir este agendamento?'
                })
                .then(() => {
                    this.deleteScheduleStudant(id)
                        .then(res => {
                            this.loadSchedules(true)
                            this.loadStudants(true)
                            this.loadSchedulesStudants(true)
                            this.setUpScheduleStudant()
                        })
                })
                .catch(() => {
                    this.$notify({
                            type: 'warning',
                            content: 'Registro não deletado.'
                        })
                })
        },
        supress(e) {
            e.preventDefault()
        },
        showInputs(id) {
            this.inputs =  {
                schedule_id: null,
                studant: {
                    id: null,
                    name: ''
                },
                time: 0
            }
            this.inputs.schedule_id = id
        },
        hasShowInputs(id) {
            return this.inputs.schedule_id == id
        },
        setUpScheduleStudant() {
            let teacher = this.$store.getters.teacherByID(this.$route.params.id)
            let schedules = this.$store.getters.scheduleByTeacherID(teacher.id)
            schedules.forEach(schedule => {
                this.loadSchedulesStudants(schedule.id)
                    .then(studants => {
                        if(studants.length > 0) {
                            studants.forEach((studant, index) => {
                                let the = this.$store.getters.studantByID(studant.studant_id)
                                if(the) {
                                    Vue.set(studant, 'name', the.user.name + ' ' + the.user.surname)
                                    Vue.set(studant, 'actions', [
                                            {
                                                icon: 'remove',
                                                func: this.deleteOne
                                            }
                                        ]
                                    )
                                }
                            })
                        }
                        Vue.set(schedule, 'studants', studants)
                    })
            })
            this.teacher = {
                id: teacher.id,
                name: teacher.user.salute + ' ' + teacher.user.name + ' ' + teacher.user.surname,
                schedules: schedules
            }
        },
        load() {
            this.loadTeachers()
            this.loadSchedules()
            this.loadStudants()
            this.setUpScheduleStudant()
        }
    },
    beforeMount() {
        this.load()
    },
    components: {
        'vue-view': BlockView,
        'uiv-typehead': Typeahead,
        'list': List
    }
}
</script>