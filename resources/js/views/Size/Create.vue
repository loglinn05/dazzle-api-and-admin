<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Sizes"
            class="p-0 mb-10"
            link
            @click="$router.push(`/sizes`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a size
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText
                    id="title"
                    v-model="title"
                    @keydown.enter="gatherDataAndCreateSize"
                />
                <label for="title">Title</label>
            </FloatLabel>
            <Button
                label="Add size"
                class="w-fit"
                @click="gatherDataAndCreateSize"
            />
        </div>
    </Layout>
</template>

<script setup>
import { ref } from "vue";
import { useSizesStore } from "../../stores/sizesStore";

let sizeData = new FormData();

const title = ref("");

function gatherDataAndCreateSize() {
    sizeData.append("title", title.value);
    createSize(sizeData);
}

const sizesStore = useSizesStore();
const { createSize } = sizesStore;
</script>
