<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Users"
            class="p-0 mb-10"
            link
            @click="$router.push(`/users`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a user
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText id="name" v-model="user.name" class="sm:w-96 w-64" />
                <label for="name">Name</label>
            </FloatLabel>
            <FloatLabel>
                <InputText
                    id="email"
                    type="email"
                    v-model="user.email"
                    class="sm:w-96 w-64"
                />
                <label for="email">Email</label>
            </FloatLabel>
            <FloatLabel>
                <InputText
                    id="password"
                    type="password"
                    v-model="user.password"
                    class="sm:w-96 w-64"
                />
                <label for="password">Password</label>
            </FloatLabel>
            <FloatLabel>
                <InputText
                    id="passwordConfirmation"
                    type="password"
                    v-model="user.password_confirmation"
                    class="sm:w-96 w-64"
                />
                <label for="passwordConfirmation">Password confirmation</label>
            </FloatLabel>
            <MultiSelect
                v-if="hasPermissions(['show roles', 'assign roles'])"
                v-model="user.roles"
                display="chip"
                :options="roles"
                optionLabel="name"
                optionValue="name"
                :placeholder="rolesLoading ? 'Loading...' : 'Select roles'"
                :loading="rolesLoading"
                :maxSelectedLabels="3"
                class="sm:w-96 w-64"
            />
            <Button
                label="Add user"
                class="w-fit"
                @click="gatherDataAndCreateUser"
            />
        </div>
    </Layout>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import MultiSelect from "primevue/multiselect";
import { useAuthStore } from "../../stores/authStore";
import { useUsersStore } from "../../stores/usersStore";
import { useRolesStore } from "../../stores/rolesStore";
import { storeToRefs } from "pinia";

const user = ref({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    roles: [],
});

const usersStore = useUsersStore();
const { createUser } = usersStore;

const rolesStore = useRolesStore();
const { roles, rolesLoading } = storeToRefs(rolesStore);
const { getRoles } = rolesStore;

const { hasPermissions } = useAuthStore();

const userData = new FormData();

function gatherDataAndCreateUser() {
    for (const key in user.value) {
        if (!Array.isArray(user.value[key])) {
            userData.append(key, user.value[key]);
        } else {
            for (let i = 0; i < user.value[key].length; i++) {
                userData.append(`${key}[]`, user.value[key][i]);
            }
        }
    }
    createUser(userData);
}

onBeforeMount(() => {
    getRoles();
});
</script>
