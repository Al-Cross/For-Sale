/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VModal from 'vue-js-modal';
import 'bootstrap/dist/js/bootstrap.bundle';

Vue.use(VModal);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('category-pick', require('./components/CategoryPick.vue').default);
Vue.component('autocomplete', require('./components/Autocomplete.vue').default);
Vue.component('reply', require('./components/Reply.vue').default);
Vue.component('tabs', require('./components/Tabs.vue').default);
Vue.component('tab', require('./components/Tab.vue').default);
Vue.component('notifications', require('./components/Notifications.vue').default);
Vue.component('profile-sections', require('./components/ProfileSections.vue').default);
Vue.component('logo-form', require('./components/LogoForm.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#user',
});
