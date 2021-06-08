<template>
<div class="col-md-10">
    <div class="box">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ title }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 text-center"></div>
            <div v-for="field in fields" :class="field.colmd + ' text-left'">
                <p>{{ field.label }}</p>
            </div>
            <div class="col-md-1 text-center"></div>
            <div class="row">
                <div class="col-md-12">
                    <hr class="hrLista" />
                </div>
            </div>
        </div>
        <div :id="'lista-' + slug">
            <div v-if="typeof items === 'undefined' || items.length < 1">
                <div class="row" style="text-align: center">Sem resultados</div>
            </div>
            <div v-else>
                <template v-if="rowRouter">
                    <router-link 
                        v-for="item in items" 
                        :to="{name: rowRouter, params: {id: item.id}}"
                        class="row"
                        :key="item.id"
                    >
                        <div class="col-md-1 text-center"></div>
                        <div v-for="field in fields" :class="field.colmd">
                            <template v-if="typeof item[field.column] !== 'object'">
                                {{ item[field.column] }}
                            </template>
                            <template v-else>
                                <template v-for="subItem in item[field.column]">
                                    <template v-if="subItem.hasOwnProperty('route')">
                                        <router-link :to="{name: subItem.route, params: {id: item.id}}">
                                            <template v-if="typeof subItem.text !== 'undefined'">
                                                {{ subItem.text }}
                                            </template>
                                            <span 
                                                v-show="typeof subItem.icon !== 'undefined'"
                                                :class="'glyphicon glyphicon-' + subItem.icon"
                                                aria-hidden="true"
                                            >
                                            </span>
                                        </router-link>
                                    </template>
                                    <template v-else-if="subItem.hasOwnProperty('func')">
                                        <a @click.prevent="subItem.func(item.id)">
                                            <template v-if="typeof subItem.text !== 'undefined'">
                                                {{ subItem.text }}
                                            </template>
                                            <span 
                                                v-show="typeof subItem.icon !== 'undefined'"
                                                :class="'glyphicon glyphicon-' + subItem.icon"
                                                aria-hidden="true"
                                            >
                                            </span>
                                        </a>
                                    </template>
                                </template>
                            </template>
                        </div>
                        <div class="col-md-1 text-center"></div>
                    </router-link>
                </template>
                <template v-else>
                    <div class="row" v-for="item in items">
                        <div class="col-md-1 text-center"></div>
                        <div v-for="field in fields" :class="field.colmd">
                            <template v-if="typeof item[field.column] !== 'object'">
                                {{ item[field.column] }}
                            </template>
                            <template v-else>
                                <template v-for="subItem in item[field.column]">
                                    <template v-if="subItem.hasOwnProperty('route')">
                                        <router-link :to="{name: subItem.route, params: {id: item.id}}">
                                            <template v-if="typeof subItem.text !== 'undefined'">
                                                {{ subItem.text }}
                                            </template>
                                            <span 
                                                v-show="typeof subItem.icon !== 'undefined'"
                                                :class="'glyphicon glyphicon-' + subItem.icon"
                                                aria-hidden="true"
                                            >
                                            </span>
                                        </router-link>
                                    </template>
                                    <template v-else-if="subItem.hasOwnProperty('func')">
                                        <a @click.prevent="subItem.func(item.id)">
                                            <template v-if="typeof subItem.text !== 'undefined'">
                                                {{ subItem.text }}
                                            </template>
                                            <span 
                                                v-show="typeof subItem.icon !== 'undefined'"
                                                :class="'glyphicon glyphicon-' + subItem.icon"
                                                aria-hidden="true"
                                            >
                                            </span>
                                        </a>
                                    </template>
                                </template>
                            </template>
                        </div>
                        <div class="col-md-1 text-center"></div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
  name: 'List',
  props: {
      slug: {
          type: String,
          required: true
      },
      title: {
          type: String,
          required: true
      },
      fields: {
          type: Array,
          required: true
      },
      items: {
          type: Array,
          required: true
      }, 
      rowRouter: {
          type: String,
          required: false
      }
  }
}
</script>
