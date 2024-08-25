<template>
    <Layout>
        <DataTable
            :value="roles"
            :loading="rolesLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="roles && roles.length > 0 ? '' : 'hidden'"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            showGridlines
            scrollable
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col gap-5 items-center sm:justify-between justify-center"
                >
                    <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                        Roles
                    </h1>
                    <Button
                        v-if="hasPermissions(['create roles'])"
                        icon="pi pi-plus"
                        label="Add Role"
                        raised
                        @click="$router.push('/role/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no roles in the database.
                </p>
            </template>
            <Column header="Name">
                <template #body="{ data }">
                    <router-link
                        :to="`/role/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.name }}
                    </router-link>
                </template>
            </Column>
            <template #footer>
                <p
                    v-if="roles && roles.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ roles.length }} roles.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useRolesStore } from "../../stores/rolesStore";
import { storeToRefs } from "pinia";

const { hasPermissions } = useAuthStore();

const rolesStore = useRolesStore();
const { roles, rolesLoading } = storeToRefs(rolesStore);
const { getRoles } = rolesStore;

onMounted(() => {
    getRoles();
});
</script>
