import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

//admin project pages
import Home from './components/pages/Home'
import Manager from './components/pages/Manager'


const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },

    {
        path: '/manager',
        name: 'manager',
        component: Manager,
    },
]

export default new Router({
    mode: 'history',
    routes
})
