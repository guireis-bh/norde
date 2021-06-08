<template>
<div class="col-md-2 col-sm-2">
    <div class="box-lista">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <!--<div class="input-group">
                    <input type="text" class="form-control searchListInp" placeholder="Procurar...">
                    <span class="input-group-btn">
                        <button class="btn btn-default btnSearchList" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </span>
                </div>--><!-- /input-group -->
                <div class="list-group">
                    <small>
                        <router-link v-for="link in links" :key="link.route"
                         :to="{ name: link.route }"
                         class="list-group-item"
                        >
                            <span :class="'glyphicon glyphicon-' + link.icon" aria-hidden="true"></span>
                            {{ link.text }}
                         </router-link>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
  name: 'Search',
  props: [
      'links'
  ]
}
</script>