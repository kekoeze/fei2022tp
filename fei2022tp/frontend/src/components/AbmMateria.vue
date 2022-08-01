<template>
    <div>
    <h1>Abm materia</h1>
    <form>
     <v-text-field
      v-model="registro.nombre"
    
      label="nombre"
      required
      
    ></v-text-field>
    <v-text-field
      v-model="registro.cantAlumnos"
    
      label="cantidad de alumnos"
      required
      
    ></v-text-field>
     
        <label for="carrera">elegir carrera:</label>
         <select  class="form-control" aria-label="elegir carrera" 
        
        @input="setCarreraId($event.target.value)">
  <option v-for="carrera in carreras"
          :value="carrera.id"
          :key="carrera.id"
          >
    {{carrera.nombre}}
   
  </option>
         </select>
    <label for="profesor">elegir profesor:</label>
         <select aria-label="elegir profesor" 
        
        @input="setProfesorId($event.target.value)">
  <option v-for="profesor in profesores"
          :value="profesor.id"
          :key="profesor.id"
          >
    {{profesor.nombre}}
   
  </option>
         </select>
          
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
        profesores:[],
        carreras:[{
            id:0,
            nombre:null,

        }],
      registro:{
          id:null,
          nombre:null,
          cantAlumnos:0,
          idMateria:0,
         idProfesor:0       


      },
      paginacion:{

      
      currentPage:0,
      pageCount:0,
      totalCount:0,
      cargando:false}
      
    }),
    methods: {
        setProfesorId(id){
            this.registro.idProfesor=parseInt(id);
             console.log(this.registro.idProfesor)
        },
          setCarreraId(categoryId) {
              this.registro.idMateria=parseInt(categoryId);
   

       

  },

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
          console.log("/apiv1/materia?per-page=1&page="+page);
          this.paginacion.cargando=true;
          var that=this;
          this.axios.get('/apiv1/materia?per-page=1&page=' + page)
          .then(function(response){
              
            if(response.data.length>0){
                
                that.registro.id=response.data[0].id
                that.registro.nombre=response.data[0].nombre
                that.registro.cantAlumnos=response.data[0].cant_alumnos
                that.registro.idProfesor=response.data[0].id_profesor
                that.registro.idMateria=response.data[0].id_materia
               
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
                'cant_alumnos':this.registro.cantAlumnos,
                'id_materia':this.registro.idMateria,
                'id_profesor':this.registro.idProfesor,
                
            }
            console.log(data);
            var that=this;
            this.axios.post('/apiv1/materia',data).then(function(response){
                that.registro.id=response.data.id
                that.registro.nombre=response.data.nombre
                that.registro.cantAlumnos=response.data.cant_alumnos
                that.registro.idMateria=response.data.id_materia
                 that.registro.idProfesor=response.data.id_profesor
                
            }).catch(function(error){
                console.log(error);
            }).then(function(){
                alert("registro guardado")
                that.paginacion.cargando=false;
            })

        },
        remove(){
            var that =this;
            this.axios.delete("/apiv1/materia/"+this.registro.id).then(function(response){
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
            var that = this;
             this.axios.get('/apiv1/carrera').then(function(response) {
                console.log("las carreras son: "+response.data);
                that.carreras = response.data;
                
                console.log(that.carreras);

            }).catch(function(error) {
                console.log(error);
            }).then(function() {});
            this.axios.get('/apiv1/profesor').then(function(response) {
                console.log("los profesores son: "+response.data);
                that.profesores = response.data;
                
                console.log(that.profesores);

            }).catch(function(error) {
                console.log(error);
            }).then(function() {});
            this.loadData(1);
            
        },
    


 
 
}
</script>
<style>

select{
    width: 200px;
    border: black solid 1px;
    margin: 1%;
   

}
</style>
