<template>
    <Layout>
        <DataTable
            :value="users"
            :loading="usersLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="users && users.length > 0 ? '' : 'hidden'"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            showGridlines
            scrollable
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col gap-5 items-center sm:justify-between justify-center"
                >
                    <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                        Users
                    </h1>
                    <Button
                        v-if="hasPermissions(['create users'])"
                        icon="pi pi-plus"
                        label="Add User"
                        raised
                        @click="$router.push('/user/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no users in the database.
                </p>
            </template>
            <Column header="Name">
                <template #body="{ data }">
                    <router-link
                        :to="`/user/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.name }}
                    </router-link>
                </template>
            </Column>
            <Column header="Email" field="email"></Column>
            <template #footer>
                <p
                    v-if="users && users.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ users.length }} users.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useUsersStore } from "../../stores/usersStore";
import { storeToRefs } from "pinia";

const { hasPermissions } = useAuthStore();

const usersStore = useUsersStore();
const { users, usersLoading } = storeToRefs(usersStore);
const { getUsers } = usersStore;

onMounted(() => {
    getUsers();
});
</script>
