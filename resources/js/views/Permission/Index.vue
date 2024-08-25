<template>
    <Layout>
        <DataTable
            :value="permissions"
            :loading="permissionsLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="
                permissions && permissions.length > 0 ? '' : 'hidden'
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
                        Permissions
                    </h1>
                    <Button
                        v-if="hasPermissions(['create permissions'])"
                        icon="pi pi-plus"
                        label="Add Permission"
                        raised
                        @click="$router.push('/permission/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no permissions in the database.
                </p>
            </template>
            <Column header="Name">
                <template #body="{ data }">
                    <router-link
                        :to="`/permission/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.name }}
                    </router-link>
                </template>
            </Column>
            <template #footer>
                <p
                    v-if="permissions && permissions.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ permissions.length }} permissions.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { usePermissionsStore } from "../../stores/permissionsStore";
import { storeToRefs } from "pinia";

const { hasPermissions } = useAuthStore();

const permissionsStore = usePermissionsStore();
const { permissions, permissionsLoading } = storeToRefs(permissionsStore);
const { getPermissions } = permissionsStore;

onMounted(() => {
    getPermissions();
});
</script>
