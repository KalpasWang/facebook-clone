<template>
  <div>
    <div class="flex flex-col items-center pt-4 h-screen">
      <NewPost />
      <div v-if="newPostsStatus === 'Loading'">
        Loading...
      </div>
      <div v-else-if="newPostsStatus === 'Error'" class="text-lg mt-10 text-center">{{ errorMsg }}</div>
      <Post v-else v-for="(post, idx) in newPosts.data" :key="idx" :post="post"/>
    </div>
  </div>
</template>

<script>
import NewPost from "./NewPost";
import Post from "./Post";
import { mapGetters } from "vuex";

export default {
  name: 'NewsFeed',
  components: {
    NewPost, Post
  },
  computed: {
    ...mapGetters(['newPosts','newPostsStatus', 'errorMsg'])
  },
  mounted() {
    this.$store.dispatch('fetchNewsFeed');
  }
}
</script>

<style>

</style>
