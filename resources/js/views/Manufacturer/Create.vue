<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Manufacturers"
            class="p-0 mb-10"
            link
            @click="$router.push(`/manufacturers`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a manufacturer
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText
                    id="name"
                    v-model="name"
                    @keydown.enter="gatherDataAndCreateManufacturer"
                />
                <label for="name">Name</label>
            </FloatLabel>
            <Button
                label="Add manufacturer"
                class="w-fit"
                @click="gatherDataAndCreateManufacturer"
            />
        </div>
    </Layout>
</template>

<script setup>
import { ref } from "vue";
import { useManufacturersStore } from "../../stores/manufacturersStore";

let manufacturerData = new FormData();

const name = ref("");

function gatherDataAndCreateManufacturer() {
    manufacturerData.append("name", name.value);
    createManufacturer(manufacturerData);
}

const manufacturersStore = useManufacturersStore();
const { createManufacturer } = manufacturersStore;
</script>
