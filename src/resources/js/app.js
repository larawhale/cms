require('./listeners');

window.Vue = require('vue');

Vue.component('cms-multi-select', require('./components/form/MultiSelect.vue').default);

const app = new Vue({
    el: '#cms-app',
});
