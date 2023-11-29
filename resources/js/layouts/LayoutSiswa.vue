<script setup>
import { ref } from "vue"
import { RouterView } from "vue-router"
import Navbar from "@/components/NavSiswa.vue"
import Sidebar from "@/components/SideSiswa.vue"
</script>


<template>
    <div class="w-screen h-screen box-border overflow-x-hidden overflow-y-auto flex justufy-between relative bg-[#F2F2F2] text-[#424242] font-poppins text-[13px]">
        <div class="w-full lg:w-[240px] lg:h-full fixed lg:relative bottom-0 box-border overflow-x-hidden flex-none z-10">
            <Sidebar />
        </div>

        <div class="relative w-full h-screen overflow-x-hidden overflow-y-auto flex-1">
            <Navbar />
            <RouterView />
        </div>
    </div>
</template>