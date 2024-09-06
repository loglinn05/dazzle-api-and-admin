<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this order"
            class="p-0 mb-10"
            link
            @click="$router.push(`/order/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit order
        </h1>
        <FadeTransition>
            <i
                v-if="ordersLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="name"
                        v-model="currentOrder.normalFormat.name"
                        class="sm:w-96 w-64"
                    />
                    <label for="name">Name</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText
                        id="email"
                        type="email"
                        v-model="currentOrder.normalFormat.email"
                        class="sm:w-96 w-64"
                    />
                    <label for="email">Email</label>
                </FloatLabel>
                <FloatLabel>
                    <InputText
                        id="shippingAddress"
                        v-model="currentOrder.normalFormat.shipping_address"
                        class="sm:w-96 w-64"
                    />
                    <label for="shippingAddress">Shipping address</label>
                </FloatLabel>
                <FloatLabel>
                    <InputNumber
                        id="price"
                        v-model="currentOrder.normalFormat.total"
                        inputId="currency-us"
                        mode="currency"
                        currency="USD"
                        locale="en-US"
                        fluid
                        class="sm:w-96 w-64"
                    />
                    <label for="total">Total</label>
                </FloatLabel>
                <Dropdown
                    v-model="currentOrder.normalFormat.status"
                    :options="orderStatuses"
                    placeholder="Select status"
                    class="sm:w-96 w-64"
                />
                <Dropdown
                    v-model="currentOrder.normalFormat.user_id"
                    :options="users"
                    optionLabel="name"
                    optionValue="id"
                    :placeholder="usersLoading ? 'Loading...' : 'Select a user'"
                    :loading="usersLoading"
                    class="sm:w-96 w-64"
                />
                <Button
                    label="Edit order"
                    class="w-fit"
                    @click="
                        editOrder($route.params.id, currentOrder.normalFormat)
                    "
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, ref } from "vue";
import { useUsersStore } from "../../stores/usersStore";
import { useOrdersStore } from "../../stores/ordersStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import InputNumber from "primevue/inputnumber";

const usersStore = useUsersStore();
const { users, usersLoading } = storeToRefs(usersStore);
const { getUsers } = usersStore;

const ordersStore = useOrdersStore();
const { currentOrder, ordersLoading } = storeToRefs(ordersStore);
const { getOrder, editOrder } = ordersStore;

const orderStatuses = ref([
    "pending",
    "paid",
    "processing",
    "shipped",
    "delivered",
    "cancelled",
    "returned",
]);

const route = useRoute();

onBeforeMount(() => {
    getOrder(route.params.id);
    getUsers();
});
</script>
