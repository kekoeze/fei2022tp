<template>
  <v-app>
   
     
    <v-main>
       <principal-page/>
 <router-view/>
   
     
    </v-main>
  </v-app>
</template>

<script>


import PrincipalPage from './components/PrincipalPage.vue';


export default {
  name: 'App',

  components: {
    PrincipalPage,
   
    
   
    
  },

  data: () => ({
    //
  }),
};
</script>
