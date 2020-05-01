<template>
  <div class="flex flex-col items-center pt-4 px-6 h-screen overflow-y-hidden">
    <NewPost />
  </div>
</template>

<script>
import NewPost from "./NewPost";

export default {
  name: 'NewsFeed',
  components: {
    NewPost
  }
}
</script>

<style>

</style>