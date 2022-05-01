<template>
  <div class="wrapper d-flex align-items-stretch">
    <nav-bar />
      <div id="content" class="w-100 px-3 px-sm-4 px-md-5 overflow-auto">
        <router-view />
        </div>
  </div>

</template>

<script>
import NavBar from '../components/NavBar.vue';

export default {
  components:{
    NavBar
  }
};
</script>

<style>
  .modal-element {
    z-index: 15;
  }
</style>