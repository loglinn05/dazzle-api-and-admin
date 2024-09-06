<template>
    <h2 class="sm:text-3xl text-2xl text-pink-700 font-header text-center mb-3">
        By categories
    </h2>
    <div class="flex justify-center">
        <Chart
            type="pie"
            :data="chartData"
            :options="chartOptions"
            class="h-52"
        />
    </div>
</template>

<script setup>
import axios from "axios";
import Chart from "primevue/chart";
import { ref, onMounted } from "vue";

onMounted(() => {
    setChartData();
    chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref();

const setChartData = () => {
    axios
        .get(`${import.meta.env.VITE_API_BASE_URL}/revenue-by-categories`)
        .then((response) => {
            chartData.value = response.data;
        })
        .catch((error) => {
            console.error(error);
        });
};

const setChartOptions = () => {
    return {
        plugins: {
            legend: {
                display: false,
            },
        },
    };
};
</script>
