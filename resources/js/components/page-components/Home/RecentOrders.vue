<template>
    <DataTable
        :value="recentOrders"
        :loading="ordersLoading"
        pt:loadingIcon:class="text-pink-500"
        :pt:footer:class="
            recentOrders && recentOrders.length > 0 ? '' : 'hidden'
        "
        pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
        showGridlines
        scrollable
    >
        <template #header>
            <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                Recent orders
            </h1>
        </template>
        <template #empty>
            <p class="sm:text-lg text-base font-text text-violet-700">
                There are no orders in the database.
            </p>
        </template>
        <Column header="Name">
            <template #body="{ data }">
                <div class="min-w-60">
                    <router-link
                        :to="`/order/${data.id}`"
                        class="underline hover:text-pink-500 transition-all duration-500"
                    >
                        {{ data.name }}
                    </router-link>
                </div>
            </template>
        </Column>
        <Column header="Email" field="email"></Column>
        <Column header="Total">
            <template #body="{ data }">
                {{ formatCurrency(data.total) }}
            </template>
        </Column>
        <Column header="Status" field="status"></Column>
        <Column header="Created at">
            <template #body="{ data }">
                <div class="min-w-60">
                    {{ data.created_at }}
                </div>
            </template>
        </Column>
    </DataTable>
</template>

<script setup>
import { onMounted } from "vue";
import { useOrdersStore } from "../../../stores/ordersStore";
import { useHelpersStore } from "../../../stores/helpersStore";
import { storeToRefs } from "pinia";

const helpersStore = useHelpersStore();
const { formatCurrency } = helpersStore;

const ordersStore = useOrdersStore();
const { recentOrders, ordersLoading } = storeToRefs(ordersStore);
const { getRecentOrders } = ordersStore;

onMounted(() => {
    getRecentOrders();
});
</script>
