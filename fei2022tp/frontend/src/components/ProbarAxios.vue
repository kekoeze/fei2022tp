<template >
<section>
 

 
          <p v-for="carrera in carreras"
          :key="carrera.id">{{carrera.nombre}}</p>
           
      
</section>
</template>




<script>
import axios from 'axios'
  export default {
     data: () => ({
    carreras:[]
   
  }),
  mounted () {
    var that = this;




          
            axios.get("/apiv1/carrera").then(function(response) {
                console.log(response.data);
                that.carreras = response.data;
                
                console.log(that.carreras);

            }).catch(function(error) {
                console.log(error);
            }).then(function() {});
    }
  }
</script>
<style>


.colorCarta{
    background-color: grey;
    
   
    
}
.contenedor{
 width: 100%;
 height: auto;
	max-width: 1200px;
	margin: auto;
	padding: 40px ;

   
    
}
.centrarimagen{
    
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
	min-height: 200px;
	font-weight: bold;
	padding: 20px;
	position: relative;
	overflow: hidden;
	background-size: cover;
	background-position: center center;
    width: 100%;
}
</style>