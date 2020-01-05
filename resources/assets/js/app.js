/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./main');
require('./modal');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('x-rating', require('./components/widgets/Rating.vue'));

Vue.component('x-likes', require('./components/Likes.vue'));
// Vue.component('x-comments', require('./components/Comments.vue'));
Vue.component('x-report', require('./components/Report.vue'));

// Disable dev-tools
Vue.config.devtools = false;
Vue.config.debug = false;
Vue.config.silent = true;

const app = new Vue({
    el: '#app'
});



