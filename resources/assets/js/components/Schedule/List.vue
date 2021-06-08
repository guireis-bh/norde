<template>
<div class="row">
    <list 
        slug="schedules"
        title="Lista de Cronograma"
        :fields="fields"
        :items="schedules"
        rowRouter="schedule-view"
    />

    <search :links="links" />
</div>
</template>

<script>
import Vue from 'vue'
import { mapActions } from 'vuex'
import { MessageBox, Notification } from 'uiv'
import List from '../Block/List.vue'
import Search from '../Block/Search.vue'

Vue.prototype.$confirm = MessageBox.confirm
Vue.prototype.$notify = Notification.notify

let moment = require('moment')

export default {
  name: 'ScheduleList',
  data() {
      return {
        fields: [
            {
                label: 'Professor',
                column: 'teacher',
                colmd: 'col-md-2'
            },
            {
                label: 'Qtd. de cronogramas',
                column: 'amount',
                colmd: 'col-md-2'
            },            
            {
                label: 'Qtd. de alunos',
                column: 'students_amount',
                colmd: 'col-md-2'
            },
            {
                label: 'Horas disponiveis',
                column: 'available_hours',
                colmd: 'col-md-2'
            },
            {
                label: 'Horas ocupadas',
                column: 'reserved_hours',
                colmd: 'col-md-2'
            },
            {
                label: 'Ações',
                column: 'actions',
                colmd: 'col-md-1'
            }
        ],
        links: [
            {
                route: 'schedule-form',
                text: 'Adicionar Cronograma',
                icon: 'user'
            },
            {
                route: 'studant-form',
                text: 'Adicionar estudante',
                icon: 'user'
            },
            {
                route: 'relative-form',
                text: 'Adicionar familiar',
                icon: 'user'
            },
            {
                route: 'studant-list',
                text: 'Listar estudante',
                icon: 'list'
            }
        ]
      }
  },
  computed: {
      schedules() {
          let teachers = this.$store.getters.teachers
          let parsedSchedules = [];
          Object.keys(teachers).forEach(key => {
              let schedules = this.$store.getters.scheduleByTeacherID(teachers[key].id)
              parsedSchedules[key] = {
                id: teachers[key].id,
                teacher:  teachers[key].user.salute + ' ' + teachers[key].user.name + ' ' + teachers[key].user.surname,
                amount: schedules.length,
                students_amount: 0,
                available_hours: moment.duration({
                        minutes: schedules.reduce((total, schedule) => {
                            let begin = schedule.day + ' ' + schedule.hour_begin
                            let end = schedule.day + ' ' + schedule.hour_end
                            return total += moment(end).diff(begin, 'minutes')
                        }, 0)
                    }).humanize(),
                reserved_hours: 0,
                actions: [
                    {
                        route: 'schedule-edit',
                        icon: 'pencil'
                    },
                    {
                        icon: 'remove',
                        func: this.deleteOne
                    }
                ]
              }
          })
          return parsedSchedules
      }
  },
  methods: {
      ...mapActions([
          'loadTeachers',
          'loadSchedules',
          'deleteSchedule'
      ]),
      getScheduleName(id) {
          return this.$store.getters.scheduleByID(id).name
      },
      deleteOne(id) {
          this.$confirm({
                    title: 'Tem certeza?',
                    content: 'Você realmente deseja excluir este funcionário?'
                })
                .then(() => {
                    this.deleteSchedule(id)
                        .then(res => this.loadSchedules(true))
                })
                .catch(() => {
                    this.$notify({
                            type: 'warning',
                            content: 'Registro não deletado.'
                        })
                })
      },
      load() {
          this.loadTeachers()
          this.loadSchedules()
      }
  },
  beforeMount() {
      this.load()
  },
  components: {
    'list': List,
    'search': Search
  }
}
</script>