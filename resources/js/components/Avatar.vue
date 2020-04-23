<template>
  <div>
    <router-link :to="path" class="h-full flex justify-center">
      <img src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg" alt="profile image for user" class="w-28px h-28px object-cover rounded-full">
      <span class="ml-1 font-bold">{{ username }}</span>
    </router-link>
  </div>
</template>

<script>
export default {
  props: ['path', 'username']
}
</script>

<style>

</style>