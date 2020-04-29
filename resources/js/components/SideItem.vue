<template>
  <div class="h-8 w-full p-2 flex items-center hover:bg-gray-300 rounded-lg">
    <router-link :to="path">
      <img src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg" alt="user image" class="w-28px h-28px object-cover rounded-full inline-block align-middle">
      <span class="ml-1 align-middle">{{ text }}</span>
    </router-link>
  </div>
</template>

<script>
export default {
  props: ['path', 'text']
}
</script>

<style>

</style>