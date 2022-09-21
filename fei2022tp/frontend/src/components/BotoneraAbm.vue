<template>
    <div>        
        <v-btn
        elevation="2"
        @click="$emit('first')"
        ><v-icon>mdi-chevron-double-left</v-icon></v-btn>
        <v-btn
        elevation="2"
        @click="$emit('prev')"
        ><v-icon>mdi-chevron-left</v-icon></v-btn>
        <v-btn
        elevation="2"
        @click="$emit('next')"
        ><v-icon>mdi-chevron-right</v-icon></v-btn>
        <v-btn
        elevation="2"
        @click="$emit('last')"
        ><v-icon>mdi-chevron-double-right</v-icon></v-btn>
        <v-btn
        elevation="2"
         @click="$emit('save')"
        >
            <v-icon dark>
            mdi-content-save
            </v-icon>
      </v-btn>
      <v-btn
        elevation="2"
        @click="$emit('remove')"
      >
        <v-icon dark>
          mdi-delete
        </v-icon>
      </v-btn>
      
    </div>
</template>

<script>
export default {
    name: 'BotoneraAbm',
    
}
</script>
