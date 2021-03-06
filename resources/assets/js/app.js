
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
/**
 * Imports
 */
import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

window.Vue = Vue
new Vue({
    store,
    router,
    el: '#app',
    render: h => h(App)
})