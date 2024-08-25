<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Materials"
            class="p-0 mb-10"
            link
            @click="$router.push(`/materials`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a material
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText
                    id="title"
                    v-model="title"
                    @keydown.enter="gatherDataAndCreateMaterial"
                />
                <label for="title">Title</label>
            </FloatLabel>
            <Button
                label="Add material"
                class="w-fit"
                @click="gatherDataAndCreateMaterial"
            />
        </div>
    </Layout>
</template>

<script setup>
import { ref } from "vue";
import { useMaterialsStore } from "../../stores/materialsStore";

let materialData = new FormData();

const title = ref("");

function gatherDataAndCreateMaterial() {
    materialData.append("title", title.value);
    createMaterial(materialData);
}

const materialsStore = useMaterialsStore();
const { createMaterial } = materialsStore;
</script>
