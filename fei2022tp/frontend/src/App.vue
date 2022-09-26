<template>
  <v-app>
   
      <div v-show="mostrar" >
      <principal-page/>
    </div>
    <v-main>
   
 <router-view/>
   
     
    </v-main>
  </v-app>
</template>

<script>
import PrincipalPage from './components/PrincipalPage.vue';
import cookie from "vue-cookie"
import AbmCarrerasVue from './components/AbmCarreras.vue';
import AbmAulasVue from './components/AbmAulas.vue';
import AbmProfesorVue from './components/AbmProfesor.vue';
import AbmMateriaVue from './components/AbmMateria.vue';
import AbmHorarioMateriaVue from './components/AbmHorarioMateria.vue';
import CalendarioAulaVue from './components/CalendarioAula.vue';
import AbmReservaAulaVue from './components/AbmReservaAula.vue';







export default {
  name: 'App',

  components: {
    PrincipalPage
   
  
  
    
   

   

   
    
  },

  data: () => ({
    
    mostrar:false,
    usuario:null
    
  }),created() {
    
  
      

    
      this.usuario=JSON.parse(cookie.get('usuario'))
     
      if(this.usuario!=null){
       this.mostrar=true;
        if(this.usuario.isAdmin==true){

      
        this.$router.addRoute({path: '/abmaula',name:"abmaulas",component:AbmAulasVue})
        this.$router.addRoute({path: '/abmcarrera',name:"AbmCarreras",component:AbmCarrerasVue})
        this.$router.addRoute({path: '/abmprofesor',name:"AbmProfesor",component:AbmProfesorVue})
        this.$router.addRoute({path: '/abmmateria',name:"AbmMateria",component:AbmMateriaVue})
        this.$router.addRoute({path: '/abmreserva',name:"AbmReserva",component:AbmReservaAulaVue})
        this.$router.addRoute({path: '/abmhorario',name:"AbmHorario",component:AbmHorarioMateriaVue})
          }
          else{
          this.$router.addRoute({path: '/calendarioaula',name:"CalendarioAula",component:CalendarioAulaVue});
          }
      }
      else{
       
        this.mostrar=false;
        
       
      }
    
      
  
  }






};
</script>
