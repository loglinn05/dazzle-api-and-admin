import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useHelpersStore } from "./helpersStore";

export const useCategoriesStore = defineStore("categories", () => {
    const helpersStore = useHelpersStore();
    const { handleError } = helpersStore;

    const toast = useToast();
    const router = useRouter();

    const categories = ref([]);
    const categoriesLoading = ref(false);

    const currentCategory = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getCategories() {
        categoriesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/categories`)
            .then((response) => {
                categories.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                categoriesLoading.value = false;
            });
    }

    function createCategory(categoryData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/category/create`,
                categoryData
            )
            .then(() => {
                router.push("/categories");
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function getCategory(id) {
        categoriesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/category/${id}`)
            .then((response) => {
                currentCategory.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentCategory.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                categoriesLoading.value = false;
            });
    }

    function editCategory(categoryId, categoryData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/category/${categoryId}/update`,
                categoryData
            )
            .then(() => {
                router.push(`/category/${categoryId}`);
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function clearCurrentCategory() {
        currentCategory.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteCategory(categoryId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/category/${categoryId}/delete`
            )
            .then(() => {
                router.push(`/categories`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        categories,
        categoriesLoading,
        currentCategory,
        getCategories,
        createCategory,
        getCategory,
        editCategory,
        clearCurrentCategory,
        deleteCategory,
    };
});
