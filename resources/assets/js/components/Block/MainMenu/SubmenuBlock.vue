<template>
<ul class="dropdown-menu">
    <template v-for="menu in submenus" >
        <li v-for="menuLink in menu" :key="menuLink.label">
            <router-link v-if="isRoute(menuLink)" :to="{ name: menuLink.route }">{{ menuLink.label }}</router-link>
            <a v-else-if="isAction(menuLink)" @click="menuLink.action" style="cursor: pointer">{{ menuLink.label }}</a>
        </li>
        <!--<hr v-show="showSeparatorLine(child, index)">-->
    </template>
</ul>
</template>

<script>
// import Fragment from 'vue-fragment'
import PermissionManager from '../../../objects/permission_manager'

export default {
    name: 'SubmenuBlock',
    props: {
        submenus: {
            type: [Array, Object],
            required: true
        }
    },
    methods: {
        hasPermission(item) {
            if(typeof item.permission !== 'undefined') {
                return PermissionManager.hasPermission(item.permission)
            }
            return true
        },
        isRoute(link) {
            return typeof link.route === 'undefined' ? false : true
        },
        isAction(link) {
            return typeof link.action === 'undefined' ? false : true
        }
    }
}
</script>