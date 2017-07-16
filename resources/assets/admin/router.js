import VueRouter from 'vue-router';
const dashBoard = require('./components/DashBoard')
const writeArticle = require('./components/WriteArticle')
const Articles = require('./components/Articles')
const Tags = require('./components/Tags')
const Drafts = require('./components/Drafts')
const Comments = require('./components/Comments')

var router = new VueRouter({
  routes:[
    { path:'/',name:'dashboard',component:dashBoard },
    { path:'/write',name:'write',component:writeArticle },
    { path:'/articles',name:'articles',component:Articles },
    { path:'/tags',name:'tags',component:Tags},
    { path:'/drafts',name:'drafts',component:Drafts},
    { path:'/comments',name:'comments',component:Comments}
  ]
})
export default router;
