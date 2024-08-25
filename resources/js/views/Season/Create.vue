<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Seasons"
            class="p-0 mb-10"
            link
            @click="$router.push(`/seasons`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a season
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText
                    id="title"
                    v-model="title"
                    @keydown.enter="gatherDataAndCreateSeason"
                />
                <label for="title">Title</label>
            </FloatLabel>
            <Button
                label="Add season"
                class="w-fit"
                @click="gatherDataAndCreateSeason"
            />
        </div>
    </Layout>
</template>

<script setup>
import { ref } from "vue";
import { useSeasonsStore } from "../../stores/seasonsStore";

let seasonData = new FormData();

const title = ref("");

function gatherDataAndCreateSeason() {
    seasonData.append("title", title.value);
    createSeason(seasonData);
}

const seasonsStore = useSeasonsStore();
const { createSeason } = seasonsStore;
</script>
