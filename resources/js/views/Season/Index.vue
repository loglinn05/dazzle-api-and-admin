<template>
    <Layout>
        <DataTable
            :value="seasons"
            :loading="seasonsLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="seasons && seasons.length > 0 ? '' : 'hidden'"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            showGridlines
            scrollable
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col gap-5 items-center sm:justify-between justify-center"
                >
                    <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                        Seasons
                    </h1>
                    <Button
                        v-if="
                            hasPermissions([
                                'create products and product features',
                            ])
                        "
                        icon="pi pi-plus"
                        label="Add Season"
                        raised
                        @click="$router.push('/season/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no seasons in the database.
                </p>
            </template>
            <Column header="Title">
                <template #body="{ data }">
                    <router-link
                        :to="`/season/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.title }}
                    </router-link>
                </template>
            </Column>
            <template #footer>
                <p
                    v-if="seasons && seasons.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ seasons.length }} seasons.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useSeasonsStore } from "../../stores/seasonsStore";
import { storeToRefs } from "pinia";

const { hasPermissions } = useAuthStore();

const seasonsStore = useSeasonsStore();
const { seasons, seasonsLoading } = storeToRefs(seasonsStore);
const { getSeasons } = seasonsStore;

onMounted(() => {
    getSeasons();
});
</script>
