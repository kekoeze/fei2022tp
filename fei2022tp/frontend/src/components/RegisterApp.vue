<template>


 

    
  <v-form  v-on:submit.prevent="registrarse">
    <v-container>
      <v-row>
     
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="usuario"
            :rules="nameRules"
            :counter="10"
            label="usuario"
            required
          ></v-text-field>
        </v-col>

       <v-col
          cols="12"
          sm="6"
        >
          <v-text-field
            v-model="password"
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="[rules.required, rules.min]"
            :type="show1 ? 'text' : 'password'"
            name="input-10-1"
            label="contrasenia"
            hint="At least 3 characters"
            counter
            @click:append="show1 = !show1"
          ></v-text-field>
        </v-col>

       

        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            required
          ></v-text-field>
          
        </v-col>  
      </v-row>
      <v-btn
        class="mr-4"
        type="submit"
        :disabled="invalid"
      >
        registrarse
      </v-btn>
    </v-container>
      <v-alert v-if="error==true"
  border="left"
  color="red"
  type="warning"
>{{error_msg}}</v-alert>
  </v-form>

</template>
<script>
   import cockies from 'vue-cookie'
 
  export default {
 
 
    data: () => ({
      usuarios:[],
      usuarioEncuentra:{},
      usuarioCrear:{usuario:'',contrasenia:'',email:'',isAdmin:false},
      error_msg:'',
      error:false,
      usuario: '',
      password: '',
      rules: {
          required: value => !!value || 'Required.',
          min: v => v.length >= 3 || 'Min 3 characters',
          emailMatch: () => (`The email and password you entered don't match`),
        },
      
      show1: false,
      nameRules: [
        v => !!v || 'usuario es requerido',
        
      ],
      email: '',
      emailRules: [
        v => !!v || 'contrasenia es requerida',
        v => /.+@.+/.test(v) || 'contrasenia no es valida',
      ],
       
    }),
    created() {
      this.usuarioEncuentra=JSON.parse(cockies.get('usuario'))
      if(this.usuarioEncuentra!=null){
        this.$router.push('principal');
      }
    },
    methods: {
     registrarse(){
        let json = {
          "usuario" : this.usuario,
          "contrasenia": this.password
        };
        this.axios.get('/apiv1/usuario', json)
        .then( data =>{
          console.log(data)
          
            for(const datos in data.data){

            
           if((data.data[datos].contrasenia === this.password) && (data.data[datos].usuario === this.usuario)){
            
            json.usuario=this.usuario
            json.contrasenia=this.password
            console.log(this.usuario+this.password);
            this.error = true;
              this.error_msg = 'la cuenta ya existe';
             this.$router.push('/');
              
           }
           }
        })
        if(this.error==false){
            console.log("entro aca")
            this.usuarioCrear.usuario=this.usuario;
            this.usuarioCrear.contrasenia=this.password;
            this.usuarioCrear.email=this.email;
            this.usuarioCrear.isAdmin=false;
            this.axios.post("/apiv1/usuario",this.usuarioCrear)
            .catch(function(error){
                console.log(error);
            }).finally(()=>{
                console.log("el usuario es:"+Object.values(this.usuarioCrear))
             this.$router.push('/');
            })
           }
           
    }
  
    },
  }
</script>