import VueRouter from 'vue-router';
const dashBoard = require('./components/PageDashBoard')
const Statistic = require('./components/Statistics')
const writeArticle = require('./components/PageWriteArticle')
const Articles = require('./components/PageArticles')
const ArticleDetail = require('./components/PageArticleDetail')
const TagDetail = require('./components/PageTagDetail')
const Tags = require('./components/PageTags')
const Drafts = require('./components/PageDrafts')

var router = new VueRouter({
  routes:[
    { path:'/',name:'dashboard',component:dashBoard },
    { path:'/write',name:'write',component:writeArticle },
    { path:'/articles',name:'articles',component:Articles },
    { path:'/articles/:id',name:'article_detail', component:ArticleDetail },
    { path:'/tags/:id',name:'tag_detail',component:TagDetail},
    { path:'/articles/:id/edit',name:'article_edit',component:writeArticle},
    { path:'/drafts/:id/edit',name:'draft_edit',component:writeArticle},
    { path:'/tags',name:'tags',component:Tags},
    { path:'/drafts',name:'drafts',component:Drafts}
  ]
})
export default router;
