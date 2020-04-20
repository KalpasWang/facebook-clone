<template>
  <div>
    <v-app>
      <Navbar/>
      start
      <router-view></router-view>
    </v-app>
  </div>
</template>

<script>
  import Navbar from './Navbar';

  export default {
      name: 'App',
      components: {
        Navbar
      }
  }
</script>