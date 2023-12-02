<script setup>
import { ref, defineAsyncComponent, reactive, onMounted, watch, nextTick, onBeforeMount } from 'vue'
import { useRouter } from 'vue-router'
import { useTesStore } from "@/stores/tes"

import Header from '@/pages/Tes/Header.vue'
import CheckIcon from '@/components/icons/CheckIcon.vue'

const tesStore = useTesStore()
const router = useRouter()
const isOpenModal = ref(false)
const isOpenModalSelesai = ref(false)
const nomorSoal = ref(1)
const jawabanSoal = ref(null)
const isRagu = ref(false)
const soalTes = ref(null)
const listJawaban = ref([])
const jawaban = ref([
    {id: 'A', opt: 'A', text: 'Jawaban A'},
    {id: 'B', opt: 'B', text: 'Jawaban B'},
    {id: 'C', opt: 'C', text: 'Jawaban C'},
    {id: 'D', opt: 'D', text: 'Jawaban D'},
])

const countDown = ref(new Date('11/29/2023 14:00:00'))
const daysDisplay = ref(null)
const hoursDisplay = ref(null)
const minutesDisplay = ref(null)
const secondsDisplay = ref(null)

const ujianSiswa = reactive( JSON.parse(localStorage.getItem('ujianSiswa')) )

const getSoal = async () => {
    try{
        const { data } = await instanceSiswa({
            url: `/peserta/tes/${ujianSiswa.soal.id}/get-soal-item`,
            method: 'POST',
            data: { nomor_soal: nomorSoal.value }
        })

        const soal = data.data
        soalTes.value = soal
        jawaban.value = [
            {id: 'A', opt: 'A', text: soal.pil_a},
            {id: 'B', opt: 'B', text: soal.pil_b},
            {id: 'C', opt: 'C', text: soal.pil_c},
            {id: 'D', opt: 'D', text: soal.pil_d},
        ]
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKENSISWA')
            localStorage.removeItem('USERSISWA')

            tesStore.setRunningTest(null)
            tesStore.setDataTest(null)
            location.reload()
        }
        soalTes.value = null
    }
}

const getJawaban = async () => {
    try{
        const { data } = await instanceSiswa({
            url: `/peserta/tes/${ujianSiswa.id}/get-jawaban`,
            method: 'POST',
            data: { nomor_soal: nomorSoal.value }
        })

        const jawab = data.data

        jawabanSoal.value = jawab.jawaban
        isRagu.value = jawab.is_ragu
    }catch(e) {
        if(e.response.status == 404) {
            jawabanSoal.value = null
            isRagu.value = 0
        }
    }
}

const changeJawaban = async (val) => {
    jawabanSoal.value = val
    try{
        const payload = {
            id_soal: ujianSiswa.soal.id,
            id_soal_item: soalTes.value.id,
            is_ragu: isRagu.value ? 1 : 0,
            jawaban: val,
            kunci: soalTes.value.kunci_jawaban
        }

        const { data } = await instanceSiswa({
            url: `/peserta/tes/${ujianSiswa.id}/jawab-soal`,
            method: 'POST',
            data: payload
        })
    }catch(e){
        jawabanSoal.value = null
    }
}

const raguRagu = async () => {
    isRagu.value = !isRagu.value
    try{
        const payload = {
            id_soal: ujianSiswa.soal.id,
            id_soal_item: soalTes.value.id,
            is_ragu: isRagu.value ? 1 : 0,
            jawaban: jawabanSoal.value,
            kunci: soalTes.value.kunci_jawaban
        }

        const { data } = await instanceSiswa({
            url: `/peserta/tes/${ujianSiswa.id}/jawab-soal`,
            method: 'POST',
            data: payload
        })
    }catch(e){
        jawabanSoal.value = null
    }
}

const prevSoal = () => {
    if(nomorSoal.value <= 1) {
        return
    }else{
        nomorSoal.value -= 1
        getSoal()
        getJawaban()
    }
}

