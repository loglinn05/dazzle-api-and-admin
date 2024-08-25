<template>
    <Layout>
        <ConfirmPopup
            pt:content:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_*]:text-violet-700"
        ></ConfirmPopup>
        <Button
            icon="pi pi-arrow-left"
            label="All Products"
            class="p-0 mb-10"
            link
            @click="$router.push(`/products`)"
        />
        <DataTable
            :value="currentProduct.tableFormat"
            pt:wrapper:class="[&_*]:sm:text-lg [&_*]:text-base [&_*]:font-text [&_th]:text-violet-700 [&_td]:text-violet-700"
            :pt="{ column: { bodycell: { class: 'align-top' } } }"
            :loading="productsLoading"
            pt:loadingIcon:class="text-pink-500"
            showGridlines
        >
            <template #header>
                <div
                    class="flex sm:flex-row flex-col items-center gap-3 w-full"
                >
                    <Button
                        v-if="
                            hasPermissions([
                                'update products and product features',
                            ])
                        "
                        icon="pi pi-pencil"
                        label="Edit Product"
                        class="w-fit"
                        raised
                        @click="
                            $router.push(`/product/${$route.params.id}/edit`)
                        "
                    />
                    <Button
                        v-if="
                            hasPermissions([
                                'delete products and product features',
                            ])
                        "
                        icon="pi pi-trash"
                        label="Delete Product"
                        class="w-fit"
                        raised
                        severity="danger"
                        @click="confirmDeletion($event)"
                    />
                </div>
            </template>
            <Column field="key" header="Property">
                <template #body="{ data }">
                    <div class="flex grow items-start">
                        {{ toSentenceCase(data.key) }}
                    </div>
                </template>
            </Column>
            <Column field="value" header="Value">
                <template #body="{ data }">
                    <div
                        v-if="Array.isArray(data.value)"
                        :class="`${
                            data.key == 'images'
                                ? 'grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1'
                                : 'flex' +
                                  (data.key == 'colors' ? '' : ' flex-col')
                        } gap-3`"
                    >
                        <template v-if="data.key == 'images'">
                            <Image
                                v-for="item of data.value"
                                :src="item.file_path"
                                preview
                            />
                        </template>
                        <template v-else-if="data.key == 'colors'">
                            <span
                                v-for="item of data.value"
                                class="p-5"
                                :style="`background-color: ${item.code}`"
                            ></span>
                        </template>
                        <template v-else>
                            <div v-for="item of data.value">
                                {{ item.title }}
                            </div>
                        </template>
                    </div>
                    <span v-else-if="isObject(data.value)">
                        {{ data.value.title ?? data.value.name }}
                    </span>
                    <span v-else>
                        {{
                            data.key == "price" || data.key == "old_price"
                                ? formatCurrency(data.value)
                                : data.value
                        }}
                    </span>
                </template>
            </Column>
        </DataTable>
    </Layout>
</template>

<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "../../stores/authStore";
import { useProductsStore } from "../../stores/productsStore";
import { onBeforeMount } from "vue";
import { useRoute } from "vue-router";
import Image from "primevue/image";
import { toSentenceCase, formatCurrency, isObject } from "../../helpers";
import { useConfirm } from "primevue/useconfirm";

const { hasPermissions } = useAuthStore();

const route = useRoute();
const confirm = useConfirm();

const productsStore = useProductsStore();
const { currentProduct, productsLoading } = storeToRefs(productsStore);
const { getProduct, deleteProduct } = productsStore;

onBeforeMount(() => {
    getProduct(route.params.id);
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
            deleteProduct(route.params.id);
        },
        reject: () => {},
    });
};
</script>
