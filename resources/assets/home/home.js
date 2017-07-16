require('@/app');
require('./scss/home.scss');
import banner from './components/Banner.vue'
import header from './components/Header.vue'
import articleList from './components/ArticleList.vue'
const home = new Vue({
    el: '#app',
    components:{
        'my-banner':banner,
        'my-header':header,
        'article-list':articleList
    }
});
