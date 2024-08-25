<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this material"
            class="p-0 mb-10"
            link
            @click="$router.push(`/material/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit material
        </h1>
        <FadeTransition>
            <i
                v-if="materialsLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="title"
                        v-model="currentMaterial.normalFormat.title"
                        @keydown.enter="gatherDataAndEditMaterial"
                    />
                    <label for="title">Title</label>
                </FloatLabel>
                <Button
                    label="Edit material"
                    class="w-fit"
                    @click="gatherDataAndEditMaterial"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useMaterialsStore } from "../../stores/materialsStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const materialsStore = useMaterialsStore();
const { currentMaterial, materialsLoading } = storeToRefs(materialsStore);
const { getMaterial, editMaterial, clearCurrentMaterial } = materialsStore;

const route = useRoute();

onBeforeMount(() => {
    getMaterial(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentMaterial();
});

let materialData = new FormData();

function gatherDataAndEditMaterial() {
    materialData.append("title", currentMaterial.value.normalFormat.title);
    editMaterial(route.params.id, materialData);
}
</script>
