<template>
  <div>
    <div class="flex flex-col items-center pt-4 h-screen">
      <NewPost />
      <div v-if="loading">
        Loading...
      </div>
      <div v-else-if="errorMsg" class="text-lg mt-10 text-center">{{ errorMsg }}</div>
      <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"/>
    </div>
  </div>
</template>

<script>
import NewPost from "./NewPost";
import Post from "./Post";

export default {
  name: 'NewsFeed',
  data() {
    return {
      posts: { data: null },
      loading: true,
      errorMsg: ''
    }
  },
  components: {
    NewPost, Post
  },
  mounted() {
    axios.get('/api/posts')
      .then(res => {
        this.posts = res.data;
      })
      .catch(error => {
        console.log(error);
        this.errorMsg = error;
      })
      .finally(() => {
        this.loading = false;
      })
  }
}
</script>

<style>

</style>