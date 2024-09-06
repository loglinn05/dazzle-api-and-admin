<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Products"
            class="p-0 mb-10"
            link
            @click="$router.push(`/products`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a product
        </h1>
        <div class="w-fit grid gap-y-10">
            <div
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <FloatLabel>
                    <InputText
                        id="title"
                        v-model="product.title"
                        class="sm:w-96 w-64"
                    />
                    <label for="title">Title</label>
                </FloatLabel>
            </div>
            <div
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <FloatLabel>
                    <Textarea
                        id="description"
                        v-model="product.description"
                        class="sm:w-96 w-64 h-32"
                    />
                    <label for="title">Description</label>
                </FloatLabel>
            </div>
            <div
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <FloatLabel>
                    <InputText
                        id="contents"
                        v-model="product.contents"
                        class="sm:w-96 w-64"
                    />
                    <label for="contents">Contents</label>
                </FloatLabel>
            </div>
            <div
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <FloatLabel>
                    <InputNumber
                        id="price"
                        v-model="product.price"
                        inputId="currency-us"
                        mode="currency"
                        currency="USD"
                        locale="en-US"
                        fluid
                        class="sm:w-96 w-64"
                    />
                    <label for="price">Price</label>
                </FloatLabel>
            </div>
            <FloatLabel>
                <InputNumber
                    id="oldPrice"
                    v-model="product.old_price"
                    inputId="currency-us"
                    mode="currency"
                    currency="USD"
                    locale="en-US"
                    fluid
                    class="sm:w-96 w-64"
                />
                <label for="oldPrice">Old price</label>
            </FloatLabel>
            <div
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <FloatLabel>
                    <InputNumber
                        id="numInStock"
                        v-model="product.number_in_stock"
                        fluid
                        class="sm:w-96 w-64"
                    />
                    <label for="numInStock">Number in stock</label>
                </FloatLabel>
            </div>
            <div
                class="flex items-center after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <InputSwitch id="featured" v-model="product.featured" />
                <label
                    for="featured"
                    class="ms-2 sm:text-lg text-base font-text text-violet-700"
                >
                    Featured
                </label>
            </div>
            <div class="flex flex-col gap-10">
                <div
                    class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
                >
                    <FileUpload
                        mode="basic"
                        customUpload
                        :auto="true"
                        @uploader="imageUploader"
                        :multiple="true"
                        accept="image/*"
                        id="images"
                    />
                </div>
                <FadeTransition>
                    <div
                        v-if="imageURLs.length > 0"
                        class="flex flex-nowrap md:max-w-96 max-w-64 gap-5 items-stretch overflow-x-auto"
                    >
                        <div
                            v-for="imageURL in imageURLs"
                            class="relative w-16 h-28 shrink-0"
                        >
                            <img
                                :src="imageURL.URL"
                                class="absolute w-full h-full object-cover object-center"
                            />
                            <button
                                class="absolute top-0 right-0 border-none w-6 h-6 flex justify-center items-center bg-black/60 text-white"
                                @click="removeImage(imageURL.imageId)"
                            >
                                <span class="pi pi-times text-xs"></span>
                            </button>
                        </div>
                    </div>
                </FadeTransition>
            </div>
            <div
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <Dropdown
                    v-model="product.category"
                    :options="categories"
                    optionLabel="title"
                    :placeholder="
                        categoriesLoading ? 'Loading...' : 'Select a category'
                    "
                    :loading="categoriesLoading"
                    @change="clearOnCategoryChange()"
                    class="sm:w-96 w-64"
                />
            </div>
            <div
                v-if="product.category"
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <Dropdown
                    v-model="product.subcategory"
                    :options="subcategories"
                    optionLabel="title"
                    :placeholder="
                        subcategoriesLoading
                            ? 'Loading...'
                            : 'Select a subcategory'
                    "
                    :loading="subcategoriesLoading"
                    @change="getTypesOfSubcategory(product.subcategory.id)"
                    class="sm:w-96 w-64"
                />
            </div>
            <div
                v-if="product.subcategory"
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <Dropdown
                    v-model="product.type"
                    :options="types"
                    optionLabel="title"
                    filter
                    :placeholder="typesLoading ? 'Loading...' : 'Select a type'"
                    :loading="typesLoading"
                    class="sm:w-96 w-64"
                />
            </div>
            <div
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <Dropdown
                    v-model="product.manufacturer"
                    :options="manufacturers"
                    optionLabel="name"
                    filter
                    :placeholder="
                        manufacturersLoading
                            ? 'Loading...'
                            : 'Select a manufacturer'
                    "
                    :loading="manufacturersLoading"
                    class="sm:w-96 w-64"
                />
            </div>
            <div
                v-if="product.category && product.category.id != 3"
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <MultiSelect
                    v-model="product.sizes"
                    display="chip"
                    :options="sizes"
                    optionLabel="title"
                    :placeholder="sizesLoading ? 'Loading...' : 'Select sizes'"
                    :loading="sizesLoading"
                    :maxSelectedLabels="3"
                    class="sm:w-96 w-64"
                />
            </div>
            <div
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <MultiSelect
                    v-model="product.colors"
                    :options="colors"
                    optionLabel="code"
                    :placeholder="
                        colorsLoading ? 'Loading...' : 'Select colors'
                    "
                    :loading="colorsLoading"
                    display="chip"
                    class="sm:w-96 w-64"
                    :pt="colorSelectPassThrough"
                >
                    <template #chip="slotProps">
                        <div
                            class="p-2 rounded-full"
                            :style="`background-color: ${slotProps.value.code}`"
                        ></div>
                    </template>
                    <template #option="slotProps">
                        <div
                            class="p-3 rounded"
                            :style="`background-color: ${slotProps.option.code}`"
                        ></div>
                    </template>
                </MultiSelect>
            </div>
            <div
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <MultiSelect
                    v-model="product.materials"
                    display="chip"
                    filter
                    :options="materials"
                    optionLabel="title"
                    :placeholder="
                        materialsLoading ? 'Loading...' : 'Select materials'
                    "
                    :loading="materialsLoading"
                    :maxSelectedLabels="3"
                    class="sm:w-96 w-64"
                />
            </div>
            <div
                v-if="product.category && product.category.id != 3"
                class="flex after:content-['*'] after:ml-0.5 after:text-red-500"
            >
                <MultiSelect
                    v-model="product.seasons"
                    display="chip"
                    :options="seasons"
                    optionLabel="title"
                    :placeholder="
                        seasonsLoading ? 'Loading...' : 'Select seasons'
                    "
                    :loading="seasonsLoading"
                    :maxSelectedLabels="3"
                    class="sm:w-96 w-64"
                />
            </div>
            <Button
                label="Add product"
                class="w-fit"
                @click="gatherDataAndCreateProduct"
            />
        </div>
    </Layout>
