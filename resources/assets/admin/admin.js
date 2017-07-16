import '@/app'

//dependencies
import 'bootstrap-sass';

import './scss/index.scss'
import router from './router'

const index = new Vue({
    el: '#app',
    router,
    data(){
      return {
        logo_src:require('img/star.png')
      }
    }
});