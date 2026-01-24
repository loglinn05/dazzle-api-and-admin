<template>
    <Toast :pt="toastPt" />
    <div class="flex flex-col w-full min-h-screen">
        <router-view></router-view>
    </div>
</template>

<script setup>
import Toast from "primevue/toast";

const toastPt = {
    messageIcon: { class: 'my-auto' },
    messageText: { class: 'my-auto' },
    closeButton: { class: 'my-auto' }
};
</script>
