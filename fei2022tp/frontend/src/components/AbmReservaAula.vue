<template>
<v-container fluid grid-list-lg text-lg-left>
  <v-data-table
    :headers="headers"
    :items="reservaAula"
    :key="reservaAula.id"
    sort-by="reservaAula"
    class="elevation-1"
  >
  
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>reservaAula</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="500px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
              
            >
              nueva reserva
            </v-btn>
          </template>
          <v-card  >
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.fh_desde"
                      label="elegir fecha desde "
                      type="datetime-local"
                       
                    ></v-text-field>
                    <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.fh_hasta"
                      label="elegir fecha hasta"
                      type="datetime-local"
                    
                    ></v-text-field>
                      <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.observacion"
                      label="observacion"
                    ></v-text-field>
                   <v-select
                        v-model="editedItem.id_aula"
                        label="Aulas"
                        :items="aula"
                        :hint="`${editedItem.id_aula.id}, ${editedItem.id_aula.descripccion}`"
                        item-text="descripccion"
                        item-value="id"
                        single-line
                      ></v-select>
                      <v-select
                        v-model="editedItem.id_materia"
                        label="Materia"
                        :items="materia"
                        :hint="`${editedItem.id_materia.id}, ${editedItem.id_materia.nombre}`"
                        item-text="nombre"
                        item-value="id"
                        single-line
                      ></v-select>
                  </v-col>
                 
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn 
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn 
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
   <template v-slot:[`item.actions`]="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn
        color="primary"
        @click="inicializar"
      >
        Reset
      </v-btn>
        
    </template>
  </v-data-table>
   <v-alert v-if="cartelInfo"
                max-width="500px"
               style="margin-left:15%"
               
                elevation="14"
                shaped
                
                type=info
                dismissible
                >{{textoCartel}}</v-alert>
                <v-alert v-if="cartelError"
                max-width="500px"
               style="margin-left:15%"
               
                elevation="14"
                shaped
                
                type=error
                dismissible
                >{{textoCartel}}</v-alert>
</v-container>
</template>

<script>
  export default {
    data: () => ({
      dialog: false,
      dialogDelete: false,
       cartelInfo:false,
      cartelError:false,
      textoCartel:'',
      headers: [
        {
          text: 'fecha_desde',
          align: 'start',
          sortable: false,
          value:'fh_desde',
        },
        
         { text: 'fecha hasta', value: 'fh_hasta' },
          { text: 'observacion', value: 'observacion' },
          { text: 'aula', value: 'id_aula.ubicacion' },
          { text: 'materia', value: 'id_materia.nombre' },
         { text: 'Actions', value: 'actions', sortable: false },
      ],
       aula:[{
            id:0,
            cant_pcs:0,
            cant_proyector:0,
            descripccion:null,
            es_climatizado:false,
            ubicacion:null,
            

        }],
        carrera:[{id:0,
                nombre:''
        }],
        profesor:[{
          id:0,
          nombre:'',
          apellido:'',
          mostrar:''

        }],
        
       reservaAula:[],
       materia:[{
         id:0,
         nombre:'',
         cant_aulmnos:0,
         id_carrera:0,
         id_profesor:0
       }],
       reservaGuardar:
           {
               id:0,
               id_aula:0,
               fh_desde:0,
               fh_hasta:0,
               observacion:null,
               id_materia:0,
               


           },
       
      editedIndex: -1,
      editedItem: {
            id:0,
            fh_desde:0,
            fh_hasta:0,
            observacion:null,
            id_aula:[{
            id:0,
            cant_pcs:0,
            cant_proyector:0,
            descripccion:null,
            es_climatizado:false,
            ubicacion:null,
            

        }],
        id_materia:[{
            id:0,
         nombre:'',
         cant_aulmnos:0,
        id_carrera:[{
          id:0,
          nombre:''
        }],
        id_profesor:[{
          id:0,
          nombre:'',
          apellido:'',
          mostrar:''

        }],
            

        }]
     
      },
      defaultItem: {
            id:0,
            fh_desde:0,
            fh_hasta:0,
            observacion:null,
            id_aula:[{
            id:0,
            cant_pcs:0,
            cant_proyector:0,
            descripccion:null,
            es_climatizado:false,
            ubicacion:null,
            id_materia:[{
            id:0,
         nombre:'',
         cant_aulmnos:0,
        id_carrera:[{
          id:0,
          nombre:''
        }],
        id_profesor:[{
          id:0,
          nombre:'',
          apellido:'',
          mostrar:''

        }],
            

        }]
            

        }],
       
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'nueva reserva' : 'editar reserva'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      
      this.inicializar().then(() => {
        this.agregarReservaAula();
      })
    },

    methods: {
        
      async inicializar () {
      await this.inicializarAula();
      await this.inicializarReservaAula();
      await this.inicializarProfesor();
      await this.inicializarMateria();
      await this.inicializarCarrera();
             
          
            
      },
      agregarReservaAula(){
          
         
          for(const mat in this.materia){
              for(const carr in this.carrera){
                  if(this.materia[mat].id_carrera==this.carrera[carr].id){
                 
                      this.materia[mat].id_carrera=this.carrera[carr];
                      //console.log("la materia en la carrera es:"+this.materia[mat].id_carrera);
                      
                  }
                 
              }
            
              for(const prof in this.profesor){
                if(this.profesor[prof].id==this.materia[mat].id_profesor){
                    this.materia[mat].id_profesor=this.profesor[prof];

                }
              }
          }
    
          for(const reserva in this.reservaAula){
            
              for(const mat in this.materia){
                
                  if(this.reservaAula[reserva].id_materia==this.materia[mat].id){
                 
                      this.reservaAula[reserva].id_materia=this.materia[mat];
                    

                  }
                  
              }
              
              for(const aul in this.aula){
      
                if(this.reservaAula[reserva].id_aula==this.aula[aul].id){
                  
                  this.reservaAula[reserva].id_aula=this.aula[aul];
                }

              }
          }
          this.editedItem.id_aula=this.aula;
          this.editedItem.id_materia=this.materia;
          console.log(Object.values(this.editedItem.id_aula))
           console.log(Object.values(this.editedItem.id_materia))
          
      },
    async  inicializarReservaAula () {
          try{
         const response =await this.axios.get('/apiv1/reservaaula')
            this.reservaAula = response.data;
             console.log("la reseerva:"+this.reservaAula[0].id);
             }catch(error) {
                this.cartelError=true;
              this.textoCartel=error;
             }
            
      },
      async inicializarAula () {
          
            try{
         const response =await this.axios.get('/apiv1/aula')
            this.aula = response.data;
             console.log("el aula:"+this.aula[0].descripccion);
             }catch(error) {
                this.cartelError=true;
              this.textoCartel=error;
             }
            
      },
     async inicializarProfesor() {
          
         try{
         const response = await this.axios.get('/apiv1/profesor')
            this.profesor = response.data;
             console.log("el profesor:"+this.profesor[0].nombre);
             }catch(error) {
               this.cartelError=true;
              this.textoCartel=error;
             }
            
      },
     async inicializarMateria () {
          
            try{
            const response = await this.axios.get('/apiv1/materia')
            this.materia = response.data;
             console.log("la materia es:"+this.materia[0].nombre);
             }catch(error) {
                this.cartelError=true;
              this.textoCartel=error;
             }
            
      },
     async inicializarCarrera () {
          
             try{
         const response = await this.axios.get('/apiv1/carrera')
            this.carrera = response.data;
             console.log(this.carrera[0].nombre);
             }catch(error) {
                this.cartelError=true;
              this.textoCartel=error;
             }
            
      },

      editItem (item) {
        console.log("entro aca");
        var that=this;
        this.editedIndex = this.reservaAula.indexOf(item)
        this.editedItem = Object.assign({}, item)
        
        this.editedItem.id_aula=that.aula;
        this.editedItem.id_materia=that.materia;
       
        this.dialog = true
        
      },

      deleteItem (item) {

        this.editedIndex = this.reservaAula.indexOf(item)
        this.editedItem = Object.assign({}, item)
      
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.reservaAula.splice(this.editedIndex, 1)
        this.closeDelete()
         
        this.axios.delete("/apiv1/reservaaula/"+this.editedItem.id).then(function(response){
                console.log("eliminado"+response)
                
            }).catch(function(error){
                this.cartelError=true;
              this.textoCartel=error;

            })
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
           this.cartelInfo=true;
              this.textoCartel="reserva borrada";
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.reservaAula[this.editedIndex], this.editedItem)
          console.log(this.editedItem.id);
           this.axios.put('/apiv1/reservaaula/'+this.editedItem.id, {
           fh_desde:this.editedItem.fh_desde,
           fh_hasta:this.editedItem.fh_hasta,
           observacion:this.editedItem.observacion,
           id_aula:this.editedItem.id_aula,
           id_materia:this.editedItem.id_materia
          }) 
          
          .then(response => {
            console.log(response);
            })
          .catch(error => {
            this.cartelError=true;
              this.textoCartel=error;
           }).finally(()=>{ this.cartelInfo=true;
        this.textoCartel="registro modificado";
        setTimeout(this.desactivarCartel,3000)
        this.inicializar()});
        } else {
            console.log(" en save entro aca")
          this.reservaAula.push(this.editedItem);
        
          this.reservaGuardar.fh_desde=this.editedItem.fh_desde;
          this.reservaGuardar.fh_hasta=this.editedItem.fh_hasta;
          this.reservaGuardar.observacion=this.editedItem.observacion;
          this.reservaGuardar.id_aula=this.editedItem.id_aula;
          this.reservaGuardar.id_materia=this.editedItem.id_materia;
           this.axios.post('/apiv1/reservaaula',this.reservaGuardar)
                
            
            .catch(function(error){
                this.cartelError=true;
              this.textoCartel=error;
            }).finally(()=>{
               this.cartelInfo=true;
              this.textoCartel="reserva aula guardada";
             this.agregarReservaAula();
            })
        }
        this.close()
      },
    },
  }
</script>