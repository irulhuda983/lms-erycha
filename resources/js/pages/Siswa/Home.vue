<script setup>
import { ref, defineAsyncComponent, reactive, onMounted, watch } from 'vue'
import BannerHome from '@/components/BannerHome.vue'
import { useTesStore } from "@/stores/tes"
import { useRouter } from 'vue-router'

const userData = localStorage.getItem('USERSISWA') ? JSON.parse(localStorage.getItem('USERSISWA')) : {}

const router = useRouter()
const tesStore = useTesStore()

const cekIsRun = () => {
    if(tesStore.isRunningTest == 1) {
        router.push({ path: '/tes' })
    }
}

onMounted(() => {
    cekIsRun()
})
</script>


<template>
    <div class="w-full box-border overflow-x-hidden h-full pt-[80px] px-4">
        <div class="w-full box-border mb-4 lg:flex overflow-hidden mb-5">
            <div class="w-full lg:w-3/5 box-border lg:mr-5 mb-5 lg:mb-0">
                <BannerHome :user="userData" />
            </div>

            <div class="lg:w-2/5 h-full box-border overflow-hidden">
                <div class="w-full box-border grid grid-cols-2 grid-rows-2 gap-4">
                    <div class="w-full bg-[#7F83FF] h-[150px] rounded-[20px] box-border p-4">
                        <div class="rounded-full bg-white w-10 h-10 flex items-center justify-center mb-3">ic</div>
                        <div class="text-gray-800 font-semibold text-base mb-1">Desain Grafis</div>
                        <div class="w-full bg-white/50 box-border p-2 text-[10px] font-medium rounded-[7px] backdrop-blur-md">20 Dibaca</div>
                    </div>
                    <div class="w-full bg-[#93E674] h-[150px] rounded-[20px] box-border p-4">
                        <div class="rounded-full bg-white w-10 h-10 flex items-center justify-center mb-3">ic</div>
                        <div class="text-gray-800 font-semibold text-base mb-1">Desain Grafis</div>
                        <div class="w-full bg-white/50 box-border p-2 text-[10px] font-medium rounded-[7px] backdrop-blur-md">20 Dibaca</div>
                    </div>
                    <div class="w-full bg-[#FF808B] h-[150px] rounded-[20px] box-border p-4">
                        <div class="rounded-full bg-white w-10 h-10 flex items-center justify-center mb-3">ic</div>
                        <div class="text-gray-800 font-semibold text-base mb-1">Desain Grafis</div>
                        <div class="w-full bg-white/50 box-border p-2 text-[10px] font-medium rounded-[7px] backdrop-blur-md">20 Dibaca</div>
                    </div>
                    <div class="w-full bg-[#FFA880] h-[150px] rounded-[20px] box-border p-4">
                        <div class="rounded-full bg-white w-10 h-10 flex items-center justify-center mb-3">ic</div>
                        <div class="text-gray-800 font-semibold text-base mb-1">Desain Grafis</div>
                        <div class="w-full bg-white/50 box-border p-2 text-[10px] font-medium rounded-[7px] backdrop-blur-md">20 Dibaca</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full box-border lg:flex mb-24">
            <div class="w-full lg:w-2/5 box-border bg-white p-3 box-border rounded lg:mr-5 mb-5 lg:mb-0">
                <h1 class="text-base text-[#222222] font-semibold mb-4">Best Performens</h1>
                <div class="w-full box-border">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <td class="px-2 py-3">Rank</td>
                                <!-- <td>NIK</td> -->
                                <td class="px-2 py-3">Nama</td>
                                <td class="px-2 py-3">Point</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="i in 5" :key="i">
                               <td class="px-2 py-3 border-t">
                                    <div class="w-6 h-6 bg-[#FDD0D5] rounded-[4px] flex items-center justify-center text-white text-[12px]">{{ i }}</div>
                                </td>
                                <!-- <td>3522022611960003</td> -->
                                <td class="px-2 py-3 border-t">M. Khoirul Huda</td>
                                <td class="px-2 py-3 border-t font-semibold">80</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full lg:w-2/5 box-border bg-white p-3 box-border rounded lg:mr-5 mb-5 lg:mb-0">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-base text-[#222222] font-semibold">Materi Terbaru</h1>
                    <a href="">View All</a>
                </div>

                <div class="w-full box-border">
                    <div class="w-full rounded mb-3 p-3 flex bg-[#FDD0D5]">
                        <div class="w-12 h-12 bg-white flex-none rounded flex items-center justify-center mr-4">logo</div>
                        <div>
                            <p class="font-semibold">What is Photograpi design ?</p>
                            <p class="text-[12px]">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero, voluptatum.</p>
                        </div>
                    </div>
                    <div class="w-full rounded mb-3 p-3 flex bg-[#D0EAFB]">
                        <div class="w-12 h-12 bg-white flex-none rounded flex items-center justify-center mr-4">logo</div>
                        <div>
                            <p class="font-semibold">What is Photograpi design ?</p>
                            <p class="text-[12px]">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero, voluptatum.</p>
                        </div>
                    </div>
                    <div class="w-full rounded mb-3 p-3 flex bg-[#D0FCEB]">
                        <div class="w-12 h-12 bg-white flex-none rounded flex items-center justify-center mr-4">logo</div>
                        <div>
                            <p class="font-semibold">What is Photograpi design ?</p>
                            <p class="text-[12px]">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero, voluptatum.</p>
                        </div>
                    </div>
                    <div class="w-full rounded mb-3 p-3 flex bg-[#FEFDD1]">
                        <div class="w-12 h-12 bg-white flex-none rounded flex items-center justify-center mr-4">logo</div>
                        <div>
                            <p class="font-semibold">What is Photograpi design ?</p>
                            <p class="text-[12px]">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero, voluptatum.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/5 box-border mb-5 lg:mb-0">
                <div class="w-full rounded box-border py-3 px-3 bg-white">
                    <div class="mb-4 w-full flex items-center justify-between">
                        <h1 class="text-base text-[#222222] font-semibold">Kalender</h1>
                        <!-- <a href="">View All</a> -->
                    </div>
                    <div class="w-full flex items-center justify-center mb-5">
                        <div class="bg-[#7F83FF]/70 text-white rounded-[8px] w-20 h-20 font-bold flex items-center justify-center text-[42px]">
                            12
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-3">
                        <div v-for="i in 6" :key="i" class="bg-[#7F83FF]/20 h-6 w-6 flex items-center justify-center font-bold">{{ i }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>