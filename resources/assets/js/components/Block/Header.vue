<template>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainMenu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/#/dashboard"><img src="/images/norde.png" class="img-responsive logo" alt="Norde Logo"></a>
            </div>
            <vue-main-menu :links="links" />
            <!--<div class="collapse navbar-collapse" id="mainMenu">
                <ul class="nav navbar-nav mainMenu">
                    <li v-for="menu in menus">
                        <router-link v-if="hasRoute(menu)" 
                         :to="{ name: menu.route }"
                         :data-toggle="hasChild(menu) ? false : 'dropdown'"
                         :class="{'dropdown-toggle': hasChild(menu)}">
                            {{ menu.label }}
                            <span v-show="hasChild(menu)" class="caret"></span>
                        </router-link>
                        <a v-else href="#"
                         :data-toggle="hasChild(menu) ? false : 'dropdown'"
                         :class="{'dropdown-toggle': hasChild(menu)}">
                            {{ menu.label }}
                            <span v-show="hasChild(menu)" class="caret"></span>
                        </a>
                        <ul v-show="hasChild(menu)" class="dropdown-menu">
                            <template v-if="isChildObject(menu.children)">
                                <vue-fragment v-for="(child, index) in getChildren(menu.children)">
                                    <li v-for="childMenu in child">
                                        <router-link :to="{ name: childMenu }">Familia</router-link>
                                    </li>
                                    <hr v-show="haveShowSeparatorLine(child, index)">
                                </vue-fragment>
                            </template>
                            <template v-else>
                                <li v-for="childMenu in child">
                                    <router-link :to="{ name: childMenu }">Familia</router-link>
                                </li>
                            </template>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="/#/">
                            Alunos
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <span>
                            <li><router-link :to="{ name: 'family-list' }">Familia</router-link></li>
                            <li><router-link :to="{ name: 'studant-list' }">Alunos</router-link></li>
                            <hr>
                            <li><router-link :to="{ name: 'family-form' }">Adicionar Familiar</router-link></li>
                            <li><router-link :to="{ name: 'studant-form'}">Adicionar Aluno</router-link></li>
                            <li><a>Importar Aluno</a></li>
                            </span>
                        </ul>
                    </li>
                </ul>
            </div>-->
        </div>
    </nav>
</template>

<script>
import menus from '../../menus.js'
import MainMenu from './MainMenu/index.vue'

export default {
  name: 'Header',
  data() {
      return {
        //   menus: menus,
          links: menus
      }
  },
  methods: {
      
      haveShowSeparatorLine(child, index) {
          if(typeof child === 'undefined') {
              return
          }
          let len = child.length + 1
          return len < index
      }
  },
  components: {
      'vue-main-menu': MainMenu
  }
}
</script>
