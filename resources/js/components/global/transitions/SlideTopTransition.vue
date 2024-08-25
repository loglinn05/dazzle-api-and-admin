<template>
  <TransitionGroup name="slide-top" @beforeLeave="beforeLeave">
    <slot></slot>
  </TransitionGroup>
</template>

<script setup>
function beforeLeave(el) {
  const { marginLeft, marginTop, width, height } = window.getComputedStyle(el)
  el.style.left = `${el.offsetLeft - parseFloat(marginLeft)}px`
  el.style.top = `${el.offsetTop - parseFloat(marginTop)}px`
  el.style.width = width
  el.style.height = height
}
</script>

<style>
.slide-top-move,
.slide-top-enter-active,
.slide-top-leave-active {
  transition: all 0.5s ease-out;
}

.slide-top-enter-from,
.slide-top-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

.slide-top-leave-active {
  position: absolute;
}
</style>
