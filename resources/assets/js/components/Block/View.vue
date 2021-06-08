<template>
    <div class="row">
        <div class="col-md-8 box">
            <h1 class="titulo-familia">{{ title }}</h1>
            <h2>{{ subtitle }}</h2>
            <slot></slot>
        </div>
        <div v-if="helper || links" class="col-md-4">
            <div class="box-menor" v-show="helper">
                <h1>
                    <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                    {{ helper.title }}
                </h1>
                <h2>{{ helper.subtitle }}</h2>
                <p>{{ helper.text }}</p>
            </div>
            <div class="list-group" v-show="links">
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
</template>
<script>
export default {
  name: 'BlockView',
  props: {
    title: {
        type: String,
        required: true
    },
    subtitle: {
        type: String,
        required: true
    },
    helper: {
        type: Object,
        default: false
    },
    links: {
        type: Array,
        default: false
    }
  }
}
</script>