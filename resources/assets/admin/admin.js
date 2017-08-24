import '@/app'
import 'bootstrap-sass' //bootstrapjs
import './scss/index.scss'
import router from './router'
Vue.component('pop-model',require('./components/Model'));
Vue.http.options.root = '/admin65790';
const index = new Vue({
    el: '#app',
    router,
    data(){
      return {
        logo_src:require('img/star.png')
      }
    }
});
