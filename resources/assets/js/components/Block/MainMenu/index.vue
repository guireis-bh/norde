<template>
<div id="mainMenu" class="collapse navbar-collapse">
    <ul class="nav navbar-nav mainMenu">
        <li v-for="link in links" :class="{'dropdown': hasChild(link)}" :key="link.id">
            <template v-if="hasChild(link)">
                <router-link
                    v-show="hasPermission(link)"
                    :to="{ name: link.route }"
                    event=""
                    data-toggle="dropdown"
                    :class="{'dropdown-toggle': hasChild(link)}"
                >
                    {{ link.label }}
                    <span class="caret"></span>
                </router-link>
                <vue-submenu-block v-if="isBlock(link.children)" :submenus="getSubmenus(link.children)" />
                <vue-submenu v-else :submenus="getSubmenus(link.children)" />
            </template>
            <template v-else>
                <router-link
                    v-if="isRoute(link)"
                    v-show="hasPermission(link)"
                    :to="{ name: link.route }"
                    data-toggle="dropdown"
                    :class="{'dropdown-toggle': hasChild(link)}"
                >
                    {{ link.label }}
                </router-link>
                <a
                    v-else-if="isAction(link)"
                    v-show="hasPermission(link)"
                    @click="link.action"
                    style="cursor: pointer"
                >
                    {{ link.label }}
                </a>
            </template>
        </li>
    </ul>
</div>
</template>

<script>
import Submenu from './Submenu.vue'
import SubmenuBlock from './SubmenuBlock.vue'
import PermissionManager from '../../../objects/permission_manager'

export default {
    name: 'MainMenu',
    props: {
        links: {
            type: Array,
            required: true
        }
    },
    methods: {
        hasChild(link) {
            return typeof link.children === 'undefined' ? false : true
        },
        isRoute(link) {
            return typeof link.route === 'undefined' ? false : true
        },
        isAction(link) {
            return typeof link.action === 'undefined' ? false : true
        },
        isBlock(item) {
            if(typeof item === 'undefined') {
                return null
            }
            if(item.length < 0) {
                return null
            }
            return item[0].length > 0 ? true : false
        },
        getSubmenus(children) {
            return ['array', 'object'].indexOf(typeof children) > -1 ? children : []
        },
        hasPermission(item) {
            if(typeof item.permission !== 'undefined') {
                return PermissionManager.hasPermission(item.permission)
            }
            return true
        }
    },
    components: {
        'vue-submenu': Submenu,
        'vue-submenu-block': SubmenuBlock
    }
}
</script>