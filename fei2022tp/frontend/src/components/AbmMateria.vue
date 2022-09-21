<template>
  <v-data-table
    :headers="headers"
    :items="materias"
    :key="materias.id"
 

    sort-by="materias"
    class="elevation-1"
  >
  
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>materias</v-toolbar-title>
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
              nueva materia
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
                      v-model="editedItem.nombre"
                      label="elegir nombre"
                    ></v-text-field>
                    <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.cant_alumnos"
                      label="cambiar cant alumnos"
                      type="number"
                    ></v-text-field>
                  <v-select
                        v-model="editedItem.id_carrera"
                        label="Carrera"
                        :items="carreras"
                        :hint="`${editedItem.id_carrera.id}, ${editedItem.id_carrera.nombre}`"
                        item-text="nombre"
                        item-value="id"
                        single-line
                        required
                      ></v-select>
                      <v-select
                        v-model="editedItem.id_profesor"
                        label="Profesor"
                        :items="profesores"
                        :hint="`${editedItem.id_profesor.id}, ${editedItem.id_profesor.nombre}`"
                        item-text="nombre"
                        item-value="id"
                        single-line
                        required
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
</template>

<script>
  export default {
    data: () => ({
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'nombre materia',
          align: 'start',
          sortable: false,
          value:'nombre',
        },
        
         { text: 'cantidad de alumnos', value: 'cant_alumnos' },
          { text: 'carreras', value: 'id_carrera.nombre' },
          { text: 'profesores', value: 'id_profesor.nombre' },
         { text: 'Actions', value: 'actions', sortable: false },
      ],
       carreras:[{
            id:0,
            nombre:null,
            

        }],
        profesores:[{
            id:0,
            nombre:null,
            apellido:null,
            mostrar:null
            

        }],
       materias:[],
       materiaGuardar:
           {
               id:0,
               nombre:'',
               id_carrera:0,
               id_profesor:0,
               cant_alumnos:null

           },
       
      editedIndex: -1,
      editedItem: {
            id:0,
            nombre:null,
            id_carrera:[{
                id:0,
                nombre:""
            }],
            id_profesor:[{
            id:0,
            mostrar:null,
            nombre:null,
            apellido:null,
            }],
     
      },
      defaultItem: {
            id:0,
            nombre:null,
            id_carrera:[{
                id:0,
                nombre:""
            }],
            id_profesor:[{
            id:0,
            mostrar:null,
            nombre:null,
            apellido:null,
            }],
       
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'nueva materia' : 'editar materia'
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
               this.inicializarCarrera();
            this.inicializarProfesor();
             var that = this;
            that.editedItem.id_carrera=that.carreras;
            that.editedItem.id_profesor=that.profesores;
             this.axios.get('/apiv1/materia').then(function(response) {
               
                that.materias = response.data;
               
               
                for(const mat in that.materias){
                    for(const carrera in that.carreras){
                    
                        if(that.materias[mat].id_carrera==that.carreras[carrera].id){
                            console.log("entro aca");
                            that.materias[mat].id_carrera=that.carreras[carrera];
                            
                        }

                    }
                    for(const profesor in that.profesores){
                    
                        if(that.materias[mat].id_profesor==that.profesores[profesor].id){
                            console.log("entro aca");
                            that.materias[mat].id_profesor=that.profesores[profesor];
                            
                        }
                        
                    }

                    

                }
        
               
              
                

            }).catch(function(error) {
                
                console.log(error);
            }).then(function() {});
            
      },
       inicializarCarrera () {
          
             var that = this;
             this.axios.get('/apiv1/carrera').then(function(response) {
               
                that.carreras = response.data;
                
                

            }).catch(function(error) {
                console.log(error);
            }).then(function() {});
            
      },
      inicializarProfesor () {
          
             var that = this;
             this.axios.get('/apiv1/profesor').then(function(response) {
               
                that.profesores = response.data;
                for(const profesor in that.profesores){
                    console.log("el nombre del profesor es:"+that.profesores[profesor].nombre)
                }
                

            }).catch(function(error) {
                console.log(error);
            }).then(function() {});
            
      },

      editItem (item) {
        console.log("entro aca");
        var that=this;
        this.editedIndex = this.materias.indexOf(item)
        this.editedItem = Object.assign({}, item)
        
        this.editedItem.id_carrera=that.carreras;
        this.editedItem.id_profesor=that.profesores;
       console.log("la carrera es:"+that.editedItem.id_carrera[0].nombre);
        this.dialog = true
      },

      deleteItem (item) {

        this.editedIndex = this.materias.indexOf(item)
        this.editedItem = Object.assign({}, item)
      
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.materias.splice(this.editedIndex, 1)
        this.closeDelete()
         
        this.axios.delete("/apiv1/materia/"+this.editedItem.id).then(function(response){
                console.log("eliminado"+response)
                alert("registro elimninado")
            }).catch(function(error){
                console.log(error);

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
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.materias[this.editedIndex], this.editedItem)
          console.log(this.editedItem.id);
           this.axios.put('/apiv1/materia/'+this.editedItem.id, {
           nombre:this.editedItem.nombre,
           cant_alumnos:this.editedItem.cant_alumnos,
           id_carrera:this.editedItem.id_carrera.id,
           id_profesor:this.editedItem.id_profesor.id,
          })
          .then(response => {
            console.log(response);
            })
          .catch(error => {
            console.log(error);
           });
        } else {
            console.log(" en save entro aca")
          this.materias.push(this.editedItem)
          
          
            console.log("guardar nueva materia")
          this.materiaGuardar.nombre=this.editedItem.nombre;
          this.materiaGuardar.cant_alumnos=this.editedItem.cant_alumnos;
          this.materiaGuardar.id_profesor=this.editedItem.id_profesor;
          this.materiaGuardar.id_carrera=this.editedItem.id_carrera;
           this.axios.post('/apiv1/materia',this.materiaGuardar)
                
                
            .catch(function(error){
                console.log(error);
            }).finally(()=>{
              console.log("entro aca");
                
              this.inicializar();
            })
           
              
            
        }
        
        this.close()
      },
    },
  }
</script>