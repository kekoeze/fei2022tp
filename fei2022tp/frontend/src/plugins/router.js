
import VueRouter from "vue-router";
import AcercaDe from "../components/AcercaDe.vue"

import AbmAulas from "../components/AbmAulas.vue"
import AbmCarreras from "../components/AbmCarreras.vue"
import AbmProfesor from "../components/AbmProfesor.vue"
import AbmMateria from "../components/AbmMateria.vue"
const routes=[
    {path: '/about',name:"AcercaDe",component:AcercaDe},{path: '/abmaula',name:"abmaulas",component:AbmAulas}, {path: '/abmcarrera',name:"AbmCarreras",component:AbmCarreras}
    , {path: '/abmprofesor',name:"AbmProfesor",component:AbmProfesor}, {path: '/abmmateria',name:"AbmMateria",component:AbmMateria}
   
]
const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});
export default router;