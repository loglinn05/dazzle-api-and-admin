<template>
    <div
        class="bg-violet-100 w-screen h-screen flex justify-center items-center"
    >
        <div
            class="grid gap-y-10 sm:p-10 p-5 border border-solid border-pink-300 rounded shadow-2xl"
        >
            <FloatLabel>
                <InputText id="email" type="email" v-model="loginData.email" />
                <label for="email">Email</label>
            </FloatLabel>
            <FloatLabel>
                <InputText
                    id="password"
                    type="password"
                    v-model="loginData.password"
                    @keydown.enter="login(loginData)"
                />
                <label for="password">Password</label>
            </FloatLabel>
            <Button
                icon="pi pi-sign-in"
                label="Log In"
                class="w-fit"
                @click="login(loginData)"
            />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "../stores/authStore";

const loginData = ref({
    email: "",
    password: "",
});

const { login } = useAuthStore();
</script>
