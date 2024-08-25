<template>
    <Navbar />
    <div class="relative flex grow">
        <div
            :class="`xl:static fixed grow xl:h-auto h-full z-10 [&_*]:!overflow-hidden transition-all duration-1000 bg-violet-100 xl:max-w-full ${
                sidenavVisible ? 'max-w-full' : 'max-w-0'
            }`"
            v-touch:swipe.left="hideSidenav"
        >
            <Sidenav />
        </div>
        <div class="relative w-full bg-white">
            <FadeTransition>
                <div
                    v-if="sidenavVisible"
                    class="absolute bg-black/50 w-full h-full z-[5]"
                    @click="hideSidenav"
                ></div>
            </FadeTransition>
            <div class="py-10 md:px-10 px-5 min-h-full"><slot></slot></div>
        </div>
    </div>
</template>

<script setup>
import Navbar from "@/components/layout/Navbar.vue";
import Sidenav from "@/components/layout/Sidenav.vue";
import { useSidenavStore } from "../../stores/sidenavStore";
import { storeToRefs } from "pinia";
import { useAuthStore } from "../../stores/authStore";
import { computed } from "vue";

const authStore = useAuthStore();
const { currentUser } = storeToRefs(authStore);

const authorized = computed(() => {
    return (
        currentUser.value.loggedIn &&
        currentUser.value.token &&
        (currentUser.value.roles.includes("super admin") ||
            currentUser.value.roles.includes("admin") ||
            currentUser.value.roles.includes("staff"))
    );
});

const sidenavStore = useSidenavStore();
const { sidenavVisible } = storeToRefs(sidenavStore);
const { hideSidenav } = sidenavStore;
</script>
