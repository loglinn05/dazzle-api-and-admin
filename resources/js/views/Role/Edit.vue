<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this role"
            class="p-0 mb-10"
            link
            @click="$router.push(`/role/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit role
        </h1>
        <FadeTransition>
            <i
                v-if="rolesLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="name"
                        v-model="currentRole.normalFormat.name"
                        @keydown.enter="gatherDataAndEditRole"
                        class="sm:w-96 w-64"
                    />
                    <label for="name">Name</label>
                </FloatLabel>
                <MultiSelect
                    v-if="hasPermissions(['show permissions'])"
                    v-model="currentRole.normalFormat.permissions"
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
                    label="Edit role"
                    class="w-fit"
                    @click="gatherDataAndEditRole"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { usePermissionsStore } from "../../stores/permissionsStore";
import { useRolesStore } from "../../stores/rolesStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import MultiSelect from "primevue/multiselect";

const rolesStore = useRolesStore();
const { currentRole, rolesLoading } = storeToRefs(rolesStore);
const { getRole, editRole } = rolesStore;

const { hasPermissions } = useAuthStore();

const permissionsStore = usePermissionsStore();
const { permissions, permissionsLoading } = storeToRefs(permissionsStore);
const { getPermissions } = permissionsStore;

const route = useRoute();

onBeforeMount(() => {
    getRole(route.params.id);
    getPermissions();
});

function gatherDataAndEditRole() {
    editRole(route.params.id, JSON.stringify(currentRole.value.normalFormat));
}
</script>
