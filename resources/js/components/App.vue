<template>
  <div>
    <Navbar/>
    <div class="w-full">
      <router-view :key="$route.fullPath"></router-view>
    </div>
  </div>
</template>

<script>
  import Navbar from './Navbar';

  export default {
      name: 'App',
      components: {
        Navbar
      },
      watch: {
        $route(to, from) {
          this.$store.dispatch('fetchPageTitle', to.meta.title);
        }
      },
      created() {
        this.$store.dispatch('fetchPageTitle', this.$route.meta.title);
      },
      mounted() {
        this.$store.dispatch('fetchAuthUser');
      }
  }
</script>