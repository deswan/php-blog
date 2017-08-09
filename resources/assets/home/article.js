import '@/app';
import './scss/article.scss';
import Header from './components/Header';
import Footer from './components/Footer';
const home = new Vue({
    el: '#app',
    mounted(){
      var type = document.body.getAttribute('data-type'),type_logo_url;
      type == 'essay' ? (type_logo_url = require('img/essay.png')) : (type_logo_url = require('img/code.png'))
      document.getElementsByClassName('article-type-logo')[0].src = type_logo_url;
      window.$.get('/stat/visit',{'article_id': document.body.getAttribute('data-id') });
    },
    components:{
      'my-header':Header,
      'my-footer':Footer
    }
});
