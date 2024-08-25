<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Colors"
            class="p-0 mb-10"
            link
            @click="$router.push(`/colors`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a color
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText
                    id="code"
                    v-model="code"
                    @keydown.enter="gatherDataAndCreateColor"
                />
                <label for="code">Code</label>
            </FloatLabel>
            <Button
                label="Add color"
                class="w-fit"
                @click="gatherDataAndCreateColor"
            />
        </div>
    </Layout>
</template>

<script setup>
import { ref } from "vue";
import { useColorsStore } from "../../stores/colorsStore";

let colorData = new FormData();

const code = ref("");

function gatherDataAndCreateColor() {
    colorData.append("code", code.value);
    createColor(colorData);
}

const colorsStore = useColorsStore();
const { createColor } = colorsStore;
</script>
