//auth route
let login = require('./components/auth/login').default;
let forget = require('./components/auth/forget').default;
let reset = require('./components/auth/reset').default;
let registation = require('./components/auth/registation').default;
let facultyreg = require('./components/auth/facultyreg').default;
let alumnireg = require('./components/auth/alumnireg').default;
let studentreg = require('./components/auth/studentreg').default;
let logout = require('./components/auth/logout').default;
let emailverify = require('./components/auth/resendEmailverificatin').default;
let confirmemail = require('./components/auth/checkEmail').default;

//admin route
let adminauth = require('./components/admin/index').default;
let adminhome = require('./components/admin/home').default;
let category = require('./components/admin/category/Category').default;
let newjob = require('./components/admin/job/add').default;
let alljob = require('./components/admin/job/index').default;
let editjob = require('./components/admin/job/edit').default;
let showjob = require('./components/admin/job/view').default;
let newevent = require('./components/admin/event/add').default;
let allevent = require('./components/admin/event/index').default;
let editevent = require('./components/admin/event/edit').default;
let showevent = require('./components/admin/event/view').default;
let newadmin = require('./components/admin/moreAdmin/add').default;
let alladmin = require('./components/admin/moreAdmin/view').default;


//home route
let index = require('./components/index').default;

export const routes = [
    { path: '/', component: login  , name:'login'},
    { path: '/home', component: index  , name:'home'},
    { path: '/reg', component: registation, name: 'registation' },
    { path: '/faculty/registion', component: facultyreg, name: 'facultyreg' },
    { path: '/student/registion', component: studentreg, name: 'studentreg' },
    { path: '/alumni/registion', component: alumnireg, name: 'alumnireg' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/reset/:token', component: reset, name: 'reset' },
    { path: '/admin/auth', component: adminauth, name: 'adminauth' },
    { path: '/admin/home', component: adminhome, name: 'adminhome' },
    { path: '/admin/category', component: category, name: 'Addcategory' },
    { path: '/email/verify/resend', component: emailverify, name: 'emailverify' },
    { path: '/email/:token', component: confirmemail, name: 'confirmemail' },
    { path: '/admin/job/add', component: newjob, name: 'newjob' },
    { path: '/admin/job/all', component: alljob, name: 'alljob' },
    { path: '/edit/job/:id', component: editjob, name: 'editjob' },
    { path: '/show/job/:id', component: showjob, name: 'showjob' },
    { path: '/admin/event/add', component: newevent, name: 'newevent' },
    { path: '/admin/event/all', component: allevent, name: 'allevent' },
    { path: '/edit/event/:id', component: editevent, name: 'editevent' },
    { path: '/show/event/:id', component: showevent, name: 'showevent' },
    { path: '/admin/add', component: newadmin, name: 'newadmin' },
    { path: '/admin/all', component: alladmin, name: 'alladmin' },
]
