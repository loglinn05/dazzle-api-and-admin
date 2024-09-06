<template>
    <Layout>
        <ConfirmPopup
            pt:content:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
        ></ConfirmPopup>
        <Button
            icon="pi pi-arrow-left"
            label="All Orders"
            class="p-0 mb-10"
            link
            @click="$router.push(`/orders`)"
        />
        <DataTable
            :value="currentOrder.tableFormat"
            class="mb-10"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            :pt="{ column: { bodycell: { class: 'align-top' } } }"
            :loading="ordersLoading"
            pt:loadingIcon:class="text-pink-500"
            showGridlines
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col items-center gap-3 w-full"
                >
                    <Button
                        v-if="hasPermissions(['update orders'])"
                        icon="pi pi-pencil"
                        label="Edit Order"
                        class="w-fit"
                        raised
                        @click="$router.push(`/order/${$route.params.id}/edit`)"
                    />
                    <Button
                        v-if="hasPermissions(['delete orders'])"
                        icon="pi pi-trash"
                        label="Delete Order"
                        class="w-fit"
                        raised
                        severity="danger"
                        @click="confirmDeletion($event)"
                    />
                </div>
            </template>
            <Column header="Property">
                <template #body="{ data }">
                    {{ toSentenceCase(data.key) }}
                </template>
            </Column>
            <Column header="Value">
                <template #body="{ data }">
                    <span v-if="data.key == 'total'">
                        {{ formatCurrency(data.value) }}
                    </span>
                    <span v-else-if="data.key != 'products'">{{
                        data.value
                    }}</span>
                </template>
            </Column>
        </DataTable>
        <h2 class="sm:text-3xl text-2xl text-pink-700 font-header mb-3">
            Products
        </h2>
        <DataTable
            :value="currentOrder.normalFormat.products"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
            :pt="{ column: { bodycell: { class: 'align-top' } } }"
            :loading="ordersLoading"
            pt:loadingIcon:class="text-pink-500"
            showGridlines
        >
            <Column header="ID" field="id"></Column>
            <Column header="Title" field="title">
                <template #body="{ data }">
                    <div class="min-w-60">
                        <router-link
                            :to="`/product/${data.id}`"
                            class="underline hover:text-pink-500 transition-all duration-500"
                        >
                            {{ data.title }}
                        </router-link>
                    </div>
                </template>
            </Column>
            <Column header="Price" field="price"></Column>
            <Column header="Quantity" field="quantity"></Column>
            <Column header="Subtotal">
                <template #body="{ data }">
                    {{ formatCurrency(data.price * data.quantity) }}
                </template>
            </Column>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onBeforeMount } from "vue";
import { useOrdersStore } from "../../stores/ordersStore";
import { useAuthStore } from "../../stores/authStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";
import { useHelpersStore } from "../../stores/helpersStore";
import { useConfirm } from "primevue/useconfirm";

const helpersStore = useHelpersStore();
const { toSentenceCase, formatCurrency } = helpersStore;

const route = useRoute();
const confirm = useConfirm();

const { hasPermissions } = useAuthStore();

const ordersStore = useOrdersStore();
const { currentOrder, ordersLoading } = storeToRefs(ordersStore);
const { getOrder, deleteOrder } = ordersStore;

onBeforeMount(() => {
    getOrder(route.params.id);
});

const confirmDeletion = (event) => {
    confirm.require({
        target: event.currentTarget,
        message: "Do you really want to delete this record?",
        icon: "pi pi-info-circle",
        rejectClass: "p-button-secondary p-button-outlined p-button-sm",
        acceptClass: "p-button-danger p-button-sm",
        rejectLabel: "Cancel",
        acceptLabel: "Delete",
        accept: () => {
            deleteOrder(route.params.id);
        },
        reject: () => {},
    });
};
</script>
