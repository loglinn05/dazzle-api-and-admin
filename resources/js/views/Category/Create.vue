<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Categories"
            class="p-0 mb-10"
            link
            @click="$router.push(`/categories`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a category
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText
                    id="title"
                    v-model="title"
                    @keydown.enter="gatherDataAndCreateCategory"
                />
                <label for="title">Title</label>
            </FloatLabel>
            <Button
                label="Add category"
                class="w-fit"
                @click="gatherDataAndCreateCategory"
            />
        </div>
    </Layout>
</template>

<script setup>
import { ref } from "vue";
import { useCategoriesStore } from "../../stores/categoriesStore";

let categoryData = new FormData();

const title = ref("");

function gatherDataAndCreateCategory() {
    categoryData.append("title", title.value);
    createCategory(categoryData);
}

const categoriesStore = useCategoriesStore();
const { createCategory } = categoriesStore;
</script>
