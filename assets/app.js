import Vue from 'vue';

import router from './router';

import App from './components/App';

Vue.prototype.$config = APP_CONFIG;

new Vue({
    el: '#app',
    router: router,
    components: {
        App
    }
});
