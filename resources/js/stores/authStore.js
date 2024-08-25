import { defineStore } from "pinia";
import { useToast } from "primevue/usetoast";
import { ref } from "vue";
import { useRouter } from "vue-router";

export const useAuthStore = defineStore(
    "auth",
    () => {
        const router = useRouter();
        const toast = useToast();

        const currentUser = ref({
            name: "",
            email: "",
            roles: [],
            permissions: [],
            loggedIn: false,
            token: "",
        });

        function login(credentials) {
            toast.add({
                severity: "info",
                summary: "Wait a minute...",
                life: 3000,
            });
            axios
                .post(`${import.meta.env.VITE_API_BASE_URL}/login`, credentials)
                .then(function (response) {
                    currentUser.value = response.data.user;
                    currentUser.value.loggedIn = true;
                    currentUser.value.token = response.data.token;
                    window.axios.defaults.headers.common[
                        "Authorization"
                    ] = `Bearer ${currentUser.value.token}`;
                    router.push("/");
                })
                .catch(function (error) {
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
                    } else if (
                        error.response.status == 401 &&
                        error.response.data.message
                    ) {
                        toast.add({
                            severity: "error",
                            summary: error.response.data.message,
                            life: 5000,
                        });
                    } else {
                        console.error(error);
                    }
                });
        }

        function logout() {
            toast.add({
                severity: "info",
                summary: "Wait a minute...",
                life: 2000,
            });
            axios
                .post(`${import.meta.env.VITE_API_BASE_URL}/logout`)
                .then(function () {
                    currentUser.value = {
                        name: "",
                        email: "",
                        roles: [],
                        permissions: [],
                        loggedIn: false,
                        token: "",
                    };
                    delete window
                        .axios.defaults.headers.common["Authorization"];
                    router.push("/login");
                })
                .catch(function (error) {
                    console.error(error);
                });
        }

        function hasRoles(roles) {
            for (let i = 0; i < roles.length; i++) {
                if (!currentUser.value.roles.includes(roles[i])) {
                    return false;
                }
            }
            return true;
        }

        function hasPermissions(permissions) {
            for (let i = 0; i < permissions.length; i++) {
                if (!currentUser.value.permissions.includes(permissions[i])) {
                    return false;
                }
            }
            return true;
        }

        return {
            currentUser,
            login,
            logout,
            hasRoles,
            hasPermissions,
        };
    },
    {
        persist: true,
    }
);
