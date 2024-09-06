<template>
    <Layout>
        <DataTable
            :value="orders"
            :loading="ordersLoading"
            pt:loadingIcon:class="text-pink-500"
            :pt:footer:class="orders && orders.length > 0 ? '' : 'hidden'"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            showGridlines
            scrollable
        >
            <template #header>
                <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                    Orders
                </h1>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no orders in the database.
                </p>
            </template>
            <Column header="Name">
                <template #body="{ data }">
                    <router-link
                        :to="`/order/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.name }}
                    </router-link>
                </template>
            </Column>
            <Column header="Email" field="email"></Column>
            <Column header="Total">
                <template #body="{ data }">
                    {{ formatCurrency(data.total) }}
                </template>
            </Column>
            <Column header="Status" field="status"></Column>
            <template #footer>
                <p
                    v-if="orders && orders.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ orders.length }} orders.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useOrdersStore } from "../../stores/ordersStore";
import { useHelpersStore } from "../../stores/helpersStore";
import { storeToRefs } from "pinia";

const helpersStore = useHelpersStore();
const { formatCurrency } = helpersStore;

const ordersStore = useOrdersStore();
const { orders, ordersLoading } = storeToRefs(ordersStore);
const { getOrders } = ordersStore;

onMounted(() => {
    getOrders();
});
</script>
