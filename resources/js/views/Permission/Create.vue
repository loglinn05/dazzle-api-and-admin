<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="All Permissions"
            class="p-0 mb-10"
            link
            @click="$router.push(`/permissions`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Add a permission
        </h1>
        <div class="grid gap-y-10">
            <FloatLabel>
                <InputText
                    id="name"
                    v-model="name"
                    @keydown.enter="gatherDataAndCreatePermission"
                />
                <label for="name">Name</label>
            </FloatLabel>
            <Button
                label="Add permission"
                class="w-fit"
                @click="gatherDataAndCreatePermission"
            />
        </div>
    </Layout>
</template>

<script setup>
import { ref } from "vue";
import { usePermissionsStore } from "../../stores/permissionsStore";

let permissionData = new FormData();

const name = ref("");

function gatherDataAndCreatePermission() {
    permissionData.append("name", name.value);
    createPermission(permissionData);
}

const permissionsStore = usePermissionsStore();
const { createPermission } = permissionsStore;
</script>
