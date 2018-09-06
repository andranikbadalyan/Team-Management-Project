import Vue from 'vue';
import VueRouter from 'vue-router'

Vue.use(VueRouter);



import Dashboard from './../components/Dashboard'
import oAuth from './../components/oAuth'
import Teams from './../components/Teams'
import Players from './../components/Players'
import Users from './../components/Users'


const routes = [
    {
        path: '/admin',
        name: 'Dashboard',
        component: Dashboard,
    },
    {
        path: '/admin/oauth',
        name: 'oAuth',
        component: oAuth,
    },
    {
        path: '/admin/teams',
        name: 'Teams',
        component: Teams,
    },
    {
        path: '/admin/teams/:team/players',
        name: 'Players',
        component: Players,
    },
    {
        path: '/admin/users',
        name: 'Users',
        component: Users,
    },
];



export const router = new VueRouter({
    mode: 'history',
    routes
});

