import '@/app';
require('normalize.css/normalize.css');
import './scss/home.scss';
import Header from './components/Header';
import Footer from './components/Footer';
import TypeBanner from './components/TypeBanner';
import ArticleList from './components/ArticleList';
import Pagination from './components/Pagination';
import router from './router';
const type = new Vue({
    el: '#app',
    router,
    data:{
      searchText:'',
      tags_years:{},
      articles:[],
      page_sum:1
    },
    components:{
      'my-header':Header,
      'my-footer':Footer,
      'type-banner':TypeBanner,
      'article-list':ArticleList,
      'pagination':Pagination
    },
    created(){
      this.$http.get('/getTypeData/'+window.mytype).then(response => {
        this.tags_years = response.body.tags_years;
        this.articles = response.body.articles;
        this.page_sum = response.body.page_sum;
      })
    }
});
