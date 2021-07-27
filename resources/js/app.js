require('./bootstrap');
window.Vue = require("vue");

import App from "./App.vue";
import axios from "axios";
import { routes } from "./routes";
import VueRouter from "vue-router";
import VueAxios from "vue-axios";
Vue.use(VueAxios, axios);
Vue.use(VueRouter);

import { Form, HasError, AlertError } from "vform";
window.Fire = new Vue();

import swal from "sweetalert2";

window.swal = swal;

import VueProgressBar from "vue-progressbar";

Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "3px"
});

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

const router = new VueRouter({
    mode: "history",
    routes: routes
});

const app = new Vue({
    el: "#app",
    router: router,
    render: h => h(App)
});