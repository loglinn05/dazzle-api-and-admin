import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores/authStore";

export default () => {
    const authStore = useAuthStore();
    const { currentUser } = storeToRefs(authStore);

    if (
        !currentUser.value.roles.includes("super admin") &&
        !currentUser.value.roles.includes("admin") &&
        !currentUser.value.roles.includes("staff")
    ) {
        return { name: "access denied" };
    } else {
        return true;
    }
};
