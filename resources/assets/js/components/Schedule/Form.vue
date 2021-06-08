<template>
    <block-form 
    title="Adicione Cronogramas"
    subtitle="Adicione cronogramas a um professor"
    :helper="helper"
    :submit="submit"
    >
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-typehead" :class="{ 'has-error': hasError.name }">
                    <label>Nome do professor(a) *</label>
                    <input
                        id="teacher"
                        name="teacher"
                        :value="inputs.teacher.name"
                        type="text"
                        class="form-control"
                        placeholder="Nome do professor(a) (ex: 'Sr. Pasquale')."
                        v-on:keypress.enter.prevent="supress"
                        :disabled="disabledTeacher"
                    >
                    <uiv-typehead
                        v-model="inputs.teacher"
                        target="#teacher"
                        :data="teachers"
                        item-key="name"
                    />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="box">
                <h1>
                    Horarios 
                    <span @click="addSchedule()" class="glyphicon glyphicon-plus" style="cursor:pointer" aria-hidden="true"></span>
                </h1>
                <template v-for="schedule in inputs.schedules">
                    <div class="row" :key="schedule.id">
                        <div class="col-md-6">
                            <div class="form-group" :class="{ 'has-error': hasError.day }">
                                <label>Dia</label>
                                <input id="day" v-model="schedule.day" name="day" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row"></div>
                        <div class="col-md-6">
                            <div class="form-group" :class="{ 'has-error': hasError.hour_begin }">
                                <label>Horario de inicio</label>
                                <input id="hour_begin" v-model="schedule.hour_begin" name="hour_begin" type="time" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" :class="{ 'has-error': hasError.hour_end }">
                                <label>Horário fim</label>
                                <input id="hour_end" v-model="schedule.hour_end" name="hour_end" type="time" class="form-control">
                            </div>
                        </div>
                    </div>
                    <h1>&nbsp;</h1>
                </template>
            </div>
        </div>
        <div class="box-botao">
            <ul class="list-unstyled list-inline">
                <li>
                    <router-link :to="{ name: 'schedule-list' }" class="btn btn-warning">
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
import { Typeahead } from 'uiv'
import { mapActions } from 'vuex'
import BlockForm from '../Block/Form.vue'

export default {
    name: 'ScheduleForm',
    data() {
        return {
            helper: {
                title: 'Criação de cronograma',
                subtitle: 'Este formulário irá lhe auxiliar a criação de um novo cronograma associado a um professor.'
            },
            inputs: {
                teacher: {
                    id: null,
                    name: ''
                },
                schedules: [
                    {
                        id: null,
                        day: '',
                        hour_begin: '',
                        hour_end: ''
                    }
                ]
            },
            disabledTeacher: false,
            hasError: {
            }
        }
    },
    computed: {
        teachers() {
            let teachers = this.$store.getters.teachers
            let results = []
            teachers.forEach((el, inx) => {
                results[inx] = {
                    id: el.id,
                    name: el.user.salute + ' ' + el.user.name + ' ' + el.user.surname
                }
            })
            return results;
        }
    },
    methods: {
        ...mapActions([
            'loadTeachers',
            'loadSchedules',
            'createSchedule',
            'updateSchedule'
        ]),
        addSchedule() {
            this.inputs.schedules.unshift({
                id: null,
                day: '',
                hour_begin: '',
                hour_end: ''
            })
        },
        submit() {
            this.inputs.schedules.forEach(schedule => {
                schedule.teacher_id = this.inputs.teacher.id
                new Promise(resolve => {
                        resolve(
                            schedule.id ? 
                                this.updateSchedule(schedule) : this.createSchedule(schedule)
                        )
                    })
                    .then(res => {
                        schedule.id = res.data.id
                        this.loadSchedules(true)
                    })
            })
        },
        supress(e) {
            e.preventDefault()
        },
        load() {
            this.loadTeachers()
            this.loadSchedules()
            if(this.$route.params.id) {
                let teacher = this.$store.getters.teacherByID(this.$route.params.id)
                this.inputs.teacher = {
                    id: teacher.id,
                    name: teacher.user.salute + ' ' + teacher.user.name + ' ' + teacher.user.surname
                }
                this.inputs.schedules = this.$store.getters.scheduleByTeacherID(teacher.id)
                this.disabledTeacher = true
            }
        }
    },
    beforeMount() {
        this.load()
    },
    components: {
        'block-form': BlockForm,
        'uiv-typehead': Typeahead
    }
}
</script>