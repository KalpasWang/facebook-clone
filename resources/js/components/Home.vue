<template>
  <div class="flex flex-1">
    <div class="w-3/12">
      <Sidebar />
    </div>
    <div class="w-6/12 overflow-y-hidden">
      <NewsFeed />
    </div>
    <div class="w-3/12">
      messenger
    </div>
  </div>
</template>


<script>
import Sidebar from "./Sidebar";
import NewsFeed from "./NewsFeed";

export default {
  name: 'Start',
  components: {
    Sidebar, NewsFeed
  }
}
</script>