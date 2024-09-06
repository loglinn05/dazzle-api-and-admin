import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useHelpersStore } from "./helpersStore";

export const useSubcategoriesStore = defineStore("subcategories", () => {
    const helpersStore = useHelpersStore();
    const { handleError } = helpersStore;

    const toast = useToast();
    const router = useRouter();

    const subcategories = ref([]);
    const subcategoriesLoading = ref(false);

    const currentSubcategory = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getSubcategories() {
        subcategoriesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/subcategories`)
            .then((response) => {
                subcategories.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                subcategoriesLoading.value = false;
            });
    }

    function getSubcategoriesOfCategory(categoryId) {
        subcategoriesLoading.value = true;
        axios
            .get(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/category/${categoryId}/subcategories`
            )
            .then((response) => {
                subcategories.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                subcategoriesLoading.value = false;
            });
    }

    function createSubcategory(subcategoryData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/subcategory/create`,
                subcategoryData
            )
            .then(() => {
                router.push("/subcategories");
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function getSubcategory(id) {
        subcategoriesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/subcategory/${id}`)
            .then((response) => {
                currentSubcategory.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentSubcategory.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                subcategoriesLoading.value = false;
            });
    }

    function editSubcategory(subcategoryId, subcategoryData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/subcategory/${subcategoryId}/update`,
                subcategoryData
            )
            .then(() => {
                router.push(`/subcategory/${subcategoryId}`);
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function clearCurrentSubcategory() {
        currentSubcategory.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteSubcategory(subcategoryId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/subcategory/${subcategoryId}/delete`
            )
            .then(() => {
                router.push(`/subcategories`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        subcategories,
        subcategoriesLoading,
        currentSubcategory,
        getSubcategories,
        getSubcategoriesOfCategory,
        createSubcategory,
        getSubcategory,
        editSubcategory,
        clearCurrentSubcategory,
        deleteSubcategory,
    };
});
