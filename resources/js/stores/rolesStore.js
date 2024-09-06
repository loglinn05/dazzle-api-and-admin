import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useHelpersStore } from "./helpersStore";

export const useRolesStore = defineStore("roles", () => {
    const helpersStore = useHelpersStore();
    const { handleError } = helpersStore;

    const toast = useToast();
    const router = useRouter();

    const roles = ref([]);
    const rolesLoading = ref(false);

    const currentRole = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getRoles() {
        rolesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/roles`)
            .then((response) => {
                roles.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                rolesLoading.value = false;
            });
    }

    function createRole(roleData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(`${import.meta.env.VITE_API_BASE_URL}/role/create`, {
                roleData: roleData,
            })
            .then(() => {
                router.push("/roles");
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function getRole(id) {
        clearCurrentRole();
        rolesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/role/${id}`)
            .then((response) => {
                currentRole.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentRole.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                rolesLoading.value = false;
            });
    }

    function editRole(roleId, roleData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/role/${roleId}/update`,
                { roleData: roleData }
            )
            .then(() => {
                router.push(`/role/${roleId}`);
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function clearCurrentRole() {
        currentRole.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteRole(roleId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(`${import.meta.env.VITE_API_BASE_URL}/role/${roleId}/delete`)
            .then(() => {
                router.push(`/roles`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        roles,
        rolesLoading,
        currentRole,
        getRoles,
        createRole,
        getRole,
        editRole,
        deleteRole,
    };
});
