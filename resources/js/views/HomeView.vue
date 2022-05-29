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
import { mapActions, mapState } from 'vuex';

export default {
  components:{
    NavBar
  },
  computed: {
    ...mapState("auth", ["apiKey"]),

  },
  methods: {
    ...mapActions('settings', ['getSettings']),
  },
  watch: {
    apiKey(){
      this.getSettings(this.apiKey)
    }
  }
};
</script>

<style>
  .modal-element {
    z-index: 15;
  }
</style>