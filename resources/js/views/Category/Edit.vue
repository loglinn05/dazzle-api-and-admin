<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this category"
            class="p-0 mb-10"
            link
            @click="$router.push(`/category/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit category
        </h1>
        <FadeTransition>
            <i
                v-if="categoriesLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="title"
                        v-model="currentCategory.normalFormat.title"
                        @keydown.enter="gatherDataAndEditCategory"
                    />
                    <label for="title">Title</label>
                </FloatLabel>
                <Button
                    label="Edit category"
                    class="w-fit"
                    @click="gatherDataAndEditCategory"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useCategoriesStore } from "../../stores/categoriesStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const categoriesStore = useCategoriesStore();
const { currentCategory, categoriesLoading } = storeToRefs(categoriesStore);
const { getCategory, editCategory, clearCurrentCategory } = categoriesStore;

const route = useRoute();

onBeforeMount(() => {
    getCategory(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentCategory();
});

let categoryData = new FormData();

function gatherDataAndEditCategory() {
    categoryData.append("title", currentCategory.value.normalFormat.title);
    editCategory(route.params.id, categoryData);
}
</script>
