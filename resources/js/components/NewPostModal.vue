<template>
  <div class="relative w-screen h-screen bg-white opacity-50 z-50">
    <div class="absolute top-auto bottom-auto left-auto right-auto w-16 h-16 rounded bg-white shadow">
      <h2>建立貼文</h2>
      <div class="absolute p-4 right-0">
        <RoundedButton btnText="&times;" @event="$store.commit('setModalState', false)"/>
      </div>
    </div>
    <hr>
    <div class="p-4">
        <Avatar class="block" :username="authUser.data.attributes.name" :path="`/users/${authUser.data.user_id}`"/>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import RoundedButton from './RoundedButton';
import Avatar from './Avatar';

export default {
  name: 'NewPostModal',
  components: { RoundedButton, Avatar},
  computed: {
    ...mapGetters(['authUser']),
  }
}
</script>

<style>

</style>
