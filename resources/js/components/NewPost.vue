<template>
  <div class="bg-white rounded shadow w-full max-w-md h-16 my-2">
    <div class="flex justify-between items-center px-4 h-full">
      <img src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg" alt="user image" class="w-10 h-10 object-cover rounded-full inline-block align-middle mr-2">
      <div class="rounded-full px-2 leading-8 w-full h-8 cursor-pointer bg-gray-200 hover:bg-gray-300 text-sm text-left" @click="openModal">
          {{ authUser.data.attributes.name }}，在想些什麼？
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: 'NewPost',
  computed: {
    ...mapGetters(['authUser']),
  },
  methods: {
      openModal() {
          this.$store.commit('setModalState', true);
      }
  }
}
</script>

<style>

</style>
