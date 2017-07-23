import '@/app';
import './scss/article.scss';
import Header from './components/Header';
import Footer from './components/Footer';
const home = new Vue({
    el: '#app',
    mounted(){
      window.$.get('/stat/visit',{'article_id': document.body.getAttribute('data-id') });
    },
    components:{
      'my-header':Header,
      'my-footer':Footer
    }
});
