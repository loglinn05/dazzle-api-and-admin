<template>
    <Menubar :pt="passThrough">
        <template #start>
            <div class="flex items-center gap-3 w-full">
                <router-link to="/">
                    <h1 class="font-logo text-4xl sm:text-5xl text-pink-600">
                        Dazzle
                    </h1>
                </router-link>
                <Button icon="pi pi-home" link @click="$router.push('/')" />
                <Button
                    icon="pi pi-bars"
                    link
                    pt:root:class="xl:hidden"
                    @click="toggleSidenav"
                />
            </div>
        </template>
        <template #end>
            <div class="flex items-center gap-x-10">
                <p class="sm:text-lg text-base font-text text-violet-700">
                    Hi, {{ currentUser.name }}!
                </p>
                <Button
                    icon="pi pi-sign-out"
                    label="Log Out"
                    raised
                    @click="logout"
                />
            </div>
        </template>
    </Menubar>
</template>

<script setup>
import Menubar from "primevue/menubar";
import Badge from "primevue/badge";
import { useAuthStore } from "../../stores/authStore";
import { useSidenavStore } from "../../stores/sidenavStore";
import { storeToRefs } from "pinia";

const passThrough = {
    root: {
        class: "w-full flex md:flex-row flex-col justify-center items-center my-0 py-1 px-3 bg-violet-100 rounded-none z-[100]",
    },
    end: {
        class: "md:ms-auto ms-0",
    },
};

const authStore = useAuthStore();
const { currentUser } = storeToRefs(authStore);
const { logout } = authStore;

const sidenavStore = useSidenavStore();
const { toggleSidenav } = sidenavStore;
</script>
