<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this size"
            class="p-0 mb-10"
            link
            @click="$router.push(`/size/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit size
        </h1>
        <FadeTransition>
            <i
                v-if="sizesLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="title"
                        v-model="currentSize.normalFormat.title"
                        @keydown.enter="gatherDataAndEditSize"
                    />
                    <label for="title">Title</label>
                </FloatLabel>
                <Button
                    label="Edit size"
                    class="w-fit"
                    @click="gatherDataAndEditSize"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useSizesStore } from "../../stores/sizesStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const sizesStore = useSizesStore();
const { currentSize, sizesLoading } = storeToRefs(sizesStore);
const { getSize, editSize, clearCurrentSize } = sizesStore;

const route = useRoute();

onBeforeMount(() => {
    getSize(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentSize();
});

let sizeData = new FormData();

function gatherDataAndEditSize() {
    sizeData.append("title", currentSize.value.normalFormat.title);
    editSize(route.params.id, sizeData);
}
</script>
