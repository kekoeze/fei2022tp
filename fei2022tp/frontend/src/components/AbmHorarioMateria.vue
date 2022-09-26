<template>
<v-container fluid grid-list-lg text-lg-left>
  <v-data-table
    :headers="headers"
    :items="horarioMaterias"
    
    sort-by="horarioMaterias"
    class="elevation-1"
  >
  
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>horarioMaterias</v-toolbar-title>
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
              nuevo horario materia
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
                        v-model="editedItem.id_materia"
                        label="Materia"
                        :items="materias"
                        :hint="`${editedItem.id_materia.id}, ${editedItem.id_materia.nombre}`"
                        item-text="nombre"
                        item-value="id"
                        single-line
                      ></v-select>
                      <v-select
                        v-model="editedItem.id_reserva"
                        label="Reserva"
                        :items="reservas"
                        :hint="`${editedItem.id_reserva.id}, ${editedItem.id_reserva.observacion}`"
                        item-text="observacion"
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
          text: 'fecha desde',
          align: 'start',
          sortable: false,
          value:'fh_desde',
        },
        
         { text: 'fecha hasta', value: 'fh_hasta' },
          { text: 'observacion', value: 'observacion' },
          { text: 'materia', value: 'id_materia.nombre' },
          { text: 'reservaAula', value: 'id_reserva.observacion' },
         { text: 'Actions', value: 'actions', sortable: false },
      ],
       reservas:[{
            id:0,
               id_materia:0,
               fh_desde:0,
               fh_hasta:0,
               observacion:null,
            

        }],
        materias:[{
               id:0,
               nombre:'',
               id_carrera:0,
               id_profesor:0,
               cant_alumnos:null
            

        }],
       horarioMaterias:[{
            id:0,
            fh_desde:0,
            fh_hasta:0,
            observacion:null,
            id_materia:[{
                id:0,
                nombre:'',
                id_carrera:0,
                id_profesor:0,
                cant_alumnos:null

            }],
            id_reserva:[{
                id:0,
                id_aula:0,
                fh_desde:0,
                fh_hasta:0,
                observacion:null,

            }],
     
      }],
       horarioMateriaGuardar:
           {
            id:0,
            fh_desde:0,
            fh_hasta:0,
            observacion:null,
            id_materia:0,
            id_reserva:0

           },
       
      editedIndex: -1,
      editedItem: {
            id:0,
            fh_desde:0,
            fh_hasta:0,
            observacion:null,
            id_materia:[{
                id:0,
                nombre:'',
                id_carrera:0,
                id_profesor:0,
                cant_alumnos:null

            }],
            id_reserva:[{
                id:0,
                id_aula:0,
                fh_desde:0,
                fh_hasta:0,
                observacion:null,

            }],
     
      },
      defaultItem: {
           id:0,
            fh_desde:0,
            fh_hasta:0,
            observacion:null,
            id_materia:[{
                id:0,
               nombre:'',
               id_carrera:0,
               id_profesor:0,
               cant_alumnos:null

            }],
            id_reserva:[{
                id:0,
               id_aula:0,
               fh_desde:0,
               fh_hasta:0,
               observacion:null,

            }],
       
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'nuevo horario materia' : 'editar horario materia'
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
      
      
      this.inicializar();
    },

    methods: {
        
      inicializar () {
            this.inicializarReserva();
            this.inicializarMateria();
            
             var that = this;
              that.editedItem.id_materia=that.materias;
                that.editedItem.id_reserva=that.reservas;
             this.axios.get('/apiv1/horariomateria').then(function(response) {
                console.log("las horarioMaterias son: "+response.data);
             that.horarioMaterias=response.data;
               
                for(const horario in that.horarioMaterias){
                    for(const reserva in that.reservas){
                        console.log("hola")
                        console.log("la carrea nombre es:"+that.reservas[reserva].id);
                        if(that.horarioMaterias[horario].id_reserva==that.reservas[reserva].id){
                            console.log("entro aca");
                            that.horarioMaterias[horario].id_reserva=that.reservas[reserva];
                            
                        }

                    }
                    for(const mat in that.materias){
                        console.log("hola")
                        console.log("la carrea nombre es:"+that.materias[mat].id);
                        if(that.horarioMaterias[horario].id_materia==that.materias[mat].id){
                            console.log("entro aca");
                            that.horarioMaterias[horario].id_materia=that.materias[mat];
                            
                        }
                        
                    }

                    

                }
       
               
              
                

            }).catch(function(error) {
                this.cartelError=true;
              this.textoCartel=error;
             
            }).then(function() {});
            
      },
       inicializarReserva () {
          
             var that = this;
             this.axios.get('/apiv1/reservaaula').then(function(response) {
               
                that.reservas = response.data;
                
                

            }).catch(function(error) {
                this.cartelError=true;
              this.textoCartel=error;
            
            }).then(function() {});
            
      },
      inicializarMateria() {
          
             var that = this;
             this.axios.get('/apiv1/materia').then(function(response) {
               
                that.materias = response.data;
                for(const materia in that.materias){
                    console.log("el nombre de las materias es:"+that.materias[materia].nombre)
                }
                

            }).catch(function(error) {
                this.cartelError=true;
              this.textoCartel=error;
            
            }).then(function() {});
            
      },

      editItem (item) {
        console.log("entro aca");
        var that=this;
        this.editedIndex = this.horarioMaterias.indexOf(item)
        this.editedItem = Object.assign({}, item)
        
        that.editedItem.id_materia=that.materias;
        for(const materia in that.editedItem.id_materia){
                    console.log("en el edit:"+that.editedItem.id_materia[materia].nombre)
                }
        that.editedItem.id_reserva=that.reservas;
        console.log("el id de materia es:"+that.editedItem.id_materia[0].id);
        this.dialog = true
      },

      deleteItem (item) {

        this.editedIndex = this.horarioMaterias.indexOf(item)
        this.editedItem = Object.assign({}, item)
      
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.horarioMaterias.splice(this.editedIndex, 1)
        this.closeDelete()
         
        this.axios.delete("/apiv1/horariomateria/"+this.editedItem.id).then(function(response){
                console.log("eliminado"+response)
                alert("registro elimninado")
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
          this.textoCartel="eliminado";
          setTimeout(this.desactivarCartel,3000)
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.horarioMaterias[this.editedIndex], this.editedItem)
          console.log(this.editedItem.id);
           this.axios.put('/apiv1/horariomateria/'+this.editedItem.id, {
           fh_desde:this.editedItem.fh_desde,
           fh_hasta:this.editedItem.fh_hasta,
           observacion:this.editedItem.observacion,
           id_materia:this.editedItem.id_materia.id,
           id_reserva:this.editedItem.id_reserva.id,
          })
          .then(response => {
            console.log(response);
            })
          .catch(error => {
            this.cartelError=true;
              this.textoCartel=error;
              
            console.log(error);
           }).finally(()=>{
            this.cartelInfo=true;
          this.textoCartel="editado";
          setTimeout(this.desactivarCartel,3000)
           });

             
        } else {
          
          this.horarioMaterias.push(this.editedItem)
          this.horarioMateriaGuardar.fh_desde=this.editedItem.fh_desde;
          this.horarioMateriaGuardar.fh_hasta=this.editedItem.fh_hasta;
          this.horarioMateriaGuardar.observacion=this.editedItem.observacion;
          this.horarioMateriaGuardar.id_materia=this.editedItem.id_materia;
          this.horarioMateriaGuardar.id_reserva=this.editedItem.id_reserva;
           this.axios.post('/apiv1/horariomateria',this.horarioMateriaGuardar)
      
                
            .catch(function(error){
                console.log(error);
                this.cartelError=true;
              this.textoCartel=error;
             
            })
            
              
              
        .finally(()=>{
          this.cartelInfo=true;
          this.textoCartel="guardado";
          this.inicializar();
        })
        
        this.close()
      }
    },
  }
  }
</script>