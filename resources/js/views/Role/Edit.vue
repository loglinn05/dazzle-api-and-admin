<template>
    <Layout>
        <Button
            icon="pi pi-arrow-left"
            label="Show this role"
            class="p-0 mb-10"
            link
            @click="$router.push(`/role/${$route.params.id}`)"
        />
        <h1 class="sm:text-4xl text-3xl text-pink-700 font-header pb-10">
            Edit role
        </h1>
        <FadeTransition>
            <i
                v-if="rolesLoading"
                class="pi pi-spin pi-spinner text-pink-500"
                style="font-size: 2rem"
            ></i>
            <div v-else class="grid gap-y-10">
                <FloatLabel>
                    <InputText
                        id="name"
                        v-model="currentRole.normalFormat.name"
                        @keydown.enter="gatherDataAndEditRole"
                    />
                    <label for="name">Name</label>
                </FloatLabel>
                <Button
                    label="Edit role"
                    class="w-fit"
                    @click="gatherDataAndEditRole"
                />
            </div>
        </FadeTransition>
    </Layout>
</template>

<script setup>
import { onBeforeMount, onBeforeUnmount } from "vue";
import { useRolesStore } from "../../stores/rolesStore";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const rolesStore = useRolesStore();
const { currentRole, rolesLoading } = storeToRefs(rolesStore);
const { getRole, editRole } = rolesStore;

const route = useRoute();

onBeforeMount(() => {
    getRole(route.params.id);
});

let roleData = new FormData();

function gatherDataAndEditRole() {
    roleData.append("name", currentRole.value.normalFormat.name);
    editRole(route.params.id, roleData);
}
</script>
