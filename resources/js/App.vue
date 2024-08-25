<template>
    <div class="flex flex-col w-full min-h-screen">
        <Toast
            :pt="{
                root: { class: 'max-w-full !top-0 !right-0' },
                container: { class: 'm-3' },
                content: {
                    class: 'flex justify-between items-center',
                },
                buttonContainer: { class: 'flex justify-center items-center' },
                button: { class: 'm-0 p-0' },
            }"
        >
            <template #message="slotProps">
                <p>{{ slotProps.message.summary }}</p>
            </template>
        </Toast>
        <router-view></router-view>
    </div>
</template>

<script setup>
import Toast from "primevue/toast";
</script>
