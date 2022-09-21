<template>
  <v-app>
   
     
    <v-main>
    <div v-if="usuario!=null">
      <principal-page/>
    </div>
 <router-view/>
   
     
    </v-main>
  </v-app>
</template>

<script>
import PrincipalPage from './components/PrincipalPage.vue';
import cookie from "vue-cookie"







export default {
  name: 'App',

  components: {
    PrincipalPage
   
  
  
    
   

   

   
    
  },

  data: () => ({
    

    usuario:null
    
  }),created() {
    
      this.usuario=JSON.parse(cookie.get('usuario'))
      
  },






};
</script>
