<template>
  <div>
    <v-sheet
      tile
      height="54"
      class="d-flex"
    >
      <v-btn
        icon
        class="ma-2"
        @click="$refs.calendar.prev()"
      >
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      <v-select
        v-model="type"
        :items="types"
        dense
        outlined
        hide-details
        class="ma-2"
        label="type"
      ></v-select>
      <v-select
        v-model="mode"
        :items="modes"
        dense
        outlined
        hide-details
        label="event-overlap-mode"
        class="ma-2"
      ></v-select>
      <v-select
        v-model="weekday"
        :items="weekdays"
        dense
        outlined
        hide-details
        label="weekdays"
        class="ma-2"
      ></v-select>
      <v-spacer></v-spacer>
      <v-btn
        icon
        class="ma-2"
        @click="$refs.calendar.next()"
      >
        <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </v-sheet>
    <v-sheet     style="margin-left:15%;margin-top:5%" width="75%" height="auto">
      <v-calendar
        ref="calendar"
        v-model="value"
        :weekdays="weekday"
        :type="type"
        :events="events"
        :event-overlap-mode="mode"
        :event-overlap-threshold="30"
        :event-color="getEventColor"
        
      ></v-calendar>
    </v-sheet>
  </div>
</template>

<script>
  export default {
    data: () => ({
reservaAulaConId:[{
        id:0,
        fh_desde:0,
        fh_hasta:0,
        observacion:"",
        id_aula:0
      }],
   
      aula:[{}],

       materiaConId:[{
        id:0,
        nombre:'',
        cant_alumnos:0,
        id_carrera:[],
        id_profesor:[]
      }],
     
      
     
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
      type: 'month',
      types: ['month', 'week', 'day', '4day'],
      mode: 'stack',
      modes: ['stack', 'column'],
      weekday: [0, 1, 2, 3, 4, 5, 6],
      weekdays: [
        { text: 'lunes - domingo', value: [0, 1, 2, 3, 4, 5, 6] },
        { text: 'lunes - domingo', value: [1, 2, 3, 4, 5, 6, 0] },
        { text: 'lunes - viernes', value: [1, 2, 3, 4, 5] },
        { text: 'lunes, miercoles, viernes', value: [1, 3, 5] },
      ],
      value: '',
      events: [],
      colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
      names: ['Meeting', 'Holiday', 'PTO', 'Travel', 'Event', 'Birthday', 'Conference', 'Party'],
    }),
  
   created() {
    
      this.inicializar().then(() => {
            
            this.crearReservaYHorarios();
          }).then(()=>{
            this.crearCalendario()
          })
  },
 mounted() { 
       
         
        //that.crearCalendario();
  },
    
    methods: {
     async inicializar () {
        
      await this.traerProfesor();
      await this.traerCarrera();
       await this.traerAula();
       await this.traerReservaAula();

      await  this.traerMateria()
        
        
      },
      getEventColor (event) {
        return event.color
      },
     
        rnd (a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
      crearCalendario(){
        var that=this;
          const events=[]
    
         for(const reserva in that.reservaAulaConId){
          const min = new Date(that.reservaAulaConId[reserva].fh_desde)
          const max = new Date(that.reservaAulaConId[reserva].fh_hasta)
          //const days = (max.getTime() - min.getTime()) / 86400000
       //const eventCount = that.rnd(days, days + 20)
       const allDay = that.rnd(0, 3) === 0
        
          

           /*console.log("el minimo es:"+min)
            console.log("el maximo es:"+max)
            console.log("la materia es:"+that.reservaAulaConId[reserva].id_materia);*/
            for(const materia in that.materiaConId){
              if(that.reservaAulaConId[reserva].id_materia==that.materiaConId[materia].id){
           
            
          events.push({
            name: that.materiaConId[materia].nombre,
            start: min,
            end: max,
           color: that.colors[that.rnd(0, that.colors.length - 1)],
            timed: !allDay,
          })}
        }
         }
        that.events = events
      },
       crearReservaYHorarios(){

        
          
          for(const materia in this.materiaConId){
       
           for(const carrera in this.carreras){
                
           
              if(this.materiaConId[materia].id_carrera===this.carreras[carrera].id){
                //console.log("entro aca");
                this.materiaConId[materia].id_carrera=this.carreras[carrera];
                // console.log("la carrera  es:"+this.materiaConId[materia].id_carrera)
              } }
               for(const profesor in this.profesores){

           
              if(this.materiaConId[materia].id_profesor==this.profesores[profesor].id){
                  this.materiaConId[materia].id_profesor=this.profesores[profesor];
               // console.log("el profesor es:"+ this.materiaConId[materia].id_profesor.nombre);
              } }

          }
         
          //termina materia
          for(const reserva in this.reservaAulaConId){
            for(const aula in this.aula){
              if(this.reservaAulaConId[reserva].id_aula==this.aula[aula].id){
                this.reservaAulaConId[reserva].id_aula=this.aula[aula];
               // console.log("el aula es:"+Object.values(this.reservaAulaConId[reserva].id_aula) )
              }
            }
            
          }
      
          
         
      },
      async traerReservaAula(){
      try {
        const response = await this.axios.get('/apiv1/reservaaula') 
        
        this.reservaAulaConId = response.data;
        
        
        
        
    }catch(error) {
        console.log(error);
    }},
  
    async traerAula(){
        try {
        const response = await this.axios.get('/apiv1/aula') 
        
        this.aula = response.data;
        
        
        
    }catch(error) {
        console.log(error);
    }},
   async traerMateria(){
       try {
        const response = await this.axios.get('/apiv1/materia') 
        
        this.materiaConId = response.data;
        
        
        
        
    }catch(error) {
        console.log(error);
    }},
   async traerProfesor(){
        try {
        const response = await this.axios.get('/apiv1/profesor') 
        
        this.profesores = response.data;
        
        
        
    }catch(error) {
        console.log(error);
    }},
    async traerCarrera(){
        try {
        const response = await this.axios.get('/apiv1/carrera') 
        
        this.carreras = response.data;
        
        
        
    }catch(error) {
        console.log(error);
    }},
    }
    
  }
</script>
<style>
.marginCalendario{
  margin-left: 20%;
  float: left;
  
}
</style>