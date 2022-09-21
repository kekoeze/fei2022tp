<template>
  <v-data-table
    :headers="headers"
    :items="aulas"
    sort-by="aulas"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>AULAS</v-toolbar-title>
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
              nueva aula
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
                      v-model="editedItem.cant_pcs"
                      label="cantidad pcs"
                    ></v-text-field>
                     <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.descripccion"
                      label="descripccion"
                    ></v-text-field>
                     <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.cant_proyector"
                      label="cant proyectores"
                    ></v-text-field>
                     <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.descripccion"
                      label="elegir descripcion"
                    ></v-text-field>
                    <v-text-field v-on:keyup.enter="save()"
                      v-model="editedItem.ubicacion"
                      label="elegir ubicacion"
                    ></v-text-field>
                     <v-switch
                      v-model="editedItem.es_climatizado"
                      inset
                      :label="`es climatizado: ${editedItem.es_climatizado.toString()}`"
                      ></v-switch>
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
       
        { text: 'cant proyector', value: 'cant_proyector' },
        { text: 'cantidad de pcs', value: 'cant_pcs' },
        { text: 'descripcion', value: 'descripccion' },
        { text: 'ubicacion', value: 'ubicacion' },
        { text: 'es climatizada', value: 'es_climatizado' },
         { text: 'Actions', value: 'actions', sortable: false },
      ],
       aulas:[{
            id:0,
            cant_pcs:0,
            cant_proyector:0,
            descripccion:null,
            es_climatizado:false,
            ubicacion:null,


        }],
      editedIndex: -1,
      editedItem: {
        id:0,
        cant_pcs:0,
        cant_proyector:0,
        descripccion:null,
        es_climatizado:false,
        ubicacion:null,
     
      },
      defaultItem: {
        cant_pcs:0,
        cant_proyector:0,
        descripccion:null,
        es_climatizado:false,
        ubicacion:null,
       
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'nueva carrera' : 'editar carrera'
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
             this.axios.get('/apiv1/aula').then(function(response) {
               
                that.aulas = response.data;

                 console.log("las aulas son: "+that.aulas[0].descripccion);
                

            }).catch(function(error) {
                console.log(error);
            }).then(function() {});
            
      },

      editItem (item) {
        console.log("entro aca");
        this.editedIndex = this.aulas.indexOf(item)
        this.editedItem = Object.assign({}, item)
       
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.aulas.indexOf(item)
        this.editedItem = Object.assign({}, item)
      
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.aulas.splice(this.editedIndex, 1)
        this.closeDelete()
         
        this.axios.delete("/apiv1/aula/"+this.editedItem.id).then(function(response){
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
          Object.assign(this.aulas[this.editedIndex], this.editedItem)
          console.log(this.editedItem.id);
           this.axios.put('/apiv1/aula/'+this.editedItem.id, {
           cant_pcs:this.editedItem.cant_pcs,
           cant_proyector:this.editedItem.cant_proyector,
           descripccion:this.editedItem.descripccion,
           es_climatizado:this.editedItem.es_climatizado,
            ubicacion:this.editedItem.ubicacion,


          })
          .then(response => {
            console.log(response);
            })
          .catch(error => {
            console.log(error);
           });
        } else {
          this.aulas.push(this.editedItem)
        
          console.log(this.editedItem);
           this.axios.post('/apiv1/aula',this.editedItem)
                
                
            .catch(function(error){
                console.log(error);
            })
        }
        this.close()
      },
    },
  }
    


 
 


</script>