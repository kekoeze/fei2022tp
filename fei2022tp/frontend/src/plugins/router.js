
import VueRouter from "vue-router";
import AcercaDe from "../components/AcercaDe.vue"

import AbmAulas from "../components/AbmAulas.vue"
import AbmCarreras from "../components/AbmCarreras.vue"
import AbmProfesor from "../components/AbmProfesor.vue"
import AbmMateria from "../components/AbmMateria.vue"
import AbmReserva from "../components/AbmReservaAula.vue"
import AbmHorario from "../components/AbmHorarioMateria.vue"

import CalendarioAula from "../components/CalendarioAula.vue"
import Login from "../components/LoginApp.vue"
import Registrarse from "../components/RegisterApp.vue"
const routes=[
  {path: '/',name:"login",component:Login},{path: '/registrarse',name:"registro",component:Registrarse},
 {path: '/about',name:"AcercaDe",component:AcercaDe},{path: '/abmaula',name:"abmaulas",component:AbmAulas}, {path: '/abmcarrera',name:"AbmCarreras",component:AbmCarreras}
    , {path: '/abmprofesor',name:"AbmProfesor",component:AbmProfesor}, {path: '/abmmateria',name:"AbmMateria",component:AbmMateria}, {path: '/abmreserva',name:"AbmReserva",component:AbmReserva}
    , {path: '/abmhorario',name:"AbmHorario",component:AbmHorario}, {path: '/calendarioaula',name:"CalendarioAula",component:CalendarioAula}
   
]
const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});
export default router;