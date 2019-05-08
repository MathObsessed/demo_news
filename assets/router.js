import Vue from 'vue';
import Router from 'vue-router';

import AppNewsList from './components/AppNewsList';
import AppNewsForm from './components/AppNewsForm';
import AppNews from './components/AppNews';

Vue.use(Router);

const router = new Router({
    linkActiveClass: 'is-active',
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'news_list',
            component: AppNewsList
        },
        {
            path: '/form',
            name: 'news_form_create',
            props: {
                id: null
            },
            component: AppNewsForm
        },
        {
            path: '/form/:id',
            name: 'news_form_edit',
            props: (route) => {
                const id = Number.parseInt(route.params.id, 10);

                return Number.isNaN(id) ? 0 : { id: id };
            },
            component: AppNewsForm
        },
        {
            path: '/news/:id',
            name: 'news_details',
            props: (route) => {
                const id = Number.parseInt(route.params.id, 10);

                return Number.isNaN(id) ? 0 : { id: id };
            },
            component: AppNews
        }
    ],
    scrollBehavior(to, from, savedPosition){
        return (savedPosition || { x: 0, y: 0 });
    }
});

export default router;
