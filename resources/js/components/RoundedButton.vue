<template>
  <div class="inline-block">
    <button 
      class="py-1 px-3 bg-gray-300 hover:bg-gray-500 rounded-full focus:outline-none"
      @click="action"
      :disabled="isDisabled"
    >
      {{ btnText }}
    </button>
  </div>
</template>

<script>
export default {
  name: 'RoundedButton',
  props: ['btnText', 'isDisabled'],
  methods: { 
    action() {
      this.$emit('event')
    } 
  }
}
</script>

<style>

</style>