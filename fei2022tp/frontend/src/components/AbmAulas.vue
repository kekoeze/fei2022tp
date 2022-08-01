<template>
    <div>
    <h1>Abm aulas</h1>
     <form>
    <v-text-field
      v-model="registro.descripcion"
    
      label="descripcion"
      required
      
    ></v-text-field>
    <v-text-field
      v-model="registro.ubicacion"
     
      label="ubicacion"
      required
     
    ></v-text-field>
     <v-text-field
      v-model="registro.cantProyector"
     
      label="cant proyectores"
      required
     
    ></v-text-field>
     <v-text-field
      v-model="registro.cantPcs"
     
      label="cant pcs"
      required
     
    ></v-text-field>
     <v-text-field
      v-model="registro.aforo"
     
      label="aforo"
      required
     
    ></v-text-field>
     <v-checkbox
          v-model="registro.esClimatizada"
          label="climatizada"
        ></v-checkbox>

   

 
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

import BotoneraAbm from './BotoneraAbm.vue'


export default {
    name:"AbmAulas",
    components:{BotoneraAbm},
    data:()=>({
      registro:{
          id:null,
          descripcion:null,
          ubicacion:null,
          cantProyector:0,
          cantPcs:0,
          aforo:0,
          esClimatizada:false,


      },
      paginacion:{

      
      currentPage:0,
      pageCount:0,
      totalCount:14,
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
          console.log("/apiv1/aula?per-page=1&page="+page);
          this.paginacion.cargando=true;
          var that=this;
          this.axios.get('/apiv1/aula?per-page=1&page=' + page)
          .then(function(response){
              
            if(response.data.length>0){
                
                that.registro.id=response.data[0].id
                that.registro.descripcion=response.data[0].descripccion
                that.registro.ubicacion=response.data[0].ubicacion
                that.registro.cantProyector=response.data[0].cant_proyector
                that.registro.cantPcs=response.data[0].cant_pcs
                that.registro.aforo=response.data[0].aforo
                that.registro.esClimatizada=response.data[0].es_climatizado
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
                'descripccion':this.registro.descripcion,
                'ubicacion':this.registro.ubicacion,
                'cant_proyector':this.registro.cantProyector,
                'cant_pcs':this.registro.cantPcs,
                'aforo':this.registro.aforo,
                'es_climatizado':this.registro.esClimatizada,
            }
            console.log(data);
            var that=this;
            this.axios.post('/apiv1/aula',data).then(function(response){
                that.registro.id=response.data.id
                that.registro.descripcion=response.data.descripccion
                that.registro.ubicacion=response.data.ubicacion
                that.registro.cantProyector=response.data.cant_proyector
                that.registro.cantPcs=response.data.cant_pcs
                that.registro.aforo=response.data.aforo
                that.registro.esClimatizada=response.data.es_climatizado
                
            }).catch(function(error){
                console.log(error);
            }).then(function(){
                alert("registro guardado")
                that.paginacion.cargando=false;
            })

        },
        remove(){
            var that =this;
            this.axios.delete("/apiv1/aula/"+this.registro.id).then(function(response){
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