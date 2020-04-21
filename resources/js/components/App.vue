<template>
  <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
    <Navbar/>
    start
    <router-view></router-view>
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