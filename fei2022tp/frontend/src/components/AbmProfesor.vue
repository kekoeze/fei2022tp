<template>
  <v-data-table
    :headers="headers"
    :items="profesores"
    sort-by="profesores"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>profesores</v-toolbar-title>
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
              nuevo profesor
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
                      label="nombre"
                    ></v-text-field>
                     <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.apellido"
                      label="apellido"
                    ></v-text-field>
                     <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.mostrar"
                      label="mostrar"
                    ></v-text-field>
                    
                     
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
        <v-alert v-if="cartel"
                max-width="500px"
               style="margin-left:20%"
                color="green"
                elevation="14"
                shaped
                type="tipoCartel"
                
                >{{textoCartel}}</v-alert>
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
      cartel:false,
      tipoCartel:'',
      textoCartel:'',
      headers: [
       
        { text: 'nombre', value: 'nombre' },
        { text: 'apellido', value: 'apellido' },
        { text: 'mostrar', value: 'mostrar' },
         { text: 'Actions', value: 'actions', sortable: false },
      ],
       profesores:[{
            id:0,
            mostrar:null,
            nombre:null,
            apellido:null,
      


        }],
      editedIndex: -1,
      editedItem: {
            id:0,
            mostrar:null,
            nombre:null,
            apellido:null,
     
      },
      defaultItem: {
        
            mostrar:null,
            nombre:null,
            apellido:null,
       
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'nuevo profesor' : 'editar profesor'
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
      this.inicializar()
    },

    methods: {
      inicializar () {
          
             var that = this;
             this.axios.get('/apiv1/profesor').then(function(response) {
               
                that.profesores = response.data;

                 
                

            }).catch(function(error) {
                console.log(error);
            }).then(function() {});
            
      },

      editItem (item) {
        console.log("entro aca");
        this.editedIndex = this.profesores.indexOf(item)
        this.editedItem = Object.assign({}, item)
       
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.profesores.indexOf(item)
        this.editedItem = Object.assign({}, item)
      /*var that=this;
        this.dialogDelete = true*/
          
               
      },

      deleteItemConfirm () {
        this.profesores.splice(this.editedIndex, 1)
        this.closeDelete()
         
        this.axios.delete("/apiv1/profesor/"+this.editedItem.id).then(function(response){
                console.log("eliminado"+response)
                this.cartel=true;
                this.textoCartel="se borro exitosamente"
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
      activarCartel(tipoCartel){
        
        this.cartel=true;
        this.textoCartel="se guardo exitosamente"
        this.tipoCartel=tipoCartel;
      },
      desactivarCartel(){
        this.cartel=false;
        this.textoCartel=""
      },
      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.profesores[this.editedIndex], this.editedItem)
          console.log(this.editedItem.id);
           this.axios.put('/apiv1/profesor/'+this.editedItem.id, {
           nombre:this.editedItem.nombre,
           apellido:this.editedItem.apellido,
           mostrar:this.editedItem.mostrar
          })
          .then(response => {
            console.log(response);
            })
          .catch(error => {
            console.log(error);
           });
        } else {
          this.profesores.push(this.editedItem)
        
          console.log(this.editedItem);
           this.axios.post('/apiv1/profesor',this.editedItem)
                
                
            .catch(function(error){
                console.log(error);
            }).finally(()=>{
              this.activarCartel("success")
             setTimeout(this.desactivarCartel,3000)

                
            })
        }
        this.close()
      },
    },
  }
    


 
 


</script>