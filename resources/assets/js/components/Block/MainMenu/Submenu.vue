<template>
<ul class="dropdown-menu">
    <li v-for="menu in submenus" :key="menu.label">
        <router-link v-if="isRoute(menu)" :to="{ name: menu.route }">{{ menu.label }}</router-link>
        <a v-else-if="isAction(menu)" @click="menu.action" style="cursor: pointer">{{ menu.label }}</a>
    </li>
</ul>
</template>

<script>
import PermissionManager from '../../../objects/permission_manager'

export default {
    name: 'Submenu',
    props: {
        submenus: {
            type: Array,
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