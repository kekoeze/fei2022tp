<template>

   
   <v-container>

     <v-navigation-drawer
    v-model="drawer"
      :mini-variant.sync="mini"
      app
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

        <v-list-item-title>{{usuario.usuario}}</v-list-item-title>
      
        

        <v-btn
          icon
          @click.stop="mini = !mini"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>
      <v-list-item class="px-2" >
     
       <a class="sacarEstiloHref" style="display: flex;
  justify-content: end;align-items: center;" v-on:click="deslogearse" >
                <span >
                  <svg style="width:20%;float:right" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </span>
                Logout
              </a> 
     
    </v-list-item>
      <v-divider></v-divider>
  <v-list dense v-if="usuario.isAdmin==false">
        <v-list-item
          v-for="item in itemsNoAdmin"
          :key="item.title"
          link
          
        >
          
        
        <router-link  :to="item.path" class="sacarStiloHref" >
          <v-list-item-content >
       
     
          <v-list-item-icon >
           <v-icon >{{ item.icon }}</v-icon>
          </v-list-item-icon>
         
            <v-list-item-title>{{ item.title }}</v-list-item-title>
        
          </v-list-item-content>  </router-link>
        </v-list-item>
      </v-list>
      <v-list dense v-if="usuario.isAdmin">
        <v-list-item
          v-for="item in itemsAdmin"
          :key="item.title"
          link
          
        >
          
        
        <router-link  :to="item.path" class="sacarStiloHref" >
          <v-list-item-content >
       
     
          <v-list-item-icon >
           <v-icon >{{ item.icon }}</v-icon>
          </v-list-item-icon>
         
            <v-list-item-title>{{ item.title }}</v-list-item-title>
        
          </v-list-item-content>  </router-link>
        </v-list-item>
      </v-list>
        
    </v-navigation-drawer>
   
    </v-container>


</template>


<script>
import axios from 'axios'
import cockies from "vue-cookie";
export default {
  name: 'PrincipalPage',
  data: () => ({
    usuario:{usuario:'',
            contrasenia:'',
            email:'',
            isAdmin:''},
    drawer: true,
      itemsAdmin: [
          { id:1,title: 'Home', icon: 'mdi-home-city',path:'/principal',isADmin:true },
          { id:3,title: 'AbmAula', icon: 'mdi-account-group-outline',path:'/abmaula',isADmin:true },
          { id:4,title: 'AbmCarrera', icon: 'mdi-account-group-outline',path:'/abmcarrera',isADmin:true },
          { id:5,title: 'AbmProfesor', icon: 'mdi-account-group-outline',path:'/abmprofesor',isADmin:true },
          { id:6,title: 'AbmMateria', icon: 'mdi-account-group-outline',path:'/abmmateria',isADmin:true },
          { id:7,title: 'AbmReserva', icon: 'mdi-account-group-outline',path:'/abmreserva',isADmin:true },
          
          
        ],
        itemsNoAdmin:[{ id:2,title: 'CalendarioAula', icon: 'mdi-account',path:'/calendarioaula',isADmin:false }],
    carreras:[],
    mini: true,
    
  }),
 
 mounted () {
    var that = this;
      that.usuario=JSON.parse(cockies.get('usuario'))
      console.log(Object.values(that.usuario));
      console.log(that.usuario.isAdmin);
      
            axios.get("/apiv1/carrera").then(function(response) {
                console.log(response.data);
                that.carreras = response.data;
                
                console.log(that.carreras);

            }).catch(function(error) {
                console.log(error);
            }).then(function() {});
    }
   , methods: {
      isAdmin(){
     
        var that=this;
        that.usuario=JSON.parse(cockies.get('usuario'))
        
        
      },
      deslogearse(){
        var that=this;
        console.log("entro aca")
        cockies.delete('usuario');
         that.$router.push('/');
         location.reload()
       
        
        
      }
    },
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
  
  
}
.texto{

text-overflow:ellipsis;
overflow:hidden;
white-space:nowrap;
}
</style>