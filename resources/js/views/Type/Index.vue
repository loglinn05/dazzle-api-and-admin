<template>
    <Layout>
        <DataTable
            :value="types"
            :loading="typesLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="types && types.length > 0 ? '' : 'hidden'"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            showGridlines
            scrollable
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col gap-5 items-center sm:justify-between justify-center"
                >
                    <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                        Types
                    </h1>
                    <Button
                        v-if="
                            hasPermissions([
                                'create products and product features',
                            ])
                        "
                        icon="pi pi-plus"
                        label="Add Type"
                        raised
                        @click="$router.push('/type/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no types in the database.
                </p>
            </template>
            <Column header="Title">
                <template #body="{ data }">
                    <router-link
                        :to="`/type/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.title }}
                    </router-link>
                </template>
            </Column>
            <Column header="Subcategory">
                <template #body="{ data }">
                    {{ data.subcategory_title }}
                </template>
            </Column>
            <Column header="Category">
                <template #body="{ data }">
                    {{ data.category_title }}
                </template>
            </Column>
            <template #footer>
                <p
                    v-if="types && types.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ types.length }} types.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useTypesStore } from "../../stores/typesStore";
import { storeToRefs } from "pinia";

const { hasPermissions } = useAuthStore();

const typesStore = useTypesStore();
const { types, typesLoading } = storeToRefs(typesStore);
const { getTypes } = typesStore;

onMounted(() => {
    getTypes();
});
</script>
