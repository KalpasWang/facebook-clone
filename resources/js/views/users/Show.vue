<template>
  <div class="flex flex-col items-center">
    <div v-if="userLoading">Loading User Profile...</div>
    <div v-else-if="userErrorMsg">{{ userErrorMsg }}</div>
    <div v-else class="relative">
      <div class="w-100 h-64 overflow-hidden z-0">
        <img src="https://cdn.pixabay.com/photo/2017/03/26/12/13/countryside-2175353_960_720.jpg" alt="user background image" class="object-cover w-full">
      </div>

      <div class="absolute left-0 right-0 top-7/10 z-10" style="top: 70%">
        <div class="mx-auto w-32">
          <img src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg" alt="user profile image" class="object-cover w-32 h-32 border-4 border-white rounded-full">
        </div>

        <p class="text-2xl text-center">{{ user.data.attributes.name }}</p>
      </div>

      <div v-if="friendBtnText" class="absolute bottom-0 right-0 mb-4 mr-12 z-10">
        <RoundedButton :isDisabled="isDisabled" :btnText="friendBtnText" @event="sendRequest" />
      </div>
    </div>

    <div class="mt-32">
      <div v-if="postsLoading">Loading Your Posts</div>
      <div v-else-if="postsErrorMsg">{{ postsErrorMsg }}</div>
      <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"/>
    </div>
  </div>
</template>

<script>
import Post from "../../components/Post";
import RoundedButton from "../../components/RoundedButton"
import { mapGetters } from "vuex";

export default {
  name: 'Show',
  data() {
    return {
      // user: null,
      posts: null,
      userLoading: true,
      postsLoading: true,
      userErrorMsg: null,
      postsErrorMsg: null,
    }
  },
  components: {
    Post, RoundedButton
  },
  computed: {
    isDisabled() {
      if(this.friendBtnText === 'Pending') return true;
      return false;
    },
    ...mapGetters(['user', 'friendBtnText', 'friendship'])
  },
  methods: {
    sendRequest() {
      this.$store.dispatch('sendFriendRequest', this.$route.params.userId);
    }
  },
  mounted() {
     this.$store.dispatch('fetchUser', this.$route.params.userId)
      .then(() => {
        this.userLoading = false;
      });

    axios.get('/api/users/' + this.$route.params.userId + '/posts')
      .then(res => {
        this.posts = res.data;
        this.postsLoading = false;
      })
      .catch(error => {
        this.postsErrorMsg = 'Unable to fetch posts';
        this.postsLoading = false;
      });
  },
}
</script>

<style>

</style>