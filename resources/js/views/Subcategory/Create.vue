<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Subcategories"
            class="p-0 mb-10"
            link
            @click="$router.push(`/subcategories`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a subcategory
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText id="title" v-model="subcategory.title" />
                <label for="title">Title</label>
            </FloatLabel>
            <Dropdown
                v-model="subcategory.categoryId"
                :options="categories"
                optionLabel="title"
                optionValue="id"
                :placeholder="
                    categoriesLoading ? 'Loading...' : 'Select a category'
                "
                :loading="categoriesLoading"
                class="sm:w-60 w-full"
            />
            <Button
                label="Add subcategory"
                class="w-fit"
                @click="gatherDataAndCreateSubcategory"
            />
        </div>
    </Layout>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import { storeToRefs } from "pinia";
import { useSubcategoriesStore } from "../../stores/subcategoriesStore";
import { useCategoriesStore } from "../../stores/categoriesStore";

const categoriesStore = useCategoriesStore();
const { categories, categoriesLoading } = storeToRefs(categoriesStore);
const { getCategories } = categoriesStore;

onBeforeMount(() => {
    getCategories();
});

let subcategoryData = new FormData();

const subcategory = ref({
    title: "",
    categoryId: null,
});

function gatherDataAndCreateSubcategory() {
    for (let key in subcategory.value) {
        subcategoryData.append(key, subcategory.value[key]);
    }
    createSubcategory(subcategoryData);
}

const subcategoriesStore = useSubcategoriesStore();
const { createSubcategory } = subcategoriesStore;
</script>
