<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this permission"
            class="p-0 mb-10"
            link
            @click="$router.push(`/permission/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit permission
        </h1>
        <FadeTransition>
            <i
                v-if="permissionsLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="name"
                        v-model="currentPermission.normalFormat.name"
                        @keydown.enter="gatherDataAndEditPermission"
                    />
                    <label for="name">Name</label>
                </FloatLabel>
                <Button
                    label="Edit permission"
                    class="w-fit"
                    @click="gatherDataAndEditPermission"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { usePermissionsStore } from "../../stores/permissionsStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const permissionsStore = usePermissionsStore();
const { currentPermission, permissionsLoading } = storeToRefs(permissionsStore);
const { getPermission, editPermission } = permissionsStore;

const route = useRoute();

onBeforeMount(() => {
    getPermission(route.params.id);
});

let permissionData = new FormData();

function gatherDataAndEditPermission() {
    permissionData.append("name", currentPermission.value.normalFormat.name);
    editPermission(route.params.id, permissionData);
}
</script>
