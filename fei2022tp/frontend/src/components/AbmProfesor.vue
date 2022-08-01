<template>
    <div>
    <h1>Abm Profesor</h1>
    <form>
     <v-text-field
      v-model="registro.nombre"
    
      label="nombre"
      required
      
    ></v-text-field>
    <v-text-field
      v-model="registro.apellido"
    
      label="apellido"
      required
      
    ></v-text-field>
    <v-text-field
      v-model="registro.mostrar"
    
      label="mostrar"
      required
      
    ></v-text-field>
  </form>
    <botonera-abm
    @first="first()"
    @prev="prev()"
    @next="next()"
    @last="last()"
    @save="save()"
    @remove="remove()"
    />
  
    </div>
    
</template>

<script>

import BotoneraAbm from "../components/BotoneraAbm.vue"

export default {
  name:"AbmCarreras",
  components:{BotoneraAbm},
    data:()=>({
      registro:{
          id:null,
          nombre:null,
          apellido:null,
          mostrar:null,
       


      },
      paginacion:{

      
      currentPage:0,
      pageCount:0,
      totalCount:0,
      cargando:false}
      
    }),
    methods: {
        first(){
            this.loadData(1)
        },
        next(){
            this.loadData(parseInt(this.paginacion.currentPage)+1)
            console.log("entro en next: "+this.paginacion.currentPage);
        },
        prev(){
            this.loadData(parseInt(this.paginacion.currentPage)-1)
        },
         last(){
             console.log("final de pagina:"+this.paginacion.totalCount);
            this.loadData(parseInt(this.paginacion.totalCount))
            
        },
        loadData(page){
          console.log("la pagina es:"+page);
          console.log("/apiv1/profesor?per-page=1&page="+page);
          this.paginacion.cargando=true;
          var that=this;
          this.axios.get('/apiv1/profesor?per-page=1&page=' + page)
          .then(function(response){
              
            if(response.data.length>0){
                
                that.registro.id=response.data[0].id
                that.registro.nombre=response.data[0].nombre
                that.registro.apellido=response.data[0].apellido
                that.registro.mostrar=response.data[0].mostrar
               that.paginacion.currentPage=response.headers["x-pagination-current-page"];
               that.paginacion.pageCount=response.headers["x-pagination-page-count"];
               that.paginacion.totalCount=response.headers["x-pagination-total-count"];
               
               
                
            }
          }).catch(function(error){
            console.log(error)
          }).then(function(){
            that.paginacion.cargando=false;
          })

        },
        save(){
            const data={
                'nombre':this.registro.nombre,
                'apellido':this.registro.apellido,
                'mostrar':this.registro.mostrar,
                
            }
            console.log(data);
            var that=this;
            this.axios.post('/apiv1/profesor',data).then(function(response){
                that.registro.id=response.data.id
                that.registro.nombre=response.data.nombre
                that.registro.apellido=response.data.apellido
                that.registro.mostrar=response.data.mostrar
                
            }).catch(function(error){
                console.log(error);
            }).then(function(){
                alert("registro guardado")
                that.paginacion.cargando=false;
            })

        },
        remove(){
            var that =this;
            this.axios.delete("/apiv1/profesor/"+this.registro.id).then(function(response){
                console.log("eliminado"+response)
                alert("registro elimninado")
            }).catch(function(error){
                console.log(error);

            }).then(function(){
                that
                .cargando=false;
                that.loadData(parseInt(this.paginacion.currentPage));

            })

        },
        },
        mounted() {
            this.loadData(1);
        },
    


 
 
}
</script>
