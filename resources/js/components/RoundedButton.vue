<template>
  <div class="inline-block">
    <button
      :class="['w-full', 'py-1', 'px-3', 'bg-gray-300', 'rounded-full', 'focus:outline-none',
               { 'hover:bg-gray-500': !isDisabled }, { 'cursor-default': isDisabled }]"
      @click="action"
      :disabled="isDisabled"
      v-html="btnText"
    >
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
