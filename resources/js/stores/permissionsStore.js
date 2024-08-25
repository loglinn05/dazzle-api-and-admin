import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";

export const usePermissionsStore = defineStore("permissions", () => {
    const router = useRouter();
    const toast = useToast();

    const permissions = ref([]);
    const permissionsLoading = ref(false);

    const currentPermission = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getPermissions() {
        permissionsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/permissions`)
            .then((response) => {
                permissions.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                permissionsLoading.value = false;
            });
    }

    function createPermission(permissionData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/permission/create`,
                permissionData
            )
            .then(() => {
                router.push("/permissions");
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

    function getPermission(id) {
        clearCurrentPermission();
        permissionsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/permission/${id}`)
            .then((response) => {
                currentPermission.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentPermission.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                permissionsLoading.value = false;
            });
    }

    function editPermission(permissionId, permissionData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/permission/${permissionId}/update`,
                permissionData
            )
            .then(() => {
                router.push(`/permission/${permissionId}`);
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

    function clearCurrentPermission() {
        currentPermission.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deletePermission(permissionId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/permission/${permissionId}/delete`
            )
            .then(() => {
                router.push(`/permissions`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        permissions,
        permissionsLoading,
        currentPermission,
        getPermissions,
        createPermission,
        getPermission,
        editPermission,
        deletePermission,
    };
});
