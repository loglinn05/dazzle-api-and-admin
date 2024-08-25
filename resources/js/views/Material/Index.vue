<template>
    <Layout>
        <DataTable
            :value="materials"
            :loading="materialsLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="materials && materials.length > 0 ? '' : 'hidden'"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            showGridlines
            scrollable
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col gap-5 items-center sm:justify-between justify-center"
                >
                    <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                        Materials
                    </h1>
                    <Button
                        v-if="
                            hasPermissions([
                                'create products and product features',
                            ])
                        "
                        icon="pi pi-plus"
                        label="Add Material"
                        raised
                        @click="$router.push('/material/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no materials in the database.
                </p>
            </template>
            <Column header="Title">
                <template #body="{ data }">
                    <router-link
                        :to="`/material/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.title }}
                    </router-link>
                </template>
            </Column>
            <template #footer>
                <p
                    v-if="materials && materials.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ materials.length }} materials.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useMaterialsStore } from "../../stores/materialsStore";
import { storeToRefs } from "pinia";

const { hasPermissions } = useAuthStore();

const materialsStore = useMaterialsStore();
const { materials, materialsLoading } = storeToRefs(materialsStore);
const { getMaterials } = materialsStore;

onMounted(() => {
    getMaterials();
});
</script>
