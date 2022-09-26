
import VueRouter from "vue-router";
import AcercaDe from "../components/AcercaDe.vue"

import Login from "../components/LoginApp.vue"
import Registrarse from "../components/RegisterApp.vue"
const routes=[
  {path: '/',name:"login",component:Login},{path: '/registrarse',name:"registro",component:Registrarse},
  
 {path: '/about',name:"AcercaDe",component:AcercaDe,
 children: []}
   
]
const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});
export default router;