<template>
<div id="Relative">
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
  name: 'Relative',
  mounted() {
    console.log('Relative is monted')
  },
  components: {
      Header
  }
}
</script>