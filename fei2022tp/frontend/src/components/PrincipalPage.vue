<template>
   <div>
  <v-card  class="float-left">

    <v-navigation-drawer
      v-model="drawer"
      :mini-variant.sync="mini"
      permanent
    >
    <v-list-item class="d-flex justify-end mb-6"
      :color="$vuetify.theme.dark ? 'grey darken-3' : 'grey lighten-4'"
      flat
      tile>
     
      <v-list-item-title>Programador</v-list-item-title>
    <v-icon style="" >mdi-backspace-reverse</v-icon>
    </v-list-item>
      <v-list-item class="px-2">
        <v-list-item-avatar   size=40px>
          <v-img  src="../assets/keko.png"></v-img>
        </v-list-item-avatar>

        <v-list-item-title>Ezequiel Villablanca</v-list-item-title>
      
        

        <v-btn
          icon
          @click.stop="mini = !mini"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>
      <v-list-item class="px-2">

    </v-list-item>
      <v-divider></v-divider>

      <v-list dense>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
        >
          
        
        <router-link :to="item.path" class="sacarStiloHref" >
          <v-list-item-content >
       
     
          <v-list-item-icon >
           <v-icon >{{ item.icon }}</v-icon>
          </v-list-item-icon>
         
            <v-list-item-title>{{ item.title }}</v-list-item-title>
        
          </v-list-item-content>  </router-link>
        </v-list-item>
      </v-list>
        
    </v-navigation-drawer>
   
  </v-card>
 
  </div>
</template>


<script>
import axios from 'axios'
export default {
  name: 'PrincipalPage',
  data: () => ({
    drawer: true,
      items: [
          { id:1,title: 'Home', icon: 'mdi-home-city',path:'/' },
          { id:2,title: 'About', icon: 'mdi-account',path:'/about' },
          { id:3,title: 'AbmAula', icon: 'mdi-account-group-outline',path:'/abmaula' },
          { id:4,title: 'AbmCarrera', icon: 'mdi-account-group-outline',path:'/abmcarrera' },
          { id:5,title: 'AbmProfesor', icon: 'mdi-account-group-outline',path:'/abmprofesor' },
          { id:6,title: 'AbmMateria', icon: 'mdi-account-group-outline',path:'/abmmateria' }
        ],
    carreras:[],
    mini: true,
    
  }),
 mounted () {
    var that = this;




          
            axios.get("/apiv1/carrera").then(function(response) {
                console.log(response.data);
                that.carreras = response.data;
                
                console.log(that.carreras);

            }).catch(function(error) {
                console.log(error);
            }).then(function() {});
    }
  }

</script>
<style scoped>
.sacarStiloHref{

  text-decoration:none;
  color:rgb(22, 18, 18)
}
.butonStyle{
   
  
 
   margin: 10px;
}
.achicar{
  width: 50%;
  height: auto;
  
}
.texto{
height:25px;
width:100px;
text-overflow:ellipsis;
overflow:hidden;
white-space:nowrap;
}
</style>