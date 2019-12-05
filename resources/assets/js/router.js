import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from "./components/ExampleComponent";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', name: 'ExampleComponent', component: ExampleComponent }
    ],
    mode: 'history'
});
