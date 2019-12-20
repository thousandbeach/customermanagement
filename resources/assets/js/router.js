import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from "./components/ExampleComponent";
import ExampleComponent2 from "./components/ExampleComponent2";
import ContactsCreate from "./views/ContactsCreate";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', name: 'ExampleComponent', component: ExampleComponent },
        { path: '/2', name: 'ExampleComponent2', component: ExampleComponent2 },
        { path: '/contacts/create', name: 'ContactsCreate', component: ContactsCreate }
    ],
    mode: 'history'
});
