//auth route
let login = require('./components/auth/login').default;
let forget = require('./components/auth/forget').default;
let reset = require('./components/auth/reset').default;
let registation = require('./components/auth/registation').default;
let facultyreg = require('./components/auth/facultyreg').default;
let alumnireg = require('./components/auth/alumnireg').default;
let logout = require('./components/auth/logout').default;

//home route
let index = require('./components/index').default;
export const routes = [
    { path: '/', component: login  , name:'login'},
    { path: '/home', component: index  , name:'home'},
    { path: '/reg', component: registation, name: 'registation' },
    { path: '/faculty/registion', component: facultyreg, name: 'facultyreg' },
    { path: '/alumni/registion', component: alumnireg, name: 'alumnireg' },
    { path: '/logout', component: logout, name: 'logout' },
    { path: '/forget', component: forget, name: 'forget' },
    { path: '/reset/:token', component: reset, name: 'reset' },
]
