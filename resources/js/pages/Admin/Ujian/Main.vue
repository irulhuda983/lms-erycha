<script setup>
import { ref, defineAsyncComponent, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { Modal } from 'flowbite-vue'

const Pagination = defineAsyncComponent(() => import('@/components/Pagination.vue'))
const router = useRouter()
const dataset = ref([])
const isLoading = ref(false)

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
            url: '/admin/ujian',
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

onMounted(() => {
    fetchData()
})
</script>


<template>
    <div class="w-full box-border p-5">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Ujian</h2>

                <div class="flex items-center">
                    <router-link :to="{ name: 'addUjian' }" class="mr-3 px-2 py-2 rounded border border-gray-300 text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">
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
                                <span class="bg-gray-300 text-gray-300 rounded">Nama Ujian</span>
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
                                <span class="bg-gray-300 text-gray-300 rounded">Akhir</span>
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
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span class="bg-gray-300 text-gray-300 rounded">no</span>
                            </td>
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
                                <span class="bg-gray-300 text-gray-300 rounded">dibuat pada</span>
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
                            <th scope="col" class="px-6 py-3 w-[10px]">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Ujian
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Mapel
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Lama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Mulai
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Batas Terlambat
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="sr-only">Aksi</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="dataset.length != 0">
                        <tr v-for="(item, i) in dataset" :key="i" @click.prevent="router.push({ name: 'detailSoal', params: { id: item.id } })" class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ (pageInfo.current_page - 1) * pageInfo.per_page + 1 + i }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.nama }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.mapel }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.lama_ujian }} Menit
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.waktu_mulai }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.w_akhir }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <span v-if="item.is_active == 1" class="px-2 py-1 rounded text-[10px] bg-green-400/80 text-white">activate</span>
                                <span v-else class="px-2 py-1 rounded text-[10px] bg-red-400/80 text-white">deactivate</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="w-full flex justify-end space-x-2">
                                    <a href="#" @click.prevent="router.push({ name: 'detailSoal', params: { id: item.id } })" class="block font-normal text-gray-600 hover:text-indigo-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
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

</template>