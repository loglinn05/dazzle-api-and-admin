<template>
    <Layout>
        <ConfirmPopup
            pt:content:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
        ></ConfirmPopup>
        <Button
            icon="pi pi-arrow-left"
            label="All Roles"
            class="p-0 mb-10"
            link
            @click="$router.push(`/roles`)"
        />
        <DataTable
            :value="currentRole.tableFormat"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            :loading="rolesLoading"
            pt:loadingIcon:class="text-pink-500"
            showGridlines
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col items-center gap-3 w-full"
                >
                    <Button
                        v-if="hasPermissions(['update roles'])"
                        icon="pi pi-pencil"
                        label="Edit Role"
                        class="w-fit"
                        raised
                        @click="$router.push(`/role/${$route.params.id}/edit`)"
                    />
                    <Button
                        v-if="hasPermissions(['delete roles'])"
                        icon="pi pi-trash"
                        label="Delete Role"
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
            <Column header="Value">
                <template #body="{ data }">
                    <div
                        v-if="Array.isArray(data.value)"
                        class="flex flex-col gap-y-3"
                    >
                        <div
                            v-if="data.value?.length"
                            v-for="item of data.value"
                        >
                            {{ item }}
                        </div>
                        <template v-else>—</template>
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
import { useRolesStore } from "../../stores/rolesStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import { useHelpersStore } from "../../stores/helpersStore";
import { useConfirm } from "primevue/useconfirm";

const helpersStore = useHelpersStore();
const { toSentenceCase } = helpersStore;

const route = useRoute();
const confirm = useConfirm();

const { hasPermissions } = useAuthStore();

const rolesStore = useRolesStore();
const { currentRole, rolesLoading } = storeToRefs(rolesStore);
const { getRole, deleteRole } = rolesStore;

onBeforeMount(() => {
    getRole(route.params.id);
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
            deleteRole(route.params.id);
        },
        reject: () => {},
    });
};
</script>
