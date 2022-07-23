<template>
  <v-card>
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
          
        
            <v-list-item-content v-if="item.id==2"><router-link class="sacarStiloHref" to="/about"><v-list-item-icon >
           <v-icon >{{ item.icon }}</v-icon>
          </v-list-item-icon>
          
            <v-list-item-title style="color:rgba(0, 0, 0, 0.87);">{{item.title}}</v-list-item-title></router-link>
          </v-list-item-content>
          
          
          <div v-if="item.id!=2">
          <v-list-item-icon >
           <v-icon >{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
          </div>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </v-card>
</template>


<script>
import axios from 'axios'
export default {
  name: 'HelloWorld',
  data: () => ({
    drawer: true,
      items: [
          { id:1,title: 'Home', icon: 'mdi-home-city' },
          { id:2,title: 'About', icon: 'mdi-account' },
          { id:3,title: 'Users', icon: 'mdi-account-group-outline' },
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
  
}
.butonStyle{
   
  
 
   margin: 10px;
}
.texto{
height:25px;
width:100px;
text-overflow:ellipsis;
overflow:hidden;
white-space:nowrap;
}
</style>