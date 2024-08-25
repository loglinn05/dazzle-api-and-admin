<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this subcategory"
            class="p-0 mb-10"
            link
            @click="$router.push(`/subcategory/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit subcategory
        </h1>
        <FadeTransition>
            <i
                v-if="subcategoriesLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="title"
                        v-model="currentSubcategory.normalFormat.title"
                    />
                    <label for="title">Title</label>
                </FloatLabel>
                <Button
                    label="Edit subcategory"
                    class="w-fit"
                    @click="gatherDataAndEditSubcategory"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useSubcategoriesStore } from "../../stores/subcategoriesStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const subcategoriesStore = useSubcategoriesStore();
const { currentSubcategory, subcategoriesLoading } =
    storeToRefs(subcategoriesStore);
const { getSubcategory, editSubcategory, clearCurrentSubcategory } =
    subcategoriesStore;

const route = useRoute();

onBeforeMount(() => {
    getSubcategory(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentSubcategory();
});

let subcategoryData = new FormData();

function gatherDataAndEditSubcategory() {
    subcategoryData.append(
        "title",
        currentSubcategory.value.normalFormat.title
    );
    editSubcategory(route.params.id, subcategoryData);
}
</script>
