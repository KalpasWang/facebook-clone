<template>
  <div class="bg-transparent pt-4 flex flex-col mx-2">
    <SideItem v-if="authUser" :path="`/users/${authUser.data.user_id}`" :text="authUser.data.attributes.name"/>
  </div>
</template>

<script>
import SideItem from './SideItem';
import { mapGetters } from "vuex";

export default {
  name: 'Sidebar',
  components : {
    SideItem
  },
  computed: {
    ...mapGetters(['authUser'])
  }
}
</script>

<style>

</style>