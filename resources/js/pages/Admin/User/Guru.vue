<script setup>
import { ref, defineAsyncComponent, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { Modal } from 'flowbite-vue'
import { useNotification } from "@kyvg/vue3-notification"

const Pagination = defineAsyncComponent(() => import('@/components/Pagination.vue'))
const { notify } = useNotification()
const router = useRouter()
const dataset = ref([])
const isLoading = ref(false)

const idGuru = ref(null)

const isLoadingModalDelete = ref(false)
const isShowModalDelete = ref(false)

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
        const { data } = await instanceAdmin({
            url: `/admin/guru`,
            method: 'GET',
            params: params
        })
        dataset.value = data.data
        pageInfo.value = data.meta
    }catch(e){
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else {
            console.log('internal server error')
        }
    }finally{
        isLoading.value = false
    }
}

const showModalDelete = async (id) => {
    idGuru.value = id
    isShowModalDelete.value = true
}

const closeModalDelete = () => {
    isShowModalDelete.value = false
    idGuru.value = null
}

const deleteData = async () => {
    isLoadingModalDelete.value = true
    try{

        const { data } = await axios.delete(`/admin/guru/${idGuru.value}/delete`)
        fetchData()
        closeModalDelete()
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
    }finally {
        isLoadingModalDelete.value = false
    }
}

const changePage = (page) => {
    params.page = page
    fetchData()
}

onMounted(() => {
    fetchData()
})

</script>


<template>
    <div class="w-full box-border">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Guru</h2>

                <div class="flex items-center">
                    <router-link :to="{ name: 'addGuru' }" class="mr-3 px-2 py-2 rounded border border-gray-300 text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                    </router-link>
                </div>
            </div>

            <div class="relative overflow-x-auto w-full">
                <table v-if="isLoading" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-[10px]">
                                <span class="bg-gray-300 text-gray-300 rounded">No</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Nama Guru</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Kelas</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Mapel</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Pengampu</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">dibuat pada</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="sr-only">Aksi</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in 5" :key="i" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">no</span>
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">nama materi</span>
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
                                <span class="bg-gray-300 text-gray-300 rounded">dibuat pada</span>
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
                            <th scope="col" class="px-6 py-3 w-[10px]">No</th>
                            <th scope="col" class="px-6 py-3">Nama Guru</th>
                            <th scope="col" class="px-6 py-3">L/P</th>
                            <th scope="col" class="px-6 py-3">Tempat Lahir</th>
                            <th scope="col" class="px-6 py-3">Tanggal Lahir</th>
                            <th scope="col" class="px-6 py-3">Jenis Ptk</th>
                            <th scope="col" class="px-6 py-3">
                                <div class="sr-only">Aksi</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="dataset.length != 0">
                        <tr v-for="(item, i) in dataset" :key="i" class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ (pageInfo.current_page - 1) * pageInfo.per_page + 1 + i }}</td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="flex items-center space-x-2">
                                    <div class="rounded-full w-10 h-10 flex justify-center overflow-hidden bg-blue-200">
                                        <img :src="item.foto" alt="" class="w-full">
                                    </div>
                                    <div>
                                        <div class="font-semibold mb-1">{{ item.gelar_depan }} {{ item.nama }}, {{ item.gelar_belakang }}</div>
                                        <div class="text-xs">{{ item.nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white uppercase">{{ item.gender }}</td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white capitalize">{{ item.tempat_lahir }}</td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ item.tgl_lahir }}</td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white capitalize">{{ item.jenis_ptk.replace('_', ' ') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="w-full flex justify-end space-x-2">
                                    <a href="#" @click.prevent="router.push({ name: 'showMateri', params: { id: 1 } })"  class="block font-normal text-gray-600 hover:text-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>

                                    <a @click.prevent="showModalDelete(item.id)" href="#" class="block font-normal text-gray-600 hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
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

    <!-- modal delete -->
    <Modal size="xl" v-if="isShowModalDelete" @close="closeModalDelete">
        <template #body>
            <div class="w-full bg-white">
                <div class="w-full flex space-x-5">
                    <div
                        class="flex-none w-20 h-20 rounded bg-red-700 text-white flex items-center justify-center"
                    >
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-16 w-16"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <div class="mb-3 text-base font-semibold">
                        Apakah Anda yakin ingin menghapus data guru ?
                        </div>
                        <div class="mb-3 text-sm">
                            Data yang dihapus tidak bisa akan hilang secara permanen, apa anda
                            ingin melanjutkan ?
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex items-center" v-if="isLoadingModalDelete">
                <img :src="loader" alt="" class="w-8">
                <div class="text-gray-600 italic">Menghapus Data</div>
            </div>
            <div class="flex justify-end items-center space-x-3" v-else>
                <button
                    @click.prevent="deleteData"
                    class="px-4 py-2 rounded bg-indigo-500 text-white text-xs font-semibold border border-indigo-500 hover:bg-transparent hover:text-indigo-500"
                >
                    Ya, hapus
                </button>
                <button
                    @click.prevent="closeModalDelete"
                    class="px-4 py-2 rounded bg-red-500 text-white text-xs font-semibold border border-red-500 hover:bg-transparent hover:text-red-500"
                >
                    Batal
                </button>
            </div>
        </template>
    </Modal>
    <!-- end modal delete -->
</template>