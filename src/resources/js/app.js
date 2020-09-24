require('./listeners');

window.Vue = require('vue');

Vue.component('cms-multi-select', require('./components/form/MultiSelect.vue').default);
Vue.component('cms-file-input', require('./components/form/FileInput.vue').default);
Vue.component('cms-image-input', require('./components/form/ImageInput.vue').default);

const app = new Vue({
    el: '#cms-app',
});
