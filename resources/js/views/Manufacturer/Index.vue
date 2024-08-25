<template>
    <Layout>
        <DataTable
            :value="manufacturers"
            :loading="manufacturersLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="
                manufacturers && manufacturers.length > 0 ? '' : 'hidden'
            "
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            showGridlines
            scrollable
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col gap-5 items-center sm:justify-between justify-center"
                >
                    <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                        Manufacturers
                    </h1>
                    <Button
                        v-if="
                            hasPermissions([
                                'create products and product features',
                            ])
                        "
                        icon="pi pi-plus"
                        label="Add Manufacturer"
                        raised
                        @click="$router.push('/manufacturer/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no manufacturers in the database.
                </p>
            </template>
            <Column header="Name">
                <template #body="{ data }">
                    <router-link
                        :to="`/manufacturer/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.name }}
                    </router-link>
                </template>
            </Column>
            <template #footer>
                <p
                    v-if="manufacturers && manufacturers.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ manufacturers.length }} manufacturers.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useManufacturersStore } from "../../stores/manufacturersStore";
import { storeToRefs } from "pinia";

const { hasPermissions } = useAuthStore();

const manufacturersStore = useManufacturersStore();
const { manufacturers, manufacturersLoading } = storeToRefs(manufacturersStore);
const { getManufacturers } = manufacturersStore;

onMounted(() => {
    getManufacturers();
});
</script>
