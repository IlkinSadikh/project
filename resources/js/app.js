require('./bootstrap');

import Vue from 'vue'
import router from './router'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import main from './main'

Vue.use(ViewUI);

Vue.mixin(main)

Vue.component('app', require('./components/App').default)

const app = new Vue({
    el: '#app',
    router
})
