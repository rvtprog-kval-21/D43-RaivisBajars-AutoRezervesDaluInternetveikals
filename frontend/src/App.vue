<template>
  <div class="cloak">
    <Navigation></Navigation>
    <router-view></router-view>
  </div>
</template>

<script>
import Navigation from './components/Navigation.vue'
export default {
  components: { Navigation }
}
</script>

<style lang="sass" scoped>
  @import url(https://fonts.googleapis.com/css2?family=Roboto)
  html, body
    background-color: #0b0e11
  .cloak
    height: 100vh
    background-color: #0b0e11
    color: white
    font-family: 'Roboto', sans-serif;
</style>
