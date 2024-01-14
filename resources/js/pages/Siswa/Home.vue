<script setup>
import { ref, defineAsyncComponent, reactive, onMounted, watch } from 'vue'
import MateriIcon from '@/assets/img/materi_icon.png'
import LmsIcon from '@/assets/img/lms_icon.jpg'
import BannerHome from '@/components/BannerHome.vue'
import { useTesStore } from "@/stores/tes"
import { useRouter } from 'vue-router'

const userData = localStorage.getItem('USERSISWA') ? JSON.parse(localStorage.getItem('USERSISWA')) : {}

const router = useRouter()
const tesStore = useTesStore()
const popularMateri = ref([])
const latestMateri = ref([])
const nilaiTertinggi = ref([])
const bgList = ref(['bg-[#7F83FF]', 'bg-[#93E674]', 'bg-[#FF808B]', 'bg-[#FFA880]'])
const bgListMateri = ref(['bg-[#FDD0D5]', 'bg-[#D0EAFB]', 'bg-[#D0FCEB]', 'bg-[#FEFDD1]'])

const cekIsRun = () => {
    if(tesStore.isRunningTest == 1) {
        router.push({ path: '/tes' })
    }else{
        fetchPopularmateri()
        fetchNilaiTertinggi()
    }
}

const fetchPopularmateri = async () => {
    try{
        const { data } = await instanceSiswa({
            url: 'peserta/dashboard/popular-materi',
            method: 'GET',
        })

        const items = data.data
        latestMateri.value = items.slice(0,4)

        const sorted = items.sort((a, b) => b.jumlah_dibaca - a.jumlah_dibaca);
        popularMateri.value = sorted.slice(0,4)
    }catch(e){
        if(e.response.status == 401) {
            localStorage.removeItem('TOKENSISWA')
            localStorage.removeItem('USERSISWA')
            location.reload()
        }
    }
}

const fetchNilaiTertinggi = async () => {
    try{
        const { data } = await instanceSiswa({
            url: 'peserta/dashboard/nilai-tertinggi',
            method: 'GET',
        })

        const items = data.data

        const sorted = items.sort((a, b) => b.total - a.total);
        nilaiTertinggi.value = sorted.slice(0,10)

    }catch(e){
        if(e.response.status == 401) {
            localStorage.removeItem('TOKENSISWA')
            localStorage.removeItem('USERSISWA')
            location.reload()
        }
    }
}

const limitCar = (string = '', limit = 0) => {
    return string.substring(0, limit)
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
                    <div v-for="(item, i) in popularMateri" :key="i" class="w-full h-[150px] rounded-[20px] box-border p-4" :class="bgList[i]">
                        <div class="rounded-full bg-white w-10 h-10 flex items-center justify-center mb-3 overflow-hidden">
                            <img :src="LmsIcon" alt="" class="w-6">
                        </div>
                        <div class="text-gray-800 font-semibold text-sm lg:text-base mb-1">{{ limitCar(item.judul, 18) }}</div>
                        <div class="w-full bg-white/50 box-border px-2 py-1 lg:px-2 py-2 text-[10px] font-medium rounded-[7px] backdrop-blur-md">{{ item.jumlah_dibaca }} Kali Dibaca</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full box-border lg:flex mb-24">
            <div class="w-full lg:w-2/5 box-border bg-white p-3 box-border rounded lg:mr-5 mb-5 lg:mb-0">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-base text-[#222222] font-semibold">Hasil Ujian Tertinggi</h1>
                    <!-- <button @click.prevent="router.push({ name: 'siswaHasilUjian' })" class="text-gray-600 bg-gray-100 rounded px-3 py-1 text-xs hover:text-white hover:bg-green-400">View All</button> -->
                </div>
                <div class="w-full box-border">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <td class="px-2 py-3 w-[80px] border-b">Rank</td>
                                <!-- <td>NIK</td> -->
                                <td class="px-2 py-3 border-b">Nama</td>
                                <td class="px-2 py-3 border-b w-[20px] text-end">Point</td>
                            </tr>
                        </thead>

                        <tbody v-if="nilaiTertinggi.length != 0">
                            <tr v-for="(item, i) in nilaiTertinggi" :key="i">
                               <td class="px-2 py-3 border-b">
                                    <div class="w-6 h-6 bg-[#FDD0D5] rounded-[4px] flex items-center justify-center text-white text-[12px]">{{ i+1 }}</div>
                                </td>
                                <!-- <td>3522022611960003</td> -->
                                <td class="px-2 py-3 border-b">
                                    <div>{{ item.siswa.nama }}</div>
                                    <div class="text-[8px] text-gray-500">{{ item.siswa.nik ?? '-' }}</div>
                                </td>
                                <td class="px-2 py-3 border-b font-semibold w-[20px] text-end">{{ item.total }}</td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                               <td class="px-2 py-3 border-b text-center italic" colspan="3">
                                    Belum ada hasil ujian
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-full lg:w-2/5 box-border bg-white p-3 box-border rounded lg:mr-5 mb-5 lg:mb-0">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-base text-[#222222] font-semibold">Materi Terbaru</h1>
                    <button @click.prevent="router.push({ name: 'siswaMateri' })" class="text-gray-600 bg-gray-100 rounded px-3 py-1 text-xs hover:text-white hover:bg-green-400">View All</button>
                </div>

                <div v-if="latestMateri.length != 0" class="w-full box-border">
                    <div v-for="(item, i) in latestMateri" :key="i" @click.prevent="router.push({ name: 'siswaDetailMateri', params: { id: item.id} })" class="cursor-pointer w-full rounded mb-3 p-3 flex" :class="bgListMateri[i]">
                        <div class="w-12 h-12 bg-white flex-none rounded flex items-center justify-center mr-4">
                            <img :src="MateriIcon" alt="" class="w-12">
                        </div>
                        <div>
                            <p class="font-semibold">{{ item.judul }}</p>
                            <p class="text-[12px]">{{ item.excerpt }}</p>
                        </div>
                    </div>
                </div>
                <div v-else class="w-full box-border flex items-center justify-center h-full w-full">
                    <p class="text-center italic">Belum Ada materi</p>
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