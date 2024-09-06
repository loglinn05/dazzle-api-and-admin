<template>
    <h2 class="sm:text-3xl text-2xl text-pink-700 font-header text-center mb-3">
        This month
    </h2>
    <Chart
        type="line"
        :data="chartData"
        :options="chartOptions"
        class="sm:h-40 h-32"
    />
</template>

<script setup>
import axios from "axios";
import Chart from "primevue/chart";
import { ref, onMounted } from "vue";

onMounted(() => {
    setChartData();
    chartOptions.value = setChartOptions();
});

const chartData = ref([]);
const chartOptions = ref([]);

const setChartData = () => {
    axios
        .get(`${import.meta.env.VITE_API_BASE_URL}/monthly-revenue`)
        .then((response) => {
            chartData.value = response.data;
        });
};

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColorSecondary = documentStyle.getPropertyValue(
        "--text-color-secondary"
    );
    const surfaceBorder = documentStyle.getPropertyValue("--surface-border");

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.6,
        plugins: {
            legend: {
                display: false,
            },
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary,
                },
                grid: {
                    color: surfaceBorder,
                },
            },
            y: {
                beginAtZero: true,
                suggestedMax: 100,
                ticks: {
                    color: textColorSecondary,
                },
                grid: {
                    color: surfaceBorder,
                },
            },
        },
    };
};
</script>