</template>

<script setup>
import { ref, onBeforeMount, watch, onBeforeUnmount } from "vue";
import InputSwitch from "primevue/inputswitch";
import FileUpload from "primevue/fileupload";
import MultiSelect from "primevue/multiselect";
import InputNumber from "primevue/inputnumber";
import Textarea from "primevue/textarea";
import { useProductsStore } from "../../stores/productsStore";
import { useCategoriesStore } from "../../stores/categoriesStore";
import { useSubcategoriesStore } from "../../stores/subcategoriesStore";
import { useTypesStore } from "../../stores/typesStore.js";
import { useManufacturersStore } from "../../stores/manufacturersStore.js";
import { useSizesStore } from "../../stores/sizesStore.js";
import { useColorsStore } from "../../stores/colorsStore.js";
import { useMaterialsStore } from "../../stores/materialsStore.js";
import { useSeasonsStore } from "../../stores/seasonsStore.js";
import { useToast } from "primevue/usetoast";
import { storeToRefs } from "pinia";

const toast = useToast();

const colorSelectPassThrough = {
    panel: {
        class: "p-3",
    },
    header: {
        class: "p-0 mb-3",
    },
    list: {
        class: "sm:w-[22rem] w-64 flex flex-row flex-wrap gap-3",
    },
    item: {
        class: "relative flex justify-center items-center p-0 m-0",
    },
    itemCheckbox: {
        root: {
            class: "absolute top-0 left-0 w-full h-full",
        },
        box: {
            class: "w-full h-full bg-transparent border-0",
        },
    },
};

let productData = new FormData();

const product = ref({
    title: "",
    description: "",
    contents: "",
    images: [],
    price: null,
    old_price: null,
    number_in_stock: null,
    featured: false,
    category: null,
    subcategory: null,
    type: null,
    manufacturer: null,
    sizes: [],
    colors: [],
    materials: [],
    seasons: [],
});

const productsStore = useProductsStore();
const { persist } = storeToRefs(productsStore);
const { createProduct } = productsStore;

