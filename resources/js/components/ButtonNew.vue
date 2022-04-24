<template>
  <div class="new-client rounded-circle btn btn-primary"
    @click="$emit('new')">
    <slot></slot>
  </div>
</template>

<style>
    .new-client{
        font-size: 2rem;
        margin: .5rem;
        position: fixed;
        height: 70px;
        width: 70px;
        right: 50px;
        bottom: 50px;   
    }
</style>