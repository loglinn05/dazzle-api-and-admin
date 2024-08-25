<template>
    <Tree
        :value="sidenavNodes"
        :pt="{ node: { class: 'cursor-pointer' } }"
        selectionMode="single"
        @nodeSelect="navigateToNodeRoute"
        class="w-full bg-transparent p-3 text-nowrap sm:text-lg text-base font-text [&_*]:shrink-0 [&_*]:text-violet-700 overflow-y-auto"
    ></Tree>
</template>

<script setup>
import { onMounted } from "vue";
import Tree from "primevue/tree";
import { useSidenavStore } from "@/stores/sidenavStore";
import { storeToRefs } from "pinia";

const sidenavStore = useSidenavStore();

const { sidenavNodes } = storeToRefs(sidenavStore);
const { getSidenavNodes, navigateToNodeRoute } = sidenavStore;

onMounted(() => {
    getSidenavNodes();
});
</script>
