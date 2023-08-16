<script setup>
import { ref, defineAsyncComponent, reactive, onMounted } from 'vue'
import { Modal } from 'flowbite-vue'
import loader from '@/assets/gif/loader.gif'
import { useNotification } from "@kyvg/vue3-notification"
const Pagination = defineAsyncComponent(() => import('@/components/Pagination.vue'))
const { notify } = useNotification()
const dataset = ref([])
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
      order: "kode:asc",
    })

const isLoading = ref(false)
const isLoadingModalAdd = ref(false)
const isLoadingModalEdit = ref(false)
const isLoadingModalDelete = ref(false)
const isShowModalAdd = ref(false)
const isShowModalEdit = ref(false)
const isShowModalDelete = ref(false)

const payload = reactive({
    id: null,
    kode: '',
    nama: '',
})

const errors = reactive({
    kode: null,
    nama: null,
})

const resetPayloadAndError = () => {
    payload.id = null
    payload.kode = ''
    payload.nama = ''
    errors.kode = null
    errors.nama = null
}

const fetchData = async () => {
    isLoading.value = true
    try{
        const { data } = await axios.get('/admin/kelas', { params })

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

const showModalAdd = () => {
  isShowModalAdd.value = true
}

const closeModalAdd = () => {
  isShowModalAdd.value = false
  resetPayloadAndError()
}

const storeData = async () => {
    isLoadingModalAdd.value = true
    try{

        const { data } = await axios.post(`/admin/kelas`, payload)
        fetchData()
        closeModalAdd()
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else if(e.response.status == 422) {
            const err = e.response.data.errors
            errors.kode = err.kode ? err.kode[0] : null
            errors.nama = err.nama ? err.nama[0] : null
        }else {
            notify({
                text: "Faliled to add, Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }finally {
        isLoadingModalAdd.value = false
    }
}

const showModalEdit = async (id) => {
    try{
        const { data } = await axios.get(`/admin/kelas/${id}/detail`)

        payload.id = id
        payload.kode = data.data.kode
        payload.nama = data.data.nama
        isShowModalEdit.value = true
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

const closeModalEdit = () => {
  isShowModalEdit.value = false
  resetPayloadAndError()
}

const editData = async () => {
    isLoadingModalEdit.value = true
    try{

        const { data } = await axios.post(`/admin/kelas/${payload.id}/update`, payload)
        fetchData()
        closeModalEdit()
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else if(e.response.status == 422) {
            const err = e.response.data.errors
            errors.kode = err.kode ? err.kode[0] : null
            errors.nama = err.nama ? err.nama[0] : null
        }else {
            notify({
                text: "Faliled to add, Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }finally {
        isLoadingModalEdit.value = false
    }
}

const showModalDelete = async (id) => {
    try{
        const { data } = await axios.get(`/admin/kelas/${id}/detail`)

        payload.id = id
        payload.kode = data.data.kode
        payload.nama = data.data.nama
        isShowModalDelete.value = true
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

const closeModalDelete = () => {
    isShowModalDelete.value = false
    resetPayloadAndError()
}

const deleteData = async () => {
    isLoadingModalDelete.value = true
    try{

        const { data } = await axios.delete(`/admin/kelas/${payload.id}/delete`, payload)
        fetchData()
        closeModalDelete()
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else if(e.response.status == 422) {
            const err = e.response.data.errors
            errors.kode = err.kode ? err.kode[0] : null
            errors.nama = err.nama ? err.nama[0] : null
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
    <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="box-border px-6 py-3 border-b bg-white flex justify-between items-center">
            <h2 class="text-lg font-bold">Kelas</h2>

            <div>
                <button class="px-3 py-2 rounded border border-gray-300 text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white" @click="showModalAdd()">Add</button>
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
                            <span class="bg-gray-300 text-gray-300 rounded">Kode Kelas</span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="bg-gray-300 text-gray-300 rounded">Kode Kelas</span>
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
                            <span class="bg-gray-300 text-gray-300 rounded">kode kelas</span>
                        </td>
                        <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                            <span class="bg-gray-300 text-gray-300 rounded">nama kelas</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="w-full flex justify-end space-x-2">
                                <a href="#" class="rounded-lg overflow-hidden block font-normal bg-gray-300 text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                </a>

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
                        <th scope="col" class="px-6 py-3 w-[10px]">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kode Kelas
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nama Kelas
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="sr-only">Aksi</div>
                        </th>
                    </tr>
                </thead>
                <tbody v-if="dataset.length != 0">
                    <tr v-for="(item, i) in dataset" :key="i" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                            {{ (pageInfo.current_page - 1) * pageInfo.per_page + 1 + i }}
                        </td>
                        <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                            {{ item.kode }}
                        </td>
                        <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                            {{ item.nama }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="w-full flex justify-end space-x-2">
                                <a @click.prevent="showModalEdit(item.id)" href="#" class="block font-normal text-gray-600 hover:text-indigo-600">
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
                        <td colspan="4" class="text-center px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white italic">Tidak Ada Data</td>
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

    <!-- modal add -->
    <Modal size="xl" v-if="isShowModalAdd" @close="closeModalAdd">
      <template #header>
        <div class="flex items-center text-lg">
            Tambah Kelas
        </div>
      </template>
      <template #body>
        <div class="mb-6">
            <label for="kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Kelas</label>
            <input v-model="payload.kode" type="text" id="kode"
                class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                :class="errors.kode ? 'border-red-400' : 'border-gray-300'"
                @focus="errors.kode = null"
            >
            <div v-if="errors.kode" class="text-red-500 italic text-[10px] mt-1">{{ errors.kode }}</div>
        </div>
        <div class="mb-6">
            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kelas</label>
            <input v-model="payload.nama" type="text" id="nama"
                class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                :class="errors.nama ? 'border-red-400' : 'border-gray-300'"
                @focus="errors.nama = null"
            >
            <div v-if="errors.nama" class="text-red-500 italic text-[10px] mt-1">{{ errors.nama }}</div>
        </div>
      </template>
      <template #footer>
        <div class="flex items-center" v-if="isLoadingModalAdd">
            <img :src="loader" alt="" class="w-8">
            <div class="text-gray-600 italic">Menyimpan Data</div>
        </div>

        <div v-else class="flex justify-between">
          <button @click="closeModalAdd" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
            Batal
          </button>
          <button @click="storeData" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Simpan
          </button>
        </div>
      </template>
    </Modal>
    <!-- end modal add -->

    <!-- modal edit -->
    <Modal size="xl" v-if="isShowModalEdit" @close="closeModalEdit">
      <template #header>
        <div class="flex items-center text-lg">
            Edit Kelas
        </div>
      </template>
      <template #body>
        <div class="mb-6">
            <label for="kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Kelas</label>
            <input v-model="payload.kode" type="text" id="kode"
                class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                :class="errors.kode ? 'border-red-400' : 'border-gray-300'"
                @focus="errors.kode = null"
            >
            <div v-if="errors.kode" class="text-red-500 italic text-[10px] mt-1">{{ errors.kode }}</div>
        </div>
        <div class="mb-6">
            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Kelas</label>
            <input v-model="payload.nama" type="text" id="nama"
                class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                :class="errors.nama ? 'border-red-400' : 'border-gray-300'"
                @focus="errors.nama = null"
            >
            <div v-if="errors.nama" class="text-red-500 italic text-[10px] mt-1">{{ errors.nama }}</div>
        </div>
      </template>
      <template #footer>
        <div class="flex items-center" v-if="isLoadingModalEdit">
            <img :src="loader" alt="" class="w-8">
            <div class="text-gray-600 italic">Menyimpan Data</div>
        </div>
        <div class="flex justify-between" v-else>
          <button @click="closeModalEdit" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
            Batal
          </button>
          <button @click="editData" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Simpan
          </button>
        </div>
      </template>
    </Modal>
    <!-- end modal edit -->

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
                        Apakah Anda yakin ingin menghapus kelas {{ payload.nama }} ?
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