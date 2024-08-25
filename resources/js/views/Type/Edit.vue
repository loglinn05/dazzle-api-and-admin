<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this type"
            class="p-0 mb-10"
            link
            @click="$router.push(`/type/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit type
        </h1>
        <FadeTransition>
            <i
                v-if="typesLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="title"
                        v-model="currentType.normalFormat.title"
                    />
                    <label for="title">Title</label>
                </FloatLabel>
                <Button
                    label="Edit type"
                    class="w-fit"
                    @click="gatherDataAndEditType"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useTypesStore } from "../../stores/typesStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const typesStore = useTypesStore();
const { currentType, typesLoading } = storeToRefs(typesStore);
const { getType, editType, clearCurrentType } = typesStore;

const route = useRoute();

onBeforeMount(() => {
    getType(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentType();
});

let typeData = new FormData();

function gatherDataAndEditType() {
    typeData.append("title", currentType.value.normalFormat.title);
    editType(route.params.id, typeData);
}
</script>
