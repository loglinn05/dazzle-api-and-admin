<template>
    <Layout>
        <ConfirmPopup
            pt:content:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
        ></ConfirmPopup>
        <Button
            icon="pi pi-arrow-left"
            label="All Colors"
            class="p-0 mb-10"
            link
            @click="$router.push(`/colors`)"
        />
        <DataTable
            :value="currentColor.tableFormat"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            :loading="colorsLoading"
            pt:loadingIcon:class="text-pink-500"
            showGridlines
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col items-center gap-3 w-full"
                >
                    <Button
                        v-if="
                            hasPermissions([
                                'update products and product features',
                            ])
                        "
                        icon="pi pi-pencil"
                        label="Edit Color"
                        class="w-fit"
                        raised
                        @click="$router.push(`/color/${$route.params.id}/edit`)"
                    />
                    <Button
                        v-if="
                            hasPermissions([
                                'delete products and product features',
                            ])
                        "
                        icon="pi pi-trash"
                        label="Delete Color"
                        class="w-fit"
                        raised
                        severity="danger"
                        @click="confirmDeletion($event)"
                    />
                </div>
            </template>
            <Column header="Property">
                <template #body="{ data }">
                    {{ toSentenceCase(data.key) }}
                </template>
            </Column>
            <Column header="Value">
                <template #body="{ data }">
                    <div class="flex items-center" v-if="data.key == 'code'">
                        <span class="me-5">{{ data.value }}</span>
                        <div
                            class="w-fit p-3 border border-slate-400"
                            :style="`background-color: ${data.value}`"
                        ></div>
                    </div>
                    <span v-else>{{ data.value }}</span>
                </template>
            </Column>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useColorsStore } from "../../stores/colorsStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import { useHelpersStore } from "../../stores/helpersStore";
import { useConfirm } from "primevue/useconfirm";

const helpersStore = useHelpersStore();
const { toSentenceCase } = helpersStore;

const { hasPermissions } = useAuthStore();

const route = useRoute();
const confirm = useConfirm();

const colorsStore = useColorsStore();
const { currentColor, colorsLoading } = storeToRefs(colorsStore);
const { getColor, clearCurrentColor, deleteColor } = colorsStore;

onBeforeMount(() => {
    getColor(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentColor();
});

const confirmDeletion = (event) => {
    confirm.require({
        target: event.currentTarget,
        message: "Do you really want to delete this record?",
        icon: "pi pi-info-circle",
        rejectClass: "p-button-secondary p-button-outlined p-button-sm",
        acceptClass: "p-button-danger p-button-sm",
        rejectLabel: "Cancel",
        acceptLabel: "Delete",
        accept: () => {
            deleteColor(route.params.id);
        },
        reject: () => {},
    });
};
</script>
