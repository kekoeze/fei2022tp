import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import custom_axios from "@/plugins/axios";
import VueAxios from "vue-axios";
import axios from "axios";
import router from "./plugins/router";
import VueRouter from 'vue-router';
Vue.config.productionTip = false

Vue.use(VueAxios,axios,custom_axios);



Vue.use(VueRouter);
new Vue({
  vuetify,
  router,
  render: h => h(App)
}).$mount('#app')
