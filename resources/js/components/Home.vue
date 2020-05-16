<template>
  <div class="flex flex-1 mt-12">
    <div class="w-3/12 h-screen overflow-y-hidden fixed left-0">
      <Sidebar />
    </div>
    <div class="w-6/12 mx-auto">
      <NewsFeed />
    </div>
    <div class="w-3/12 h-screen overflow-y-hidden fixed right-0">
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