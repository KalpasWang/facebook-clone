<template>
  <div class="fixed table top-0 left-0 z-50 w-full h-full bg-half-white">
    <div class="table-cell align-middle">
      <div class="flex flex-col w-500px h-500px mx-auto bg-white rounded-lg shadow-lg">
        <div class="relative h-16">
          <h2 class="h-full w-full text-2xl font-bold text-center leading-16">建立貼文</h2>
          <div class="absolute p-4 top-0 right-0">
            <RoundedButton :btnText="timesIcon" @event="$store.commit('setModalState', false)"/>
          </div>
        </div>
        <hr>
        <div class="p-4 flex-grow">
          <div class="mb-4">
            <Avatar :username="authUser.data.attributes.name" :path="`/users/${authUser.data.user_id}`"/>
          </div>
          <textarea ref="postMsg" class="block w-full h-full text-lg resize-none outline-none"></textarea>
        </div>
        <div class="w-full p-4 mt-4">
            <RoundedButton class="w-full" btnText="送出" @event="sendPost"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import RoundedButton from './RoundedButton';
import Avatar from './Avatar';

export default {
  name: 'NewPostModal',
  data() {
    return {
      timesIcon: '<i class="fas fa-times fa-2x"></i>'
    }
  },
  components: { RoundedButton, Avatar},
  computed: {
    ...mapGetters(['authUser']),
  },
  methods: {
    sendPost() {
      this.$store.dispatch('createNewPost', this.$refs.postMsg.value);
      this.$store.commit('setModalState', false);
    }
  }
}
</script>

<style scope>
    .bg-half-white {
      background-color: rgba(200, 200, 200, 0.5);
    }
</style>