const nextSoal = () => {
    if(nomorSoal.value >= ujianSiswa.soal.jml_pg) {
        return
    }else{
        nomorSoal.value += 1
        getSoal()
        getJawaban()
    }
}

const changeNomorSoal = (i) => {
    nomorSoal.value = i
    getSoal()
    getJawaban()
    closeModalDaftar()
}

const showRemaining = setInterval(() => {
    const wAkhir = new Date(ujianSiswa.max_time)
    const _second = 1000,
    _minute = _second * 60,
    _hour = _minute * 60,
    _day = _hour * 24;

    var now = new Date();
    // var distance = countDown.value - now;
    var distance = wAkhir - now;
    if (distance < 0) {

        clearInterval();
        // document.getElementById('countdown').innerHTML = 'EXPIRED!';

        return;
    }
    var days = Math.floor(distance / _day);
    var hours = Math.floor((distance % _day) / _hour);
    var minutes = Math.floor((distance % _hour) / _minute);
    var seconds = Math.floor((distance % _minute) / _second);


    daysDisplay.value = days > 9 ? days : `0${days}`;
    hoursDisplay.value = hours > 9 ? hours : `0${hours}`;
    minutesDisplay.value = minutes > 9 ? minutes : `0${minutes}`;
    secondsDisplay.value = seconds > 9 ? seconds : `0${seconds}`;
}, 1000)


const openModalDaftar = async () => {
    try{
        const { data } = await instanceSiswa({
            url: `/peserta/tes/${ujianSiswa.id}/get-all-jawaban`,
            method: 'POST',
        })

        const dataList = data.data

        const list = []

        for(let i = 1; i <= parseInt(ujianSiswa.soal.jml_pg); i++) {
            let isjawab = dataList.find((item) => item.no_soal == i )

            if(isjawab) {
                list.push({
                    id: isjawab.id,
                    no: i,
                    is_ragu: isjawab.is_ragu,
                    is_jawab: isjawab.is_jawab,
                    jawaban: isjawab.jawaban,
                })
            }else{
                list.push({
                    id: null,
                    no: i,
                    is_ragu: 0,
                    is_jawab: 0,
                    jawaban: null,
                })
            }

        }

        listJawaban.value = list
    }catch(e){

    }finally{
        isOpenModal.value = true
    }
}

const closeModalDaftar = () => {
    listJawaban.value = []
    isOpenModal.value = false
}

const openModalSelesai = () => {
    isOpenModalSelesai.value = true
}

const closeModalSelesai = () => {
    isOpenModalSelesai.value = false
}

const cekIsRun = () => {
   if(tesStore.isRunningTest == 0) {
        router.push({ path: '/ujian' })
    }
}

const stopTes = async () => {
    // const { data } = await axios2.post(`/peserta/tes/${id}/selesai`, { jumlah_soal: jumlah })
    await tesStore.stopTest(ujianSiswa.id, ujianSiswa.soal.jml_pg)
    router.push('/ujian')
    // location.reload()
}

onBeforeMount(() => {
    cekIsRun()
})

onMounted(() => {
    if(tesStore.isRunningTest == 1) {
        getSoal()
        getJawaban()
        showRemaining
    }
})
</script>


