import { storeToRefs } from "pinia";
import { useAuthStore } from "../stores/authStore";

export default () => {
    const authStore = useAuthStore();
    const { currentUser } = storeToRefs(authStore);

    if (!currentUser.value.loggedIn || !currentUser.value.token) {
        return { name: "login" };
    } else {
        return true;
    }
};
