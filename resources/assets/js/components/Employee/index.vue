<template>
<div id="Employee">
    <Header/>
    <section>
        <!--Loader-->
        <div id="loaderDiv" class="loaderDiv col-md-12">
            <div class="loader"></div>
        </div>
        <div class="container-fluid">
            <router-view></router-view>
        </div>
    </section>
</div>
</template>

<script>
import Header from '../Block/Header.vue'

export default {
  name: 'Employee',
  mounted() {
    console.log('Employee is monted')
  },
  components: {
      Header
  }
}
</script>