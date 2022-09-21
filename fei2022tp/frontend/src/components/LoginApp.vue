<template>
  <v-form  v-on:submit.prevent="login">
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

       

        <!-- <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            required
          ></v-text-field>
          
        </v-col>  -->
      </v-row>
      <v-btn
        class="mr-4"
        type="submit"
        :disabled="invalid"
      >
        submit
      </v-btn>
        <v-btn
        class="mr-4"
        type="button"
        :disabled="invalid"
        
       @click="dirigirRegistro"
      >
        dirigirse a registro
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
      dirigirRegistro(){
        this.$router.push("registrarse")
      },
     login(){
        let json = {
          usuario : this.usuario,
          contrasenia: this.password,
          isAdmin:false
        };
        this.axios.get('/apiv1/usuario', json)
        .then( data =>{
          console.log(data)
           
            for(const datos in data.data){

            
           if((data.data[datos].contrasenia === this.password) && (data.data[datos].usuario === this.usuario)){
            
            json.usuario=this.usuario
            json.contrasenia=this.password
            json.isAdmin=data.data[datos].isAdmin
            console.log(this.usuario+this.password);
            cockies.set("usuario",JSON.stringify(json))
            
             this.$router.push('principal');
           
           }
           }
             this.error = true;
             this.error_msg = 'no se encontro cuenta';
             this.$router.push("registrarse")
           
        })
    }
  
    },
  }
</script>