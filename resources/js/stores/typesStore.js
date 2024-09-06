import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useHelpersStore } from "./helpersStore";

export const useTypesStore = defineStore("types", () => {
    const helpersStore = useHelpersStore();
    const { handleError } = helpersStore;

    const toast = useToast();
    const router = useRouter();

    const types = ref([]);
    const typesLoading = ref(false);

    const currentType = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getTypes() {
        typesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/types`)
            .then((response) => {
                types.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                typesLoading.value = false;
            });
    }

    function getTypesOfSubcategory(subcategoryId) {
        typesLoading.value = true;
        axios
            .get(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/subcategory/${subcategoryId}/types`
            )
            .then((response) => {
                types.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                typesLoading.value = false;
            });
    }

    function createType(typeData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(`${import.meta.env.VITE_API_BASE_URL}/type/create`, typeData)
            .then(() => {
                router.push("/types");
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function getType(id) {
        typesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/type/${id}`)
            .then((response) => {
                currentType.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentType.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                typesLoading.value = false;
            });
    }

    function editType(typeId, typeData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/type/${typeId}/update`,
                typeData
            )
            .then(() => {
                router.push(`/type/${typeId}`);
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function clearCurrentType() {
        currentType.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteType(typeId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(`${import.meta.env.VITE_API_BASE_URL}/type/${typeId}/delete`)
            .then(() => {
                router.push(`/types`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        types,
        typesLoading,
        currentType,
        getTypes,
        getTypesOfSubcategory,
        createType,
        getType,
        editType,
        clearCurrentType,
        deleteType,
    };
});
