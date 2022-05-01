<template>
  
</template>
<script>
import { onMounted } from '@vue/runtime-core'
import { mapState } from 'vuex'
export default {
  props: {
    lastView: {
      type: String,
      default: 'home'
    }
  },
  computed: {
      ...mapState('auth',['logged', 'apiKey']),
  },
  async created(){
    if(!this.logged) this.$router.push({name: 'login', params:{ lastView: this.lastView }})
  }
}
</script>