import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { SidenavMenuService } from "@/services/sidenavMenuService";

export const useSidenavStore = defineStore("sidenav", () => {
    const router = useRouter();

    const sidenavVisible = ref(false);

    function showSidenav() {
        sidenavVisible.value = true;
    }

    function hideSidenav() {
        sidenavVisible.value = false;
    }

    function toggleSidenav() {
        if (sidenavVisible.value) {
            hideSidenav();
        } else {
            showSidenav();
        }
    }

    const sidenavNodes = ref(null);

    function getSidenavNodes() {
        SidenavMenuService.getTreeNodes().then(
            (data) => (sidenavNodes.value = data)
        );
    }

    function navigateToNodeRoute(node) {
        if (node.route != undefined) {
            router.push(node.route);
            hideSidenav();
        }
    }

    return {
        sidenavVisible,
        showSidenav,
        hideSidenav,
        toggleSidenav,
        sidenavNodes,
        getSidenavNodes,
        navigateToNodeRoute,
    };
});
