import VueRouter from 'vue-router';
const Index = require('./components/Index');
const Code = require('./components/Code');
const Essay = require('./components/Essay');

const Banner = require('./components/Banner');
const TypeBanner = require('./components/TypeBanner');
const ArticleList = require('./components/ArticleList');
const Pagination = require('./components/Pagination');
var router = new VueRouter({
  mode: 'history',
  routes:[
    { path:'/',component:Index,children:[{
      path:'',
      name:'index',
      components:{
        banner:Banner,
        'article-list':ArticleList,
        'pagination':Pagination
      }
    }
    ]},
    { path:'/code',component:Code ,children:[{
      path:'',
      name:'code',
      components:{
        banner:TypeBanner,
        'article-list':ArticleList,
        'pagination':Pagination
      }
    }
    ]},
    { path:'/essay',component:Essay,children:[{
      path:'',
      name:'essay',
      components:{
        banner:TypeBanner,
        'article-list':ArticleList,
        'pagination':Pagination
      }
    }
    ]}
  ]
})
export default router;
