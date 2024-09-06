import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useAuthStore } from "./authStore";
import { useHelpersStore } from "./helpersStore";

export const useUsersStore = defineStore("users", () => {
    const helpersStore = useHelpersStore();
    const { handleError } = helpersStore;

    const toast = useToast();
    const router = useRouter();

    const users = ref([]);
    const usersLoading = ref(false);

    const currentUser = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getUsers() {
        usersLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/users`)
            .then((response) => {
                users.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                usersLoading.value = false;
            });
    }

    function createUser(userData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(`${import.meta.env.VITE_API_BASE_URL}/user/create`, {
                userData: userData,
            })
            .then(() => {
                router.push("/users");
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function getUser(id) {
        clearCurrentUser();
        usersLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/user/${id}`)
            .then((response) => {
                currentUser.value.normalFormat = response.data;
                for (const key in response.data) {
                    if (key == "permissions") {
                        const { hasPermissions } = useAuthStore();
                        if (hasPermissions(["show permissions"])) {
                            currentUser.value.tableFormat.push({
                                key: key,
                                value: response.data[key],
                            });
                        }
                    } else {
                        currentUser.value.tableFormat.push({
                            key: key,
                            value: response.data[key],
                        });
                    }
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                usersLoading.value = false;
            });
    }

    function editUser(userId, userData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/user/${userId}/update`,
                { userData: userData }
            )
            .then((response) => {
                router.push(`/user/${userId}`);
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function clearCurrentUser() {
        currentUser.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteUser(userId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(`${import.meta.env.VITE_API_BASE_URL}/user/${userId}/delete`)
            .then(() => {
                router.push(`/users`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        users,
        usersLoading,
        currentUser,
        getUsers,
        createUser,
        getUser,
        editUser,
        deleteUser,
    };
});
