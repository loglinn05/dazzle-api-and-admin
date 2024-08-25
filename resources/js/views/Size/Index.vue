<template>
    <Layout>
        <DataTable
            :value="sizes"
            :loading="sizesLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="sizes && sizes.length > 0 ? '' : 'hidden'"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            showGridlines
            scrollable
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col gap-5 items-center sm:justify-between justify-center"
                >
                    <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                        Sizes
                    </h1>
                    <Button
                        v-if="
                            hasPermissions([
                                'create products and product features',
                            ])
                        "
                        icon="pi pi-plus"
                        label="Add Size"
                        raised
                        @click="$router.push('/size/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no sizes in the database.
                </p>
            </template>
            <Column header="Title">
                <template #body="{ data }">
                    <router-link
                        :to="`/size/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.title }}
                    </router-link>
                </template>
            </Column>
            <template #footer>
                <p
                    v-if="sizes && sizes.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ sizes.length }} sizes.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useSizesStore } from "../../stores/sizesStore";
import { storeToRefs } from "pinia";

const { hasPermissions } = useAuthStore();

const sizesStore = useSizesStore();
const { sizes, sizesLoading } = storeToRefs(sizesStore);
const { getSizes } = sizesStore;

onMounted(() => {
    getSizes();
});
</script>
