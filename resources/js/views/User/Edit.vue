<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this user"
            class="p-0 mb-10"
            link
            @click="$router.push(`/user/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit user
        </h1>
        <FadeTransition>
            <i
                v-if="usersLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel
                    class="after:content-['*'] after:ml-0.5 after:text-red-500"
                >
                    <InputText
                        id="name"
                        v-model="user.name"
                        class="sm:w-96 w-64"
                    />
                    <label for="name">Name</label>
                </FloatLabel>
                <FloatLabel
                    class="after:content-['*'] after:ml-0.5 after:mt-0 after:text-red-500"
                >
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
                        id="newPassword"
                        type="password"
                        v-model="user.new_password"
                        class="sm:w-96 w-64"
                    />
                    <label for="newPassword">New password (optional)</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText
                        id="passwordConfirmation"
                        type="password"
                        v-model="user.new_password_confirmation"
                        class="sm:w-96 w-64"
                    />
                    <label for="passwordConfirmation"
                        >New password confirmation</label
                    >
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
                    label="Edit user"
                    class="w-fit"
                    @click="gatherDataAndEditUser"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { ref, onBeforeMount, watch } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useUsersStore } from "../../stores/usersStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import MultiSelect from "primevue/multiselect";
import { useRolesStore } from "../../stores/rolesStore";

const { hasPermissions } = useAuthStore();

const usersStore = useUsersStore();
const { currentUser, usersLoading } = storeToRefs(usersStore);
const { getUser, editUser } = usersStore;

const rolesStore = useRolesStore();
const { roles, rolesLoading } = storeToRefs(rolesStore);
const { getRoles } = rolesStore;

const route = useRoute();

onBeforeMount(() => {
    getUser(route.params.id);
    if (hasPermissions(["show roles"])) {
        getRoles();
    }
});

const user = ref({
    name: "",
    email: "",
    new_password: null,
    new_password_confirmation: null,
    roles: [],
});
watch(
    currentUser,
    () => {
        if (currentUser.value.normalFormat.name) {
            user.value.name = currentUser.value.normalFormat.name;
        }
        if (currentUser.value.normalFormat.email) {
            user.value.email = currentUser.value.normalFormat.email;
        }
    },
    { deep: true }
);

let userData = new FormData();

function gatherDataAndEditUser() {
    for (const key in user.value) {
        if (!Array.isArray(user.value[key])) {
            userData.append(key, user.value[key]);
        } else {
            for (let i = 0; i < user.value[key].length; i++) {
                userData.append(`${key}[]`, user.value[key][i]);
            }
        }
    }
    editUser(route.params.id, userData);
}
</script>
