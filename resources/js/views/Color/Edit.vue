<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this color"
            class="p-0 mb-10"
            link
            @click="$router.push(`/color/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit color
        </h1>
        <FadeTransition>
            <i
                v-if="colorsLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="code"
                        v-model="currentColor.normalFormat.code"
                        @keydown.enter="gatherDataAndEditColor"
                    />
                    <label for="code">Code</label>
                </FloatLabel>
                <Button
                    label="Edit color"
                    class="w-fit"
                    @click="gatherDataAndEditColor"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useColorsStore } from "../../stores/colorsStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const colorsStore = useColorsStore();
const { currentColor, colorsLoading } = storeToRefs(colorsStore);
const { getColor, editColor, clearCurrentColor } = colorsStore;

const route = useRoute();

onBeforeMount(() => {
    getColor(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentColor();
});

let colorData = new FormData();

function gatherDataAndEditColor() {
    colorData.append("code", currentColor.value.normalFormat.code);
    editColor(route.params.id, colorData);
}
</script>
