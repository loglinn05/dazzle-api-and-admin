import { useRouter } from "vue-router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useToast } from "primevue/usetoast";

export const useSeasonsStore = defineStore("seasons", () => {
    const router = useRouter();
    const toast = useToast();

    const seasons = ref([]);
    const seasonsLoading = ref(false);

    const currentSeason = ref({
        normalFormat: {},
        tableFormat: [],
    });

    function getSeasons() {
        seasonsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/seasons`)
            .then((response) => {
                seasons.value = response.data;
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                seasonsLoading.value = false;
            });
    }

    function createSeason(seasonData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/season/create`,
                seasonData
            )
            .then(() => {
                router.push("/seasons");
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    for (let key in error.response.data.errors) {
                        error.response.data.errors[key].forEach((error) => {
                            toast.add({
                                severity: "error",
                                summary: error,
                                life: 5000,
                            });
                        });
                    }
                } else {
                    console.error(error);
                }
            });
    }

    function getSeason(id) {
        seasonsLoading.value = true;
        axios
            .get(`${import.meta.env.VITE_API_BASE_URL}/season/${id}`)
            .then((response) => {
                currentSeason.value.normalFormat = response.data;
                for (const key in response.data) {
                    currentSeason.value.tableFormat.push({
                        key: key,
                        value: response.data[key],
                    });
                }
            })
            .catch((error) => {
                console.error(error);
            })
            .finally(() => {
                seasonsLoading.value = false;
            });
    }

    function editSeason(seasonId, seasonData) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${
                    import.meta.env.VITE_API_BASE_URL
                }/season/${seasonId}/update`,
                seasonData
            )
            .then(() => {
                router.push(`/season/${seasonId}`);
            })
            .catch((error) => {
                if (error.response.data.errors) {
                    for (let key in error.response.data.errors) {
                        error.response.data.errors[key].forEach((error) => {
                            toast.add({
                                severity: "error",
                                summary: error,
                                life: 5000,
                            });
                        });
                    }
                } else {
                    console.error(error);
                }
            });
    }

    function clearCurrentSeason() {
        currentSeason.value = {
            normalFormat: {},
            tableFormat: [],
        };
    }

    function deleteSeason(seasonId) {
        toast.add({
            severity: "info",
            summary: "Wait a minute...",
            life: 3000,
        });
        axios
            .post(
                `${import.meta.env.VITE_API_BASE_URL}/season/${seasonId}/delete`
            )
            .then(() => {
                router.push(`/seasons`);
            })
            .catch((error) => {
                console.error(error);
            });
    }

    return {
        seasons,
        seasonsLoading,
        currentSeason,
        getSeasons,
        createSeason,
        getSeason,
        editSeason,
        clearCurrentSeason,
        deleteSeason,
    };
});
