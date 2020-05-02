<template>
  <div class="flex flex-col items-center pt-4 px-6 h-screen overflow-y-hidden">
    <NewPost />
    <Post />
  </div>
</template>

<script>
import NewPost from "./NewPost";
import Post from "./Post";

export default {
  name: 'NewsFeed',
  components: {
    NewPost, Post
  }
}
</script>

<style>

</style>