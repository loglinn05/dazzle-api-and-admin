<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this season"
            class="p-0 mb-10"
            link
            @click="$router.push(`/season/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit season
        </h1>
        <FadeTransition>
            <i
                v-if="seasonsLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="title"
                        v-model="currentSeason.normalFormat.title"
                        @keydown.enter="gatherDataAndEditSeason"
                    />
                    <label for="title">Title</label>
                </FloatLabel>
                <Button
                    label="Edit season"
                    class="w-fit"
                    @click="gatherDataAndEditSeason"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useSeasonsStore } from "../../stores/seasonsStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const seasonsStore = useSeasonsStore();
const { currentSeason, seasonsLoading } = storeToRefs(seasonsStore);
const { getSeason, editSeason, clearCurrentSeason } = seasonsStore;

const route = useRoute();

onBeforeMount(() => {
    getSeason(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentSeason();
});

let seasonData = new FormData();

function gatherDataAndEditSeason() {
    seasonData.append("title", currentSeason.value.normalFormat.title);
    editSeason(route.params.id, seasonData);
}
</script>