const categoriesStore = useCategoriesStore();
const { categories, categoriesLoading } = storeToRefs(categoriesStore);
const { getCategories } = categoriesStore;

const subcategoriesStore = useSubcategoriesStore();
const { subcategories, subcategoriesLoading } = storeToRefs(subcategoriesStore);
const { getSubcategoriesOfCategory } = subcategoriesStore;

const typesStore = useTypesStore();
const { types, typesLoading } = storeToRefs(typesStore);
const { getTypesOfSubcategory } = typesStore;

const manufacturersStore = useManufacturersStore();
const { manufacturers, manufacturersLoading } = storeToRefs(manufacturersStore);
const { getManufacturers } = manufacturersStore;

const sizesStore = useSizesStore();
const { sizes, sizesLoading } = storeToRefs(sizesStore);
const { getSizesOfCategory } = sizesStore;

const colorsStore = useColorsStore();
const { colors, colorsLoading } = storeToRefs(colorsStore);
const { getColors } = colorsStore;

const materialsStore = useMaterialsStore();
const { materials, materialsLoading } = storeToRefs(materialsStore);
const { getMaterials } = materialsStore;

const seasonsStore = useSeasonsStore();
const { seasons, seasonsLoading } = storeToRefs(seasonsStore);
const { getSeasons } = seasonsStore;

const imageURLs = ref([]);

function imageUploader(event) {
    for (let file of event.files) {
        if (product.value.images.length < 10) {
            product.value.images.push({
                id: product.value.images.length,
                file: file,
            });
            imageURLs.value.push({
                URL: URL.createObjectURL(file),
                imageId: product.value.images.length - 1,
            });
        } else {
            toast.add({
                severity: "error",
                summary:
                    "Uploading more than 10 product images is not allowed.",
                life: 5000,
            });
            break;
        }
    }
}

function removeImage(imageId) {
    product.value.images = product.value.images.filter((image) => {
        return image.id != imageId;
    });
    imageURLs.value = imageURLs.value.filter((imageURL) => {
        return imageURL.imageId != imageId;
    });
}

function gatherDataAndCreateProduct() {
    for (let image of product.value.images) {
        productData.append("images[]", image.file);
    }
    let productWithoutImages = (({ images, ...rest }) => rest)(product.value);
    for (const key in productWithoutImages) {
        if (Array.isArray(productWithoutImages[key])) {
            productWithoutImages[key].forEach((el) => {
                productData.append(`${key}[]`, el.id);
            });
        } else if (
            typeof productWithoutImages[key] === "object" &&
            productWithoutImages[key] !== null
        ) {
            productData.append(key, productWithoutImages[key].id);
        } else if (typeof productWithoutImages[key] === "boolean") {
            productData.append(key, productWithoutImages[key] ? "1" : "0");
        } else {
            if (productWithoutImages[key] == null) {
                productData.append(key, "");
            } else {
                productData.append(key, productWithoutImages[key]);
            }
        }
    }
    for (var pair of productData.entries()) {
        console.log(pair[0] + ", " + pair[1]);
    }
    createProduct(productData);
    productData = new FormData();
}

onBeforeMount(() => {
    if (localStorage.getItem("createdProduct")) {
        product.value = JSON.parse(localStorage.getItem("createdProduct"));
    }
    getCategories();
    getManufacturers();
    getColors();
    getMaterials();
});

const unwatch = watch(
    product,
    (value) => {
        if (value.category && value.category.id) {
            getSubcategoriesOfCategory(value.category.id);
            getSizesOfCategory(value.category.id);
        }
        if (value.subcategory && value.subcategory.id) {
            getTypesOfSubcategory(value.subcategory.id);
        }
        unwatch();
    },
    { deep: true }
);

function persistProduct() {
    if (persist.value) {
        product.value.images = [];
        localStorage.setItem("createdProduct", JSON.stringify(product.value));
    }
}

function clearOnCategoryChange() {
    product.value.subcategory = null;
    product.value.type = null;
    product.value.sizes = [];
    types.value = [];
    sizes.value = [];
    getSubcategoriesOfCategory(product.value.category.id);
    getSizesOfCategory(product.value.category.id);
    if (product.value.category.id != 3) {
        getSeasons();
    } else {
        product.value.seasons = [];
    }
}

onBeforeUnmount(() => {
    persistProduct();
});
window.onbeforeunload = function () {
    persistProduct();
};
</script>
