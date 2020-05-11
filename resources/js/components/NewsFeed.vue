<template>
  <div>
    <div v-if="error">{{ error }}</div>
    <div v-else class="flex flex-col items-center pt-4 h-screen">
      <NewPost />
      <Post v-for="post in posts.data" :key="post.data.post_id" :post="post"/>
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
      posts: null,
      error: false
    }
  },
  components: {
    NewPost, Post
  },
  mounted() {
    axios.get('/api/posts')
      .then(res => {
        this.posts = res.data;
        this.error = false;
      })
      .catch(error => {
        this.error = error;
      })
  }
}
</script>

<style>

</style>