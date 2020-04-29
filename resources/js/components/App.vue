<template>
  <div>
    <Navbar/>
    <div class="w-full">
      <router-view></router-view>
    </div>
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