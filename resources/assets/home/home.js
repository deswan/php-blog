import '@/app';
import './scss/home.scss';
import router from './router';
import Header from './components/Header';
import Footer from './components/Footer';
const home = new Vue({
    el: '#app',
    router,
    components:{
      'my-header':Header,
      'my-footer':Footer
    }
});
