<script setup>
import { ref, defineAsyncComponent, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useTesStore } from "@/stores/tes"
import { Modal } from 'flowbite-vue'
import loader from '@/assets/gif/loader.gif'

const Pagination = defineAsyncComponent(() => import('@/components/Pagination.vue'))
const router = useRouter()
const dataset = ref([])
const detailTes = ref({})
const idUjian = ref(null)
const isLoading = ref(false)
const isLoadingModal = ref(false)
const tesStore = useTesStore()

const isShowModal = ref(false)

const cekIsRun = () => {
    if(tesStore.isRunningTest == 1) {
        router.push({ path: '/tes' })
    }
}

const pageInfo = ref({
    current_page: 1,
    from: null,
    last_page: 1,
    per_page: 10,
    to: null,
    total: 0
})

const params = reactive({
    filter: "",
    page: 1,
    limit: 10,
    order: "nama:asc",
})

const fetchData = async () => {
    isLoading.value = true
    try{
        const { data } = await instanceSiswa({
            url: '/peserta/ujian/hasil',
            method: 'GET',
            params: params,
        })

        dataset.value = data.data
        pageInfo.value = data.meta
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally {
        isLoading.value = false
    }
}

const changePage = (page) => {
    params.page = page
    fetchData()
}

const showModal = (item) => {
    detailTes.value = item
    isShowModal.value = true
}

const closeModal = () => {
    detailTes.value = {}
    isShowModal.value = false
}

const runTes = async () => {
    const run = await tesStore.runTest(idUjian.value)
    console.log(run)
    router.push({ name: 'siswaTes' })
    // console.log(run)
}

onMounted(() => {
    cekIsRun()
    fetchData()
})
</script>


<template>
    <div class="w-full box-border p-5 mt-14">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="box-border px-6 py-6 border-b bg-white flex items-center">
                <!-- <h2 class="text-lg font-bold">Tes</h2> -->
                <button @click.prevent="router.push({ name: 'siswaUjian' })" class="block rounded text-xs px-2 py-1.5 font-semibold text-gray-600 border border-gray-200 bg-gray-200 hover:text-green-600 hover:border-green-200 hover:bg-green-200 mr-4">Aktif Tes</button>
                <button class="block rounded text-xs px-2 py-1.5 font-semibold text-green-600 border border-green-200 bg-green-200">Hasil Tes</button>

                <!-- <div class="flex items-center">
                    <router-link :to="{ name: 'addUjian' }" class="mr-3 px-2 py-2 rounded border border-gray-300 text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                    </router-link>
                </div> -->
            </div>
            <div class="relative overflow-x-auto w-full">
                <table v-if="isLoading" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b">
                        <tr>
                            <!-- <th scope="col" class="px-6 py-3 w-[10px]">
                                <span class="bg-gray-300 text-gray-300 rounded">No</span>
                            </th> -->
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Nama Tes</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Mapel</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Lama</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Mulai</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Nilai</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Status</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="sr-only">Aksi</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in 5" :key="i" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <!-- <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">no</span>
                            </td> -->
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">nama Soal</span>
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">kelas</span>
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">mapel</span>
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">Pengampu</span>
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">Nilai</span>
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">status</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="w-full flex justify-end space-x-2">
                                    <a href="#" class="rounded-lg overflow-hidden block font-normal bg-gray-300 text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table v-else class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b">
                        <tr>
                            <!-- <th scope="col" class="px-6 py-3 w-[10px]">
                                No
                            </th> -->
                            <th scope="col" class="px-6 py-3">
                                Nama Tes
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Mapel
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ujian Mulai
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ujian Selesai
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nilai
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="dataset.length != 0">
                        <template v-for="(item, i) in dataset" :key="i">
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        >
                            <!-- <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ (pageInfo.current_page - 1) * pageInfo.per_page + 1 + i }}
                            </td> -->
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.ujian.nama }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.ujian.mapel }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.w_mulai }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.w_selesai }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.skor_pg ? parseFloat(item.skor_pg) : 0 }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="px-2 py-1 rounded text-[10px] bg-green-400/80 text-white">selesai</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="w-full flex justify-center space-x-2">
                                    <button @click.prevent="showModal(item)" class="capitalize text-gray-600 rounded text-[10px] px-3 py-1 bg-indigo-200 text-indigo-500 font-semibold hover:text-white hover:bg-indigo-400">
                                        detail
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </template>
                    </tbody>
                    <tbody v-else>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="7" class="text-center px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white italic">Tidak Ada Data</td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="isLoading == false && dataset.length != 0" class="w-full border-t box-border bg-white flex items-center justify-between px-6 py-3">
                    <div class="flex items-center justify-center space-x-2 text-xs">
                        <span>showing</span>
                        <select v-model="params.limit" @change.prevent="fetchData" class="text-xs px-1 py-1 rounded">
                            <option :value="10">10</option>
                            <option :value="50">50</option>
                            <option :value="100">100</option>
                        </select>
                        <div>from {{ pageInfo.from }}</div>
                        <div>to {{ pageInfo.to }}</div>
                    </div>
                    <div>
                        <Pagination
                            :total="pageInfo.total"
                            :currentPage="pageInfo.current_page"
                            :perPage="pageInfo.per_page"
                            @changePage="changePage"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal add -->
    <Modal size="5xl" v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-lg font-semibold">
            Detail Hasil Tes
        </div>
      </template>
      <template #body>
        <div class="w-full flex flex-col-reverse lg:flex-row items-start">
            <div class="w-full lg:w-2/3 box-border mb-5 lg:mb-0">
                <table class="w-full">
                    <tbody>
                        <tr class="border-y">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Nama Tes</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.ujian.nama }}</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Mata Pelajaran</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.ujian.mapel }}</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Jenjang/Kelas</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.ujian.kelas }}</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Pengampu</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.ujian.guru }}</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Waktu Tes</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.ujian.lama_ujian }} Menit</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Mulai Tes</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.w_mulai }}</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Selesai Tes</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.w_selesai }}</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Jumlah Soal</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.soal.jml_pg }} Soal</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Jawaban Benar</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.jml_pg_benar }} Soal</td>
                        </tr>

                        <tr class="border-b">
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[150px] font-semibold">Jawaban Salah</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white w-[10px]">:</td>
                            <td class="px-2 py-2.5 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ detailTes.jml_pg_salah }} Soal</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="w-full lg:w-1/3 flex justify-center">
                <div class="box-border bg-green-300/50 rounded">
                    <div class="px-24 py-2 bg-green-400 font-semibold text-white">Nilai</div>
                    <div class="text-center py-8 text-7xl font-bold">{{ detailTes.total }}</div>
                </div>
            </div>
        </div>
      </template>
      <!-- <template #footer>
        <div class="flex items-center" v-if="isLoadingModal">
            <img :src="loader" alt="" class="w-8">
            <div class="text-gray-600 italic">Menyimpan Data</div>
        </div>

        <div v-else class="flex justify-end">
          <button @click="closeModal" type="button" class="mr-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
            Batal
          </button>
          <button @click="runTes" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Mulai Kerjakan
          </button>
        </div>
      </template> -->
    </Modal>
    <!-- end modal add -->
</template>