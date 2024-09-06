<template>
    <Layout>
        <div class="max-w-screen-2xl grid grid-cols-3 gap-20">
            <div class="col-span-3 grid grid-cols-3">
                <h1
                    class="col-span-3 sm:text-4xl text-3xl text-pink-700 font-header font-semibold mb-5"
                >
                    Revenue
                </h1>
                <div class="lg:col-span-2 col-span-3 max-lg:mb-10">
                    <MonthlyRevenue />
                </div>
                <div class="lg:col-span-1 col-span-3">
                    <RevenueByCategories />
                </div>
            </div>
            <div class="col-span-3">
                <RecentOrders />
            </div>
        </div>
    </Layout>
</template>

<script setup>
import MonthlyRevenue from "../components/page-components/Home/MonthlyRevenue.vue";
import RecentOrders from "../components/page-components/Home/RecentOrders.vue";
import RevenueByCategories from "../components/page-components/Home/RevenueByCategories.vue";
</script>
