<template>
  <div id="vue-app">
    <router-view></router-view>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'App',
  methods: {
    ...mapActions([
      'verify'
    ]),
    check() {
      if(this.$router.currentRoute.name !== 'login') {
        this.verify()
          .catch(err => {
            console.error(err)
            if(err.status === 401) {
              this.$router.push({name: 'login'})
            }
          })
      } 
    }
  },
  mounted() {
    this.check()
    console.log('App is monted')
  }
}
</script>