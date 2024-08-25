<template>
    <Layout>
        <DataTable
            :value="colors"
            :loading="colorsLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="colors && colors.length > 0 ? '' : 'hidden'"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            showGridlines
            scrollable
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col gap-5 items-center sm:justify-between justify-center"
                >
                    <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                        Colors
                    </h1>
                    <Button
                        v-if="
                            hasPermissions([
                                'create products and product features',
                            ])
                        "
                        icon="pi pi-plus"
                        label="Add Color"
                        raised
                        @click="$router.push('/color/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no colors in the database.
                </p>
            </template>
            <Column header="Color Code">
                <template #body="{ data }">
                    <router-link
                        :to="`/color/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.code }}
                    </router-link>
                </template>
            </Column>
            <Column header="Color">
                <template #body="{ data }">
                    <div
                        class="w-fit p-5 border border-slate-400"
                        :style="`background-color: ${data.code}`"
                    ></div>
                </template>
            </Column>
            <template #footer>
                <p
                    v-if="colors && colors.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ colors.length }} colors.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useColorsStore } from "../../stores/colorsStore";
import { storeToRefs } from "pinia";

const { hasPermissions } = useAuthStore();

const colorsStore = useColorsStore();
const { colors, colorsLoading } = storeToRefs(colorsStore);
const { getColors } = colorsStore;

onMounted(() => {
    getColors();
});
</script>
