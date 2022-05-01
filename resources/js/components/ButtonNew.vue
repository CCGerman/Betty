<template>
  <div class="new-element rounded-circle btn btn-primary"
    @click="$emit('new')">
    <slot></slot>
  </div>
</template>

<style>
    .new-element{
        font-size: 2rem;
        margin: .5rem;
        position: fixed;
        height: 70px;
        width: 70px;
        right: 50px;
        bottom: 50px;
        z-index: 10;   
    }
</style>