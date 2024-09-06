import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useHelpersStore } from "./helpersStore";

export const useManufacturersStore = defineStore("manufacturers", () => {
    const helpersStore = useHelpersStore();
    const { handleError } = helpersStore;

    const toast = useToast();
    const router = useRouter();

    const manufacturers = ref([]);
    const manufacturersLoading = ref(false);

    const currentManufacturer = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getManufacturers() {
        manufacturersLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/manufacturers`)
            .then((response) => {
                manufacturers.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                manufacturersLoading.value = false;
            });
    }

    function createManufacturer(manufacturerData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/manufacturer/create`,
                manufacturerData
            )
            .then(() => {
                router.push("/manufacturers");
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function getManufacturer(id) {
        manufacturersLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/manufacturer/${id}`)
            .then((response) => {
                currentManufacturer.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentManufacturer.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                manufacturersLoading.value = false;
            });
    }

    function editManufacturer(manufacturerId, manufacturerData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/manufacturer/${manufacturerId}/update`,
                manufacturerData
            )
            .then(() => {
                router.push(`/manufacturer/${manufacturerId}`);
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function clearCurrentManufacturer() {
        currentManufacturer.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteManufacturer(manufacturerId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/manufacturer/${manufacturerId}/delete`
            )
            .then(() => {
                router.push(`/manufacturers`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        manufacturers,
        manufacturersLoading,
        currentManufacturer,
        getManufacturers,
        createManufacturer,
        getManufacturer,
        editManufacturer,
        clearCurrentManufacturer,
        deleteManufacturer,
    };
});
