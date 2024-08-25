<template>
    <Layout>
        <ConfirmPopup
            pt:content:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
        ></ConfirmPopup>
        <Button
            icon="pi pi-arrow-left"
            label="All Types"
            class="p-0 mb-10"
            link
            @click="$router.push(`/types`)"
        />
        <DataTable
            :value="currentType.tableFormat"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            :loading="typesLoading"
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
                        label="Edit Type"
                        class="w-fit"
                        raised
                        @click="$router.push(`/type/${$route.params.id}/edit`)"
                    />
                    <Button
                        v-if="
                            hasPermissions([
                                'delete products and product features',
                            ])
                        "
                        icon="pi pi-trash"
                        label="Delete Type"
                        class="w-fit"
                        raised
                        severity="danger"
                        @click="confirmDeletion($event)"
                    />
                </div>
            </template>
            <Column field="key" header="Property">
                <template #body="{ data }">
                    {{ toSentenceCase(data.key) }}
                </template>
            </Column>
            <Column field="value" header="Value"></Column>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useTypesStore } from "../../stores/typesStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import { toSentenceCase } from "../../helpers.js";
import { useConfirm } from "primevue/useconfirm";

const { hasPermissions } = useAuthStore();

const route = useRoute();
const confirm = useConfirm();

const typesStore = useTypesStore();
const { currentType, typesLoading } = storeToRefs(typesStore);
const { getType, clearCurrentType, deleteType } = typesStore;

onBeforeMount(() => {
    getType(route.params.id);
});

onBeforeUnmount(() => {
    clearCurrentType();
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
            deleteType(route.params.id);
        },
        reject: () => {},
    });
};
</script>
