<script setup>

import { ref, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import loader from '@/assets/gif/loader.gif'
import { useNotification } from "@kyvg/vue3-notification"

const router = useRouter()
const { notify } = useNotification()
const optSoal = ref([])
const optKelas = ref([])
const optMapel = ref([])
const optRombel = ref([])
const optGuru = ref([])

const isLoading = ref(false)

const payload = reactive({
    id_soal: '',
    id_kelas: '',
    id_jenis_ujian: 1,
    id_materi: '',
    id_guru: '',
    id_rombel: '',
    nama: '',
    lama_ujian: '',
    waktu_mulai: '',
    w_akhir: '',
    is_hasil: 0,
    is_acak: 0,
})

const errors = reactive({
    id_soal: null,
    id_kelas: null,
    id_jenis_ujian: null,
    id_materi: null,
    id_guru: null,
    id_rombel: null,
    nama: null,
    lama_ujian: null,
    waktu_mulai: null,
    w_akhir: null,
    is_hasil: null,
    is_acak: null,
})

const getOptSoal = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/opt/soal`,
            method: 'GET',
        })
        optSoal.value = data.data
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

const selectSoal = () => {
    if(payload.id_soal == '') {
        payload.id_kelas = ''
        payload.id_mapel = ''
        payload.id_guru = ''
        payload.id_rombel = ''
    }else{
        const soal = optSoal.value.find((item) => {
            return item.id == payload.id_soal
        })

        payload.id_kelas = soal.id_kelas
        payload.id_mapel = soal.id_mapel
        payload.id_guru = soal.id_guru
        payload.id_rombel = soal.id_rombel
    }
}

const storeData = async () => {
    isLoading.value = true
    try{

        // let { data } = await axios.post('/admin/ujian', payload)
        const { data } = await instanceAdmin({
            url: '/admin/ujian',
            method: 'POST',
            data: payload,
        })
        notify({
            text: "Berhasil tambah ujian",
            type: 'success',
            duration: 2000
        })

        router.push({ name: 'ujian' })
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else if(e.response.status == 422) {
            const err = e.response.data.errors
            errors.id_soal = err.id_soal ? err.id_soal[0] : null
            errors.id_kelas = err.id_kelas ? err.id_kelas[0] : null
            errors.id_jenis_ujian = err.id_jenis_ujian ? err.id_jenis_ujian[0] : null
            errors.id_materi = err.id_materi ? err.id_materi[0] : null
            errors.id_guru = err.id_guru ? err.id_guru[0] : null
            errors.id_rombel = err.id_rombel ? err.id_rombel[0] : null
            errors.nama = err.nama ? err.nama[0] : null
            errors.lama_ujian = err.lama_ujian ? err.lama_ujian[0] : null
            errors.waktu_mulai = err.waktu_mulai ? err.waktu_mulai[0] : null
            errors.w_akhir = err.w_akhir ? err.w_akhir[0] : null
            errors.is_hasil = err.is_hasil ? err.is_hasil[0] : null
            errors.is_acak = err.is_acak ? err.is_acak[0] : null
        }else {
            notify({
                text: "Faliled to add, Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }finally {
        isLoading.value = false
    }
}

onMounted(() => {
    getOptSoal()
    getOptKelas()
    getOptGuru()
    getOptMapel()
    getOptRombel()
})

</script>


<template>
    <div class="w-full box-border p-5">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Buat Ujian</h2>
            </div>

            <div class="w-full p-6 box-border bg-white">
                <div class="w-full flex flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-2/3">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul / Nama Ujian</label>
                        <textarea id="nama" v-model="payload.nama" rows="1"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border focus:ring-blue-500 focus:border-blue-500 " placeholder="UH Matematika SMT 1 ..."
                            :class="errors.nama ? 'border-red-400':'border-gray-300'"
                            @focus="errors.nama = null"
                        ></textarea>
                        <div v-if="errors.nama" class="text-red-500 italic text-xs mt-1">{{ errors.nama }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="soal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Soal</label>
                        <select id="soal" v-model="payload.id_soal" @change.prevent="selectSoal()"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.id_soal ? 'border-red-400':'border-gray-300'"
                            @focus="errors.id_soal = null"
                        >
                            <option value="">Pilih Soal</option>
                            <option v-for="(item, i) in optSoal" :key="i" :value="item.id">{{ item.text }}</option>
                        </select>
                        <div v-if="errors.id_soal" class="text-red-500 italic text-xs mt-1">{{ errors.id_soal }}</div>
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
                    <!-- <div class="mb-6 w-1/3">
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
                    </div> -->

                    <div class="mb-6 w-1/3">
                        <label for="lama_ujian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lama Ujian</label>
                        <div class="w-full flex items-center">
                            <input v-model="payload.lama_ujian" type="number" id="lama_ujian"
                                class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mr-2"
                                :class="errors.lama_ujian ? 'border-red-400':'border-gray-300'"
                                @focus="errors.lama_ujian = null"
                            >
                            <div>Menit</div>
                        </div>
                        <div v-if="errors.lama_ujian" class="text-red-500 italic text-xs mt-1">{{ errors.lama_ujian }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="waktu_mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu Mulai</label>
                        <div class="w-full flex items-center">
                            <input v-model="payload.waktu_mulai" type="datetime-local" id="waktu_mulai"
                                class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mr-2"
                                :class="errors.waktu_mulai ? 'border-red-400':'border-gray-300'"
                                @focus="errors.waktu_mulai = null"
                            >
                        </div>
                        <div v-if="errors.waktu_mulai" class="text-red-500 italic text-xs mt-1">{{ errors.waktu_mulai }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="w_akhir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu Terlambat</label>
                        <div class="w-full flex items-center">
                            <input v-model="payload.w_akhir" type="datetime-local" id="w_akhir"
                                class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mr-2"
                                :class="errors.w_akhir ? 'border-red-400':'border-gray-300'"
                                @focus="errors.w_akhir = null"
                            >
                        </div>
                        <div v-if="errors.w_akhir" class="text-red-500 italic text-xs mt-1">{{ errors.w_akhir }}</div>
                    </div>
                    
                </div>

                <div class="w-full flex flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-1/3">
                        <label for="is_hasil" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tampil Hasil</label>
                        <select id="is_hasil" v-model="payload.is_hasil"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.is_hasil ? 'border-red-400':'border-gray-300'"
                            @focus="errors.is_hasil = null"
                        >
                            <option :value="1">Ya</option>
                            <option :value="0">Tidak</option>
                        </select>
                        <div v-if="errors.is_hasil" class="text-red-500 italic text-xs mt-1">{{ errors.is_hasil }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="is_acak" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Acak Soal</label>
                        <select id="is_acak" v-model="payload.is_acak"
                            class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            :class="errors.is_acak ? 'border-red-400':'border-gray-300'"
                            @focus="errors.is_acak = null"
                        >
                            <option :value="1">Ya</option>
                            <option :value="0">Tidak</option>
                        </select>
                        <div v-if="errors.is_acak" class="text-red-500 italic text-xs mt-1">{{ errors.is_acak }}</div>
                    </div>

                </div>

            </div>

            <div class="border-t px-6 py-4 box-order">
                <div v-if="isLoading" class="flex items-center justify-end">
                    <div class="flex items-center">
                        <img :src="loader" alt="" class="w-8">
                        <div class="text-gray-600 italic">Menyimpan Data</div>
                    </div>
                </div>
                <div class="flex justify-end" v-else>
                    <button @click="router.push({ name: 'soal' })" type="button" class="mr-5 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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