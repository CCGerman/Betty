<template>
    <h3 class="py-5 text-center text-uppercase">{{ title }}</h3>
</template>
<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        }
    }
}
</script>