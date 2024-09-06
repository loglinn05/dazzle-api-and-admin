<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Roles"
            class="p-0 mb-10"
            link
            @click="$router.push(`/roles`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a role
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText
                    id="name"
                    v-model="role.name"
                    @keydown.enter="gatherDataAndCreateRole"
                    class="sm:w-96 w-64"
                />
                <label for="name">Name</label>
            </FloatLabel>
            <MultiSelect
                v-if="hasPermissions(['show permissions'])"
                v-model="role.permissions"
                display="chip"
                :options="permissions"
                optionLabel="name"
                optionValue="name"
                :placeholder="
                    permissionsLoading ? 'Loading...' : 'Select permissions'
                "
                :loading="permissionsLoading"
                filter
                :maxSelectedLabels="3"
                class="sm:w-96 w-64"
            />
            <Button
                label="Add role"
                class="w-fit"
                @click="gatherDataAndCreateRole"
            />
        </div>
    </Layout>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useRolesStore } from "../../stores/rolesStore";
import { usePermissionsStore } from "../../stores/permissionsStore";
import { storeToRefs } from "pinia";
import MultiSelect from "primevue/multiselect";

const role = ref({
    name: "",
    permissions: [],
});

function gatherDataAndCreateRole() {
    createRole(JSON.stringify(role.value));
}

const rolesStore = useRolesStore();
const { createRole } = rolesStore;

const { hasPermissions } = useAuthStore();

const permissionsStore = usePermissionsStore();
const { permissions, permissionsLoading } = storeToRefs(permissionsStore);
const { getPermissions } = permissionsStore;

onBeforeMount(() => {
    getPermissions();
});
</script>
