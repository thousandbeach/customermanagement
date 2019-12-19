import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from "./components/ExampleComponent";
import ExampleComponent2 from "./components/ExampleComponent2";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', name: 'ExampleComponent', component: ExampleComponent },
        { path: '/2', name: 'ExampleComponent2', component: ExampleComponent2 }
    ],
    mode: 'history'
});