<template>
    <div v-if="tesStore.isRunningTest == 1" class="w-screen h-screen box-border overflow-x-hidden overflow-y-auto relative bg-[#F2F2F2] text-[#424242] font-poppins text-[13px] relative">
        <Header />

        <div class="w-full relative box-border overflow-x-hidden oveflow-y-auto p-4 lg:p-8" style="height: calc(100vh - 60px)">

            <div class="w-full box-border rounded-[10px] shadow-2xl bg-white p-4">
                <!-- soal header -->
                <div class="w-full box-border flex items-center justify-between border-b border-gray-300 pb-3">
                    <div class="w-1/2 box-border">
                        <div class="text-base flex items-center justify-start">
                            <div class="mr-2">Soal Nomor</div>
                            <div class="font-bold text-[#7F83FF]">{{ nomorSoal }}</div>
                        </div>
                    </div>

                    <div class="w-1/2 box-border flex items-center justify-end">
                        <div class="rounded-[10px] lg:rounded-full px-4 py-1.5 text-xs border border-red-500 text-gray-600 mr-3 lg:mr-5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <div class="mr-2"><span class="hidden lg:inline">Siswa Waktu</span> :</div>

                            <div class="font-semibold">{{ hoursDisplay }}:{{ minutesDisplay }}:{{ secondsDisplay }}</div>
                        </div>

                        <button class="rounded-[10px] lg:rounded-full px-1.5 lg:px-4 py-1.5 text-xs bg-[#7F83FF] text-white flex items-center justify-center" @click.prevent="openModalDaftar()">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 lg:mr-2">
                                <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h2.25a3 3 0 013 3v2.25a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm9.75 0a3 3 0 013-3H18a3 3 0 013 3v2.25a3 3 0 01-3 3h-2.25a3 3 0 01-3-3V6zM3 15.75a3 3 0 013-3h2.25a3 3 0 013 3V18a3 3 0 01-3 3H6a3 3 0 01-3-3v-2.25zm9.75 0a3 3 0 013-3H18a3 3 0 013 3V18a3 3 0 01-3 3h-2.25a3 3 0 01-3-3v-2.25z" clip-rule="evenodd" />
                            </svg>

                            <div class="hidden lg:block">Daftar Soal</div>
                        </button>
                    </div>
                </div>

                <div class="w-full box-border border border-gray-300 mt-4 p-4 rounded">
                    <div v-if="soalTes != null" class="w-full box-border">
                        <div class="mb-8" v-html="soalTes?.text_soal"></div>
                        <div class="w-full box-border">
                            <div v-for="(item, i) in jawaban" :key="i" class="box-border flex items-start mb-5">
                                <button
                                    class="flex-none w-6 h-6 rounded-full border-2 flex items-center justify-center mr-3"
                                    :class="jawabanSoal == item.id ? 'border-blue-500 text-white bg-blue-500' : 'border-gray-300 text-gray-300 hover:border-blue-500 hover:text-blue-500'"
                                    @click.prevent="changeJawaban(item.id)"
                                >
                                    <div v-if="jawabanSoal == item.id" class="w-3.5 h-3.5"><CheckIcon /></div>
                                    <div v-else class="font-bold text-sm">{{ item.opt }}</div>
                                </button>

                                <div @click.prevent="changeJawaban(item.id)" class="cursor-pointer" v-html="item.text"></div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="w-full">
                        <p>Tidak ada soal yang dapat di tampilkan</p>
                    </div>
                </div>

                <div class="w-full box-border flex items-center justify-between box-border py-4 pt-8 px-0 lg:px-10">
                    <button @click.prevent="prevSoal()" class="px-4 py-2 rounded-lg lg:rounded-full lg:px-8 lg:py-2 flex items-center justify-center font-semibold text-red-600 bg-red-300 hover:bg-red-600 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-5 w-5 lg:w-3 lg:h-3 lg:mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>

                        <div class="hidden lg:block">Sebelumnya</div>
                    </button>

                    <button @click.prevent="raguRagu()" class="cursor-pointer px-4 py-2 rounded-lg lg:rounded-full lg:px-8 lg:py-2 flex items-center justify-center font-semibold text-orange-600 bg-orange-300 hover:bg-orange-600 hover:text-white">
                        <div class="w-4 h-4 mr-2 rounded flex items-center justify-center" :class="isRagu ? 'bg-blue-600' : 'bg-white'">
                            <div class="w-2.5 h-2.5 text-white"><CheckIcon /></div>
                        </div>

                        <!-- <input id="ragu" :value="0" type="checkbox" class="outline-none focus:ring-none mr-2"> -->
                        <div>Ragu-ragu</div>
                    </button>

                    <!-- <template> -->
                    <button
                        v-if="nomorSoal < ujianSiswa.soal.jml_pg"
                        @click.prevent="nextSoal()"
                        class="px-4 py-2 rounded-lg lg:rounded-full lg:px-8 lg:py-2 flex items-center justify-center font-semibold text-blue-600 bg-blue-300 hover:bg-blue-600 hover:text-white"
                    >
                        <div class="hidden lg:block mr-2">Selanjutnya</div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-5 w-5 lg:w-3 lg:h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>

                    <button v-else @click.prevent="openModalSelesai()" class="px-4 py-2 rounded-lg lg:rounded-full lg:px-8 lg:py-2 flex items-center justify-center font-semibold text-blue-600 bg-blue-300 hover:bg-blue-600 hover:text-white">
                        <div class="hidden lg:block mr-2">Selesai</div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-5 w-5 lg:w-3 lg:h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                    <!-- </template> -->
                </div>
                <!-- <h1>Tes</h1>
                <button @click.prevent="stopTes()">stop</button> -->
            </div>

        </div>
    </div>

    <!-- modal -->
    <div v-if="isOpenModal" class="w-screen h-screen absolute top-0 bg-blue-500/20 lg:flex lg:items-center lg:justify-center p-4 lg:p-0 backdrop-blur-lg">
        <div class="w-full lg:w-[700px] bg-white rounded overflow-x-hidden shadow-lg">
            <div class="bg-gray-200 px-4 py-3 flex items-center justify-between">
                <div class="font-semibold">Daftar Soal</div>
                <button class="text-gray-500 hover:text-red-500" @click.prevent="closeModalDaftar()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="w-full p-4 box-border">
                <div class="w-full box-border grid grid-cols-5 lg:grid-cols-10 gap-3">
                    <div v-for="(item, i) in listJawaban" :key="i" @click.prevent="changeNomorSoal(item.no)" class="cursor-pointer box-border flex items-center justify-center">
                        <div
                            class="w-14 h-14 rounded box-border border border-gray-400 flex items-center justify-center"
                            :class="[
                                nomorSoal == item.no ? 'bg-gray-400 text-white' : 'text-gray-400',
                                item.is_jawab == 1 ? 'bg-green-400 text-white' : '',
                                item.is_ragu == 1 ? 'bg-orange-400 text-white' : '',
                            ]"
                        >
                            <span class="font-semibold lg:text-lg">{{ item.no }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->

    <!-- modal selesai -->
    <div v-if="isOpenModalSelesai" class="w-screen h-screen absolute top-0 bg-blue-500/20 lg:flex lg:items-center lg:justify-center p-4 lg:p-0 backdrop-blur-lg">
        <div class="w-full lg:w-[480px] bg-white rounded overflow-x-hidden shadow-lg">
            <div class="bg-gray-200 px-4 py-3 flex items-center justify-between">
                <div class="font-semibold text-lg">Konfirmasi Selesai Tes</div>
                <!-- <button class="text-gray-500 hover:text-red-500" @click.prevent="closeModalSelesai()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button> -->
            </div>

            <div class="w-full p-4 box-border">
                <div class="w-full box-border">
                    <h1 class="mb-3">Apakah anda yakin ingin mengakhiri Tes ?</h1>

                    <p class="mb-6">Silahkan cek kembali jawaban anda dan tekan tombol <span class="font-bold text-green-500">Kembali</span> jika anda kurang yakin. Atau jika anda benar-benar yakin silahkan tekan tombol <span class="font-bold text-red-500">Selesai Tes</span> untuk mengakhiri tes.</p>

                    <div class="w-full flex items-center justify-center">
                        <button @click.prevent="stopTes()" class="px-4 py-2 rounded-lg lg:rounded-full lg:px-8 lg:py-2 flex items-center justify-center font-semibold text-white bg-red-500 hover:bg-red-800 mr-3">Selesai Tes</button>
                        <button @click.prevent="closeModalSelesai()" class="px-4 py-2 rounded-lg lg:rounded-full lg:px-8 lg:py-2 flex items-center justify-center font-semibold text-white bg-green-500 hover:bg-green-800">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal selesai -->
</template>