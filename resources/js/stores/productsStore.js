import { defineStore, storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";

export const useProductsStore = defineStore("products", () => {
    const router = useRouter();
    const toast = useToast();

    const products = ref([]);
    const persist = ref(true);
    const currentProduct = ref({
        normalFormat: {},
        tableFormat: [],
    });
    const productsLoading = ref(false);

    function getProducts() {
        productsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/products`)
            .then((response) => {
                products.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                productsLoading.value = false;
            });
    }

    function createProduct(productData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/product/create`,
                productData
            )
            .then(() => {
                persist.value = false;
                router.push("/products");
            })
            .catch((error) => {
                if (
                    error.response &&
                    error.response.data &&
                    error.response.data.errors
                ) {
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

    function getProduct(id) {
        clearCurrentProduct();
        productsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/product/${id}`)
            .then((response) => {
                currentProduct.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentProduct.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                productsLoading.value = false;
            });
    }

    function clearCurrentProduct() {
        currentProduct.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function editProduct(productData, productId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/product/${productId}/update`,
                productData
            )
            .then(() => {
                localStorage.removeItem("editedProduct");
                router.push(`/product/${productId}`);
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

    function deleteProduct(productId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/product/${productId}/delete`
            )
            .then(() => {
                router.push(`/products`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        products,
        productsLoading,
        persist,
        getProducts,
        createProduct,
        getProduct,
        currentProduct,
        editProduct,
        deleteProduct,
    };
});
