<script setup>
import { ref } from "vue"
import { RouterView } from "vue-router"
import Navbar from "@/components/NavAdmin.vue"
import Sidebar from "@/components/SideAdmin.vue"
</script>


<template>
    <div class="w-full box-border overflow-hidden bg-[#F8F9FB]">
        <div class="w-full box-border h-[72px]">
            <Navbar />
        </div>
        <div class="w-full box-border overflow-hidden flex" style="height: calc(100vh - 72px)">
            <!-- w-48 -->
            <div class="flex-none">
                <Sidebar />
            </div>

            <div class="w-full flex-1 box-border overflow-x-hidden overflow-y-auto">
                <RouterView />
            </div>
        </div>
    </div>
</template>