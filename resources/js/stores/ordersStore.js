import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useHelpersStore } from "./helpersStore";

export const useOrdersStore = defineStore("orders", () => {
    const helpersStore = useHelpersStore();
    const { handleError } = helpersStore;

    const router = useRouter();
    const toast = useToast();

    const orders = ref([]);
    const recentOrders = ref([]);
    const ordersLoading = ref(false);

    const currentOrder = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getOrders() {
        ordersLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/orders`)
            .then((response) => {
                orders.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                ordersLoading.value = false;
            });
    }

    function getRecentOrders() {
        ordersLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/orders/recent`)
            .then((response) => {
                recentOrders.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                ordersLoading.value = false;
            });
    }

    function getOrder(id) {
        clearCurrentOrder();
        ordersLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/order/${id}`)
            .then((response) => {
                currentOrder.value.normalFormat = response.data;
                for (const key in response.data) {
                    if (key != "products") {
                        currentOrder.value.tableFormat.push({
                            key: key,
                            value: response.data[key],
                        });
                    }
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                ordersLoading.value = false;
            });
    }

    function editOrder(orderId, orderData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/order/${orderId}/update`,
                { orderData: orderData }
            )
            .then(() => {
                router.push(`/order/${orderId}`);
            })
            .catch((error) => {
                handleError(error);
            });
    }

    function clearCurrentOrder() {
        currentOrder.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteOrder(orderId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/order/${orderId}/delete`
            )
            .then(() => {
                router.push(`/orders`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        orders,
        recentOrders,
        ordersLoading,
        currentOrder,
        getOrders,
        getRecentOrders,
        getOrder,
        editOrder,
        deleteOrder,
    };
});
