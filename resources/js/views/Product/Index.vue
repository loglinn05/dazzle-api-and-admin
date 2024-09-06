<template>
    <Layout>
        <DataTable
            :value="products"
            :loading="productsLoading"
            class="w-full overflow-auto"
            pt:loadingIcon:class="text-pink-500"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_th]:text-violet-700 [&_td]:text-violet-700"
            :pt:footer:class="products && products.length > 0 ? '' : 'hidden'"
            showGridlines
            scrollable
            scrollHeight="flex"
        >
            <template #header>
                <div class="flex flex-wrap items-center justify-between gap-5">
                    <h1 class="sm:text-4xl text-3xl text-pink-700 font-header">
                        Products
                    </h1>
                    <Button
                        v-if="
                            hasPermissions([
                                'create products and product features',
                            ])
                        "
                        icon="pi pi-plus"
                        label="Add Product"
                        raised
                        @click="$router.push('/product/create')"
                    />
                </div>
            </template>
            <template #empty>
                <p class="sm:text-lg text-base font-text text-violet-700">
                    There are no products in the database.
                </p>
            </template>
            <Column header="Title">
                <template #body="slotProps">
                    <div class="min-w-60">
                        <router-link
                            :to="`/product/${slotProps.data.id}`"
                            class="underline text-violet-700 hover:text-pink-500 transition-all duration-500"
                        >
                            {{ slotProps.data.title }}
                        </router-link>
                    </div>
                </template>
            </Column>
            <Column header="Image">
                <template #body="slotProps">
                    <img
                        :src="slotProps.data.images[0].file_path"
                        class="w-24 min-w-24 rounded shrink-0"
                    />
                </template>
            </Column>
            <Column header="Price">
                <template #body="slotProps">
                    {{ formatCurrency(slotProps.data.price) }}
                </template>
            </Column>
            <Column header="Old price">
                <template #body="slotProps">
                    {{
                        slotProps.data.old_price
                            ? formatCurrency(slotProps.data.old_price)
                            : "—"
                    }}
                </template>
            </Column>
            <Column header="Category">
                <template #body="slotProps">
                    {{ slotProps.data.category.title }}
                </template>
            </Column>
            <Column header="Status">
                <template #body="slotProps">
                    <Tag
                        :value="
                            getInventoryStatus(slotProps.data.number_in_stock)
                        "
                        :severity="getSeverity(slotProps.data.number_in_stock)"
                    />
                </template>
            </Column>
            <template #footer>
                <p
                    v-if="products && products.length > 0"
                    class="sm:text-lg text-base font-text text-violet-700"
                >
                    In total there are
                    {{ products.length }} products.
                </p>
            </template>
        </DataTable>
    </Layout>
</template>

<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../../stores/authStore";
import { useProductsStore } from "../../stores/productsStore";
import { storeToRefs } from "pinia";
import Tag from "primevue/tag";
import { useHelpersStore } from "../../stores/helpersStore";

const helpersStore = useHelpersStore();
const { formatCurrency } = helpersStore;

const { hasPermissions } = useAuthStore();

const productsStore = useProductsStore();
const { products, productsLoading } = storeToRefs(productsStore);
const { getProducts } = productsStore;

onMounted(() => {
    getProducts();
});

const getInventoryStatus = (numInStock) => {
    if (numInStock == 0) {
        return "OUTOFSTOCK";
    } else if (numInStock < 100) {
        return "LOWSTOCK";
    } else {
        return "INSTOCK";
    }
};

const getSeverity = (numInStock) => {
    if (numInStock == 0) {
        return "danger";
    } else if (numInStock < 100) {
        return "warning";
    } else {
        return "success";
    }
};
</script>
