<script setup>
import { ref, reactive, onMounted } from 'vue'
import MateriIcon from '@/assets/img/materi_icon.png'
import VueApexCharts from "vue3-apexcharts";
import { useRouter } from 'vue-router'

const router = useRouter()
const total = ref(null)
const latestMateri = ref([])
const bgListMateri = ref(['bg-[#FDD0D5]', 'bg-[#D0EAFB]', 'bg-[#D0FCEB]', 'bg-[#FEFDD1]'])

const isLoadingChart = ref(false)
const isLoadingMateri = ref(false)

const chartOptions = reactive({
    chart: {
        id: "vuechart-example",
        height: 200,
        zoom: { enabled: false },
        toolbar: { show: false },
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
            animateGradually: {
                enabled: true,
                delay: 150
            },
            dynamicAnimation: {
                enabled: true,
                speed: 350
            }
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    fill: {
        opacity: 1
    },
    xaxis: {
        categories: [],
    },
});

const series = ref([])

const getInitials = (name) => {
  return name.match(/(\b\S)?/g).join("");
}

const fetchDataChart = async () => {
    try{
        isLoadingChart.value = true
        const { data } = await instanceAdmin({
            url: '/admin/dashboard/data-chart',
            method: 'GET',
        })

        const items = data
        chartOptions.xaxis.categories = items.label.map(item => { return getInitials(item) })
        series.value = items.data
    }catch(e){
        console.log(e)
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally {
        isLoadingChart.value = false
    }
}

const fetchTotal = async () => {
    try{
        const { data } = await instanceAdmin({
            url: '/admin/dashboard/jumlah',
            method: 'GET',
        })

        const items = data
        total.value = items
    }catch(e){
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }
}

const fetchLatestMateri = async () => {
    isLoadingMateri.value = true
    try{
        const { data } = await instanceAdmin({
            url: '/admin/dashboard/popular-materi',
            method: 'GET',
        })

        const items = data.data
        latestMateri.value = items.slice(0,4)
    }catch(e){
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally {
        isLoadingMateri.value = false
    }
}

onMounted(() => {
    fetchDataChart()
    fetchTotal()
    fetchLatestMateri()
})

</script>


<template>
    <div class="w-full box-border p-5">
        <div v-if="total" class="w-full box-border flex items-center justify-center mb-10">
            <div class="w-1/4 box-border bg-[#4E36E2] text-white mr-5 rounded-[10px] flex items-center justify-between px-4 py-8">
                <div>
                    <div class="w-14 h-14 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" viewBox="0 0 24 24" data-name="Layer 1" class="w-full h-full fill-current"><path d="m24 8.48v11.52a1 1 0 0 1 -2 0v-8.248l-7.4 3.536a5 5 0 0 1 -2.577.694 5.272 5.272 0 0 1 -2.7-.739l-7.38-3.513a3.691 3.691 0 0 1 -.084-6.455c.027-.016.056-.031.084-.045l7.457-3.558a5.226 5.226 0 0 1 5.282.045l7.375 3.513a3.767 3.767 0 0 1 1.943 3.25zm-11.978 9.5a7.26 7.26 0 0 1 -3.645-.972l-4.377-2.089v2.7a5.007 5.007 0 0 0 3.519 4.778 15.557 15.557 0 0 0 4.481.603 15.557 15.557 0 0 0 4.481-.607 5.007 5.007 0 0 0 3.519-4.778v-2.691l-4.459 2.13a6.983 6.983 0 0 1 -3.519.928z"/></svg>
                    </div>
                </div>
                <div class="text-end">
                    <div class="font-semibold">Jumlah Peserta</div>
                    <div class="text-5xl font-bold">{{ total?.peserta }}</div>
                </div>
            </div>

            <div class="w-1/4 box-border bg-[#48A9F8] text-white mr-5 rounded-[10px] flex items-center justify-between px-4 py-8">
                <div>
                    <div class="w-14 h-14 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" class="w-full h-full fill-current"><path d="m18,12c-3.314,0-6,2.686-6,6s2.686,6,6,6,6-2.686,6-6-2.686-6-6-6Zm3.192,6.202l-2.213,2.124c-.452.446-1.052.671-1.653.671s-1.203-.225-1.663-.674l-1.132-1.109c-.395-.387-.4-1.02-.014-1.414.386-.396,1.019-.401,1.414-.014l1.131,1.108c.144.142.379.139.522-.002l2.223-2.134c.397-.382,1.031-.371,1.414.029.382.398.369,1.031-.029,1.414Zm-11.192-.202c0-2.39,1.048-4.534,2.709-6h-7.709c-.553,0-1-.447-1-1s.447-1,1-1h8c.553,0,1,.447,1,1,0,.024-.001.048-.003.072,1.177-.682,2.544-1.072,4.003-1.072v-5c0-2.757-2.243-5-5-5H5C2.243,0,0,2.243,0,5v14c0,2.757,2.243,5,5,5h7.709c-1.661-1.466-2.709-3.61-2.709-6ZM5,5h8c.553,0,1,.447,1,1s-.447,1-1,1H5c-.553,0-1-.447-1-1s.447-1,1-1Zm2,12h-2c-.553,0-1-.447-1-1s.447-1,1-1h2c.553,0,1,.447,1,1s-.447,1-1,1Z"/></svg>
                    </div>
                </div>
                <div class="text-end">
                    <div class="font-semibold">Jumlah Materi</div>
                    <div class="text-5xl font-bold">{{ total?.materi }}</div>
                </div>
            </div>

            <div class="w-1/4 box-border bg-[#1BD084] text-white mr-5 rounded-[10px] flex items-center justify-between px-4 py-8">
                <div>
                    <div class="w-14 h-14 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" class="w-full h-full fill-current"><path d="m12,7V.46c.913.346,1.753.879,2.465,1.59l3.484,3.486c.712.711,1.245,1.551,1.591,2.464h-6.54c-.552,0-1-.449-1-1Zm1.27,12.48c-.813.813-1.27,1.915-1.27,3.065v1.455h1.455c1.15,0,2.252-.457,3.065-1.27l6.807-6.807c.897-.897.897-2.353,0-3.25-.897-.897-2.353-.897-3.25,0l-6.807,6.807Zm-3.27,3.065c0-1.692.659-3.283,1.855-4.479l6.807-6.807c.389-.389.842-.688,1.331-.901-.004-.12-.009-.239-.017-.359h-6.976c-1.654,0-3-1.346-3-3V.024c-.161-.011-.322-.024-.485-.024h-4.515C2.243,0,0,2.243,0,5v14c0,2.757,2.243,5,5,5h5v-1.455Z"/></svg>
                    </div>
                </div>
                <div class="text-end">
                    <div class="font-semibold">Jumlah Soal</div>
                    <div class="text-5xl font-bold">{{ total?.soal }}</div>
                </div>
            </div>

            <div class="w-1/4 box-border bg-[#8BC740] text-white mr-5 rounded-[10px] flex items-center justify-between px-4 py-8">
                <div>
                    <div class="w-14 h-14 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" class="w-full h-full fill-current">
                            <path d="m12,12c-3.309,0-6-2.691-6-6S8.691,0,12,0s6,2.691,6,6-2.691,6-6,6Zm-2.667,2h-1.333c-2.757,0-5,2.243-5,5v5h7l1.385-6.923-2.051-3.077Zm6.667,0h-1.333l-2.051,3.077,1.385,6.923h7v-5c0-2.757-2.243-5-5-5Z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-end">
                    <div class="font-semibold">Jumlah Pengajar</div>
                    <div class="text-5xl font-bold">{{ total?.guru }}</div>
                </div>
            </div>

        </div>

        <div class="w-full flex box-border">
            <div v-if="isLoadingChart == false" class="w-3/5 box-border bg-white rounded-[10px] lg:rounded-[10px] p-4 lg:p-7 mr-5">
                <h1 class="text-[#112650] font-medium text-sm lg:text-base mb-3">Grafik Nilai</h1>

                <div class="w-full flex flex-col lg:flex-row items-center justify-center flex-col-reverse">
                    <div class="w-full mb-2 lg:mb-0">
                        <VueApexCharts type="bar" height="350" :options="chartOptions" :series="series" />
                    </div>
                </div>
            </div>

            <div v-if="isLoadingMateri == false" class="w-full lg:w-2/5 box-border bg-white p-3 box-border mb-5 lg:mb-0 rounded-[10px] lg:rounded-[10px]">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-base text-[#222222] font-semibold">Materi Terbaru</h1>
                    <button @click.prevent="router.push({ name: 'materi' })" class="text-gray-600 bg-gray-100 rounded px-3 py-1 text-xs hover:text-white hover:bg-green-400">View All</button>
                </div>

                <div v-if="latestMateri.length != 0" class="w-full box-border">
                    <div v-for="(item, i) in latestMateri" :key="i" class="cursor-pointer w-full rounded mb-3 p-3 flex" :class="bgListMateri[i]">
                        <div class="w-12 h-12 bg-white flex-none rounded flex items-center justify-center mr-4">
                            <img :src="MateriIcon" alt="" class="w-12">
                        </div>
                        <div>
                            <p class="font-semibold">coba materi</p>
                            <p class="text-[12px]">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eos, facilis.</p>
                        </div>
                    </div>
                </div>
                <div v-else class="w-full box-border flex items-center justify-center h-full w-full">
                    <p class="text-center italic">Belum Ada materi</p>
                </div>
            </div>
        </div>
    </div>
</template>