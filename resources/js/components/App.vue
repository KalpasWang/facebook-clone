<template>
  <div v-if="authUser">
    <Navbar/>
    <div class="w-full">
      <router-view :key="$route.fullPath"></router-view>
    </div>
    <NewPostModal :class="{'hidden': !isModalOpen}"/>
  </div>
</template>

<script>
  import Navbar from './Navbar';
  import NewPostModal from "./NewPostModal";
  import { mapGetters } from 'vuex';

  export default {
      name: 'App',
      components: {
        Navbar, NewPostModal
      },
      computed: mapGetters(['authUser', 'isModalOpen']),
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
