<template>
    <form v-show="false" action="/logout" method="post" id="logoutForm">
        <input type="hidden" name="_token" :value="csrf">
    </form>
</template>
<script>

export default {
    computed:{
        csrf: () => {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }
}
</script>
