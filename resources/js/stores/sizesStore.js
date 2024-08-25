import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";

export const useSizesStore = defineStore("sizes", () => {
    const router = useRouter();
    const toast = useToast();

    const sizes = ref([]);
    const sizesLoading = ref(false);

    const currentSize = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getSizes() {
        sizesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/sizes`)
            .then((response) => {
                sizes.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                sizesLoading.value = false;
            });
    }

    function getSizesOfCategory(categoryId) {
        sizesLoading.value = true;
        axios
            .get(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/category/${categoryId}/sizes`
            )
            .then((response) => {
                sizes.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                sizesLoading.value = false;
            });
    }

    function createSize(sizeData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(`${import.meta.env.VITE_API_BASE_URL}/size/create`, sizeData)
            .then(() => {
                router.push("/sizes");
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

    function getSize(id) {
        sizesLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/size/${id}`)
            .then((response) => {
                currentSize.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentSize.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                sizesLoading.value = false;
            });
    }

    function editSize(sizeId, sizeData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/size/${sizeId}/update`,
                sizeData
            )
            .then(() => {
                router.push(`/size/${sizeId}`);
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

    function clearCurrentSize() {
        currentSize.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteSize(sizeId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(`${import.meta.env.VITE_API_BASE_URL}/size/${sizeId}/delete`)
            .then(() => {
                router.push(`/sizes`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        sizes,
        sizesLoading,
        currentSize,
        getSizes,
        getSizesOfCategory,
        createSize,
        getSize,
        editSize,
        clearCurrentSize,
        deleteSize,
    };
});
