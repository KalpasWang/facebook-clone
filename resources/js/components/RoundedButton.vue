<template>
  <div>
    <button class="py-1 px-3 bg-gray-300 hover:bg-gray-500 rounded-full focus:outline-none"
            @click="action"
            >
      {{ btnText }}
    </button>
  </div>
</template>

<script>
export default {
  name: 'RoundedButton',
  props: ['btnText'],
  methods: { 
    action() {
      this.$emit('click')
    } 
  }
}
</script>

<style>

</style>