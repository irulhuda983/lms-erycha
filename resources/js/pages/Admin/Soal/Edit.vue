<script setup>

import { ref, reactive, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import loader from '@/assets/gif/loader.gif'
import { useNotification } from "@kyvg/vue3-notification"

const router = useRouter()
const route = useRoute()
const { notify } = useNotification()
const optKelas = ref([])
const optMapel = ref([])
const optRombel = ref([])
const optGuru = ref([])

const isLoading = ref(false)
const isLoadingSave = ref(false)

const payload = reactive({
    id_mapel: '',
    id_guru: '',
    id_kelas: '',
    id_rombel: '',
    kode: '',
    tipe_mapel_soal: '',
    tipe_soal: '',
    nama: '',
    jml_pg: '',
    jml_essay: '',
    bobot_pg: '',
    bobot_essay: '',
    jml_pil_essay: '',
    kkm: '',
    is_agama: 0,
    is_active: '',
})

const errors = reactive({
    id_mapel: null,
    id_guru: null,
    id_kelas: null,
    id_rombel: null,
    kode: null,
    tipe_mapel_soal: null,
    tipe_soal: null,
    nama: null,
    jml_pg: null,
    jml_essay: null,
    bobot_pg: null,
    bobot_essay: null,
    jml_pil_essay: null,
    kkm: null,
    is_agama: null,
    is_active: null,
})

const getOptKelas = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/opt/kelas`,
            method: 'GET',
        })
        optKelas.value = data.data
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else {
            notify({
                text: "Faliled to add, Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }
}

const getOptMapel = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/opt/mapel`,
            method: 'GET',
        })
        optMapel.value = data.data
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else {
            notify({
                text: "Faliled to add, Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }
}

const getOptRombel = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/opt/rombel`,
            method: 'GET',
        })
        optRombel.value = data.data
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else {
            notify({
                text: "Faliled to add, Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }
}

const getOptGuru = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/opt/guru`,
            method: 'GET',
        })
        optGuru.value = data.data
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else {
            notify({
                text: "Faliled to add, Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }
}

const fetchData = async () => {
    isLoading.value = true
    try{
        const { data } = await instanceAdmin({
            url: `/admin/soal/${route.params.id}/detail`,
            method: 'GET',
        })
        const soal = data.data

        payload.id_mapel = soal.id_mapel
        payload.id_guru = soal.id_guru
        payload.id_kelas = soal.id_kelas
        payload.id_rombel = soal.id_rombel
        payload.tipe_soal = soal.tipe_soal
        payload.nama = soal.nama
        payload.jml_pg = soal.jml_pg
        payload.jml_essay = soal.jml_essay
        payload.bobot_pg = soal.bobot_pg
        payload.bobot_essay = soal.bobot_essay
        payload.kkm = soal.kkm
        payload.is_agama = soal.is_agama
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally {
        isLoading.value = false
    }
}

const storeData = () => {
    console.log('ok')
    router.push({ name: 'detailSoal', params: { id: route.params.id } })
}

onMounted(() => {
    getOptKelas()
    getOptGuru()
    getOptMapel()
    getOptRombel()
    fetchData()
})

</script>


<template>
    <div class="w-full box-border p-5">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Edit Soal</h2>
            </div>

            <div class="w-full p-6 box-border bg-white">
                <div class="w-full flex flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-2/3">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul / Nama Soal</label>
                        <textarea id="nama" v-model="payload.nama" rows="1"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border focus:ring-blue-500 focus:border-blue-500 " placeholder="Soal Matematika X ..."
                            :class="errors.nama ? 'border-red-400':'border-gray-300'"
                            @focus="errors.nama = null"
                        ></textarea>
                        <div v-if="errors.nama" class="text-red-500 italic text-xs mt-1">{{ errors.nama }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="kkm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">KKM</label>
                        <input v-model="payload.kkm" type="number" id="kkm"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.kkm ? 'border-red-400':'border-gray-300'"
                            @focus="errors.kkm = null"
                            >
                        <div v-if="errors.kkm" class="text-red-500 italic text-xs mt-1">{{ errors.kkm }}</div>
                    </div>
                </div>

                <div class="w-full flex flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-1/3">
                        <label for="kelas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                        <select id="kelas" v-model="payload.id_kelas"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.id_kelas ? 'border-red-400':'border-gray-300'"
                            @focus="errors.id_kelas = null"
                        >
                            <option value="">Pilih Kelas</option>
                            <option v-for="(item, i) in optKelas" :key="i" :value="item.id">{{ item.text }}</option>
                        </select>
                        <div v-if="errors.id_kelas" class="text-red-500 italic text-xs mt-1">{{ errors.id_kelas }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="mapel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata Pelajaran</label>
                        <select id="mapel" v-model="payload.id_mapel"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.id_mapel ? 'border-red-400':'border-gray-300'"
                            @focus="errors.id_mapel = null"
                        >
                            <option value="">Pilih Mapel</option>
                            <option v-for="(item, i) in optMapel" :key="i" :value="item.id">{{ item.text }}</option>
                        </select>
                        <div v-if="errors.id_mapel" class="text-red-500 italic text-xs mt-1">{{ errors.id_mapel }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="guru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guru Pengampu</label>
                        <select id="guru" v-model="payload.id_guru"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.id_guru ? 'border-red-400':'border-gray-300'"
                            @focus="errors.id_guru = null"
                        >
                            <option value="">Pilih Guru</option>
                            <option v-for="(item, i) in optGuru" :key="i" :value="item.id">{{ item.text }}</option>
                        </select>
                        <div v-if="errors.id_guru" class="text-red-500 italic text-xs mt-1">{{ errors.id_guru }}</div>
                    </div>
                </div>

                <div class="w-full flex flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-1/3">
                        <label for="kelas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rombel</label>
                        <select id="kelas" v-model="payload.id_rombel"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.id_rombel ? 'border-red-400':'border-gray-300'"
                            @focus="errors.id_rombel = null"
                        >
                            <option value="">Pilih Rombel</option>
                            <option v-for="(item, i) in optRombel" :key="i" :value="item.id">{{ item.text }}</option>
                        </select>
                        <div v-if="errors.id_rombel" class="text-red-500 italic text-xs mt-1">{{ errors.id_rombel }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="mapel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipe Soal</label>
                        <select id="mapel" v-model="payload.tipe_soal"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.tipe_soal ? 'border-red-400':'border-gray-300'"
                            @focus="errors.tipe_soal = null"
                        >
                            <option value="">Pilih Tipe Soal</option>
                            <option value="pg_essay">Pilihan Ganda dan Essay</option>
                            <option value="pg">Pilihan Ganda</option>
                            <option value="essay">Essay</option>
                        </select>
                        <div v-if="errors.tipe_soal" class="text-red-500 italic text-xs mt-1">{{ errors.tipe_soal }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="guru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Soal Agama</label>
                        <select id="guru" v-model="payload.is_agama"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.is_agama ? 'border-red-400':'border-gray-300'"
                            @focus="errors.is_agama = null"
                        >
                            <option :value="0">Pilih</option>
                            <option :value="1">Ya</option>
                            <option :value="0">Tidak</option>
                        </select>
                        <div v-if="errors.is_agama" class="text-red-500 italic text-xs mt-1">{{ errors.is_agama }}</div>
                    </div>
                </div>

                <div class="w-full flex flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-1/3">
                        <label for="jml_pg" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Soal Pilihan Ganda</label>
                        <input v-model="payload.jml_pg" type="number" id="jml_pg"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.jml_pg ? 'border-red-400':'border-gray-300'"
                            @focus="errors.jml_pg = null"
                            >
                        <div v-if="errors.jml_pg" class="text-red-500 italic text-xs mt-1">{{ errors.jml_pg }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="bobot_pg" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bobot Pilihan Ganda</label>
                        <input v-model="payload.bobot_pg" type="number" id="bobot_pg"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.bobot_pg ? 'border-red-400':'border-gray-300'"
                            @focus="errors.bobot_pg = null"
                            >
                        <div v-if="errors.bobot_pg" class="text-red-500 italic text-xs mt-1">{{ errors.bobot_pg }}</div>
                    </div>

                    <!-- <div class="mb-6 w-1/3">
                        <label for="bobot_essay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bobot Essay</label>
                        <input v-model="payload.bobot_essay" type="number" id="bobot_essay"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.bobot_essay ? 'border-red-400':'border-gray-300'"
                            @focus="errors.bobot_essay = null"
                            >
                        <div v-if="errors.bobot_essay" class="text-red-500 italic text-xs mt-1">{{ errors.bobot_essay }}</div>
                    </div> -->
                </div>

                <div class="w-full flex flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-1/3">
                        <label for="jml_essay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah Soal Pilihan Ganda</label>
                        <input v-model="payload.jml_essay" type="number" id="jml_essay"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.jml_essay ? 'border-red-400':'border-gray-300'"
                            @focus="errors.jml_essay = null"
                            >
                        <div v-if="errors.jml_essay" class="text-red-500 italic text-xs mt-1">{{ errors.jml_essay }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="bobot_essay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bobot Pilihan Ganda</label>
                        <input v-model="payload.bobot_essay" type="number" id="bobot_essay"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.bobot_essay ? 'border-red-400':'border-gray-300'"
                            @focus="errors.bobot_essay = null"
                            >
                        <div v-if="errors.bobot_essay" class="text-red-500 italic text-xs mt-1">{{ errors.bobot_essay }}</div>
                    </div>
                </div>

            </div>

            <div class="border-t px-6 py-4 box-order">
                <div v-if="isLoadingSave" class="flex items-center justify-end">
                    <div class="flex items-center">
                        <img :src="loader" alt="" class="w-8">
                        <div class="text-gray-600 italic">Menyimpan Data</div>
                    </div>
                </div>
                <div class="flex justify-end" v-else>
                    <button @click="router.push({ name: 'detailSoal', params: { id: route.params.id } })" type="button" class="mr-5 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        Batal
                    </button>
                    <button @click="storeData" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>