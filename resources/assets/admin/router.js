import VueRouter from 'vue-router';
const dashBoard = require('./components/DashBoard')
const Statistic = require('./components/Statistics')
const writeArticle = require('./components/WriteArticle')
const Articles = require('./components/Articles')
const ArticleDetail = require('./components/ArticleDetail')
const TagDetail = require('./components/TagDetail')
const Tags = require('./components/Tags')
const Drafts = require('./components/Drafts')
const Comments = require('./components/Comments')

var router = new VueRouter({
  routes:[
    { path:'/',name:'dashboard',component:dashBoard },
    { path:'/write',name:'write',component:writeArticle },
    { path:'/articles',name:'articles',component:Articles },
    {
      path:'/articles/:id',
      redirect:'/articles/:id/comment',
      name:'article_detail',
      component:ArticleDetail,
      children:[
        {
          path:'comment',
          name:'article_detail_comment',
          component:Comments
        },
        {
          path:'statistic',
          name:'article_detail_statistic',
          component:Statistic
        }
      ]
    },
    { path:'/tags/:id',name:'tag_detail',component:TagDetail},
    { path:'/articles/:id/edit',name:'article_edit',component:writeArticle},
    { path:'/drafts/:id/edit',name:'draft_edit',component:writeArticle},
    { path:'/tags',name:'tags',component:Tags},
    { path:'/drafts',name:'drafts',component:Drafts},
    { path:'/comments',name:'comments',component:Comments}
  ]
})
export default router;
