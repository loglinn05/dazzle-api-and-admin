import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useAuthStore } from "./authStore";
import { isEmptyObject } from "../helpers";

export const useUsersStore = defineStore("users", () => {
    const router = useRouter();
    const toast = useToast();

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
            .post(`${import.meta.env.VITE_API_BASE_URL}/user/create`, userData)
            .then(() => {
                router.push("/users");
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    for (let key in error.response.data.errors) {
                        error.response.data.errors[key].forEach((error) => {
                            toast.add({
                                severity: "error",
                                summary: error,
                                life: 5000,
                            });
                        });
                    }
                } else {
                    console.error(error);
                }
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
                userData
            )
            .then(() => {
                router.push(`/user/${userId}`);
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    for (let key in error.response.data.errors) {
                        error.response.data.errors[key].forEach((error) => {
                            toast.add({
                                severity: "error",
                                summary: error,
                                life: 5000,
                            });
                        });
                    }
                } else {
                    console.error(error);
                }
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
