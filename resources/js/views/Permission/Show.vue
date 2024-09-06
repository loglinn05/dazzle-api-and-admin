<template>
    <Layout>
        <ConfirmPopup
            pt:content:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
        ></ConfirmPopup>
        <Button
            icon="pi pi-arrow-left"
            label="All Permissions"
            class="p-0 mb-10"
            link
            @click="$router.push(`/permissions`)"
        />
        <DataTable
            :value="currentPermission.tableFormat"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            :loading="permissionsLoading"
            pt:loadingIcon:class="text-pink-500"
            showGridlines
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col items-center gap-3 w-full"
                >
                    <Button
                        v-if="hasPermissions(['update permissions'])"
                        icon="pi pi-pencil"
                        label="Edit Permission"
                        class="w-fit"
                        raised
                        @click="
                            $router.push(`/permission/${$route.params.id}/edit`)
                        "
                    />
                    <Button
                        v-if="hasPermissions(['delete permissions'])"
                        icon="pi pi-trash"
                        label="Delete Permission"
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
import { usePermissionsStore } from "../../stores/permissionsStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import { useHelpersStore } from "../../stores/helpersStore";
import { useConfirm } from "primevue/useconfirm";

const helpersStore = useHelpersStore();
const { toSentenceCase } = helpersStore;

const route = useRoute();
const confirm = useConfirm();

const { hasPermissions } = useAuthStore();

const permissionsStore = usePermissionsStore();
const { currentPermission, permissionsLoading } = storeToRefs(permissionsStore);
const { getPermission, deletePermission } = permissionsStore;

onBeforeMount(() => {
    getPermission(route.params.id);
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
            deletePermission(route.params.id);
        },
        reject: () => {},
    });
};
</script>
