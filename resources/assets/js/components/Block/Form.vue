<template>
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <h1 class="titulo-familia">{{ title }}</h1>
                <h2>{{ subtitle }}</h2>
                <form action="#" @submit.prevent="submit" autocomplete="off">
                    <slot></slot>
                </form>
            </div>
        </div>
        <div v-if="helper" class="col-md-4">
            <div class="box-menor">
                <h1>
                    <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                    {{ helper.title }}
                </h1>
                <h2>{{ helper.subtitle }}</h2>
                <p>{{ helper.text }}</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  name: 'BlockForm',
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
        default: null
    },
    submit: {
        type: Function,
        required: true
    }
  }
}
</script>