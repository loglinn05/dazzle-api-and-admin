import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useHelpersStore } from "./helpersStore";

export const useMaterialsStore = defineStore("materials", () => {
    const helpersStore = useHelpersStore();
    const { handleError } = helpersStore;

    const toast = useToast();
    const router = useRouter();

    const materials = ref([]);
    const materialsLoading = ref(false);

    const currentMaterial = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getMaterials() {
        materialsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/materials`)
            .then((response) => {
                materials.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                materialsLoading.value = false;
            });
    }

    function createMaterial(materialData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/material/create`,
                materialData
            )
            .then(() => {
                router.push("/materials");
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function getMaterial(id) {
        materialsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/material/${id}`)
            .then((response) => {
                currentMaterial.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentMaterial.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                materialsLoading.value = false;
            });
    }

    function editMaterial(materialId, materialData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/material/${materialId}/update`,
                materialData
            )
            .then(() => {
                router.push(`/material/${materialId}`);
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function clearCurrentMaterial() {
        currentMaterial.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteMaterial(materialId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/material/${materialId}/delete`
            )
            .then(() => {
                router.push(`/materials`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        materials,
        materialsLoading,
        currentMaterial,
        getMaterials,
        createMaterial,
        getMaterial,
        editMaterial,
        clearCurrentMaterial,
        deleteMaterial,
    };
});
