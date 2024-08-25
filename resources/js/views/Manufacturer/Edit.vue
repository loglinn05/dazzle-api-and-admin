<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this manufacturer"
            class="p-0 mb-10"
            link
            @click="$router.push(`/manufacturer/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit manufacturer
        </h1>
        <FadeTransition>
            <i
                v-if="manufacturersLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="name"
                        v-model="currentManufacturer.normalFormat.name"
                        @keydown.enter="gatherDataAndEditManufacturer"
                    />
                    <label for="name">Name</label>
                </FloatLabel>
                <Button
                    label="Edit manufacturer"
                    class="w-fit"
                    @click="gatherDataAndEditManufacturer"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useManufacturersStore } from "../../stores/manufacturersStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const manufacturersStore = useManufacturersStore();
const { currentManufacturer, manufacturersLoading } =
    storeToRefs(manufacturersStore);
const { getManufacturer, editManufacturer, clearCurrentManufacturer } =
    manufacturersStore;

const route = useRoute();

onBeforeMount(() => {
    getManufacturer(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentManufacturer();
});

let manufacturerData = new FormData();

function gatherDataAndEditManufacturer() {
    manufacturerData.append(
        "name",
        currentManufacturer.value.normalFormat.name
    );
    editManufacturer(route.params.id, manufacturerData);
}
</script>
