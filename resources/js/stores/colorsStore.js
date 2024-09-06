import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useHelpersStore } from "./helpersStore";

export const useColorsStore = defineStore("colors", () => {
    const helpersStore = useHelpersStore();
    const { handleError } = helpersStore;

    const toast = useToast();
    const router = useRouter();

    const colors = ref([]);
    const colorsLoading = ref(false);

    const currentColor = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getColors() {
        colorsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/colors`)
            .then((response) => {
                colors.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                colorsLoading.value = false;
            });
    }

    function createColor(colorData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/color/create`,
                colorData
            )
            .then(() => {
                router.push("/colors");
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function getColor(id) {
        colorsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/color/${id}`)
            .then((response) => {
                currentColor.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentColor.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                colorsLoading.value = false;
            });
    }

    function editColor(colorId, colorData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/color/${colorId}/update`,
                colorData
            )
            .then(() => {
                router.push(`/color/${colorId}`);
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function clearCurrentColor() {
        currentColor.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteColor(colorId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/color/${colorId}/delete`
            )
            .then(() => {
                router.push(`/colors`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        colors,
        colorsLoading,
        currentColor,
        getColors,
        createColor,
        getColor,
        editColor,
        clearCurrentColor,
        deleteColor,
    };
});
