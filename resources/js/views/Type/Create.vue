<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Types"
            class="p-0 mb-10"
            link
            @click="$router.push(`/types`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a type
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText id="title" v-model="type.title" />
                <label for="title">Title</label>
            </FloatLabel>
            <Dropdown
                v-model="type.subcategoryId"
                :options="subcategories"
                optionLabel="title"
                optionValue="id"
                :placeholder="
                    subcategoriesLoading ? 'Loading...' : 'Select a subcategory'
                "
                :loading="subcategoriesLoading"
                class="sm:w-60 w-full"
            />
            <Button
                label="Add type"
                class="w-fit"
                @click="gatherDataAndCreateType"
            />
        </div>
    </Layout>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import { storeToRefs } from "pinia";
import { useTypesStore } from "../../stores/typesStore";
import { useSubcategoriesStore } from "../../stores/subcategoriesStore";

const subcategoriesStore = useSubcategoriesStore();
const { subcategories, subcategoriesLoading } = storeToRefs(subcategoriesStore);
const { getSubcategories } = subcategoriesStore;

onBeforeMount(() => {
    getSubcategories();
});

let typeData = new FormData();

const type = ref({
    title: "",
    subcategoryId: null,
});

function gatherDataAndCreateType() {
    for (let key in type.value) {
        typeData.append(key, type.value[key]);
    }
    createType(typeData);
}

const typesStore = useTypesStore();
const { createType } = typesStore;
</script>
