
import VueRouter from "vue-router";
import AcercaDe from "../components/AcercaDe.vue"
import HelloWorld from "../components/HelloWorld.vue"

const routes=[
    {path: '/about',name:"AcercaDe",component:AcercaDe},{path: '/',name:"HelloWorld",component:HelloWorld}
]
const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});
export default router;