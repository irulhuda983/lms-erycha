<script setup>
import { ref, defineAsyncComponent, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { Modal } from 'flowbite-vue'
import { useNotification } from "@kyvg/vue3-notification"

const Pagination = defineAsyncComponent(() => import('@/components/Pagination.vue'))
const router = useRouter()
const { notify } = useNotification()
const dataset = ref([])
const isLoading = ref(false)
const isGrid = ref(false)

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
      order: "judul:asc",
    })

const fetchData = async () => {
    isLoading.value = true
    try{
        const { data } = await axios.get('/admin/materi', { params })

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
                <h2 class="text-lg font-bold">Materi</h2>

                <div class="flex items-center">
                    <router-link :to="{ name: 'addMateri' }" class="mr-3 px-2 py-2 rounded border border-gray-300 text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                        </svg>
                    </router-link>
                    <div class="w-px h-8 bg-gray-400 mr-3"></div>
                    <button class="text-gray-600 hover:text-indigo-600" @click.prevent="isGrid = !isGrid">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="isGrid" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />

                            <path v-else stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
            <div v-if="isGrid" class="relative overflow-x-auto w-full px-6 py-3">
                <div v-if="dataset.length == 0" class="w-full text-center py-10">
                    Tidak Ada Materi
                </div>
                <div v-else class="grid grid-cols-4 gap-5 mb-5">
                    <div v-for="(item, i) in dataset" :key="i" @click.prevent="router.push({ name: 'showMateri', params: { id: item.id } })" class="flex items-center relative space-x-5 rounded-lg cursor-pointer bg-sky-50 box-border p-4 text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z" clip-rule="evenodd" />
                        <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                        </svg>

                        <div class="">
                            <div>{{ item.judul }}</div>
                        </div>

                        <div class="absolute right-0 px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

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
            <div v-else class="relative overflow-x-auto w-full">
                <table v-if="isLoading" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-[10px]">
                                <span class="bg-gray-300 text-gray-300 rounded">No</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="bg-gray-300 text-gray-300 rounded">Nama Materi</span>
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
                            <th scope="col" class="px-6 py-3 w-[10px]">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Materi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Kelas
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Mapel
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Pengampu
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Dibuat Pada
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="sr-only">Aksi</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="dataset.length != 0">
                        <tr v-for="(item, i) in dataset" :key="i" @click.prevent="router.push({ name: 'showMateri', params: { id: item.id } })" class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ (pageInfo.current_page - 1) * pageInfo.per_page + 1 + i }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.judul }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.kelas }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.mapel }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.guru }}
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ item.created_at }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="w-full flex justify-end space-x-2">
                                    <a href="#" @click.prevent="router.push({ name: 'showMateri', params: { id: item.id } })" class="block font-normal text-gray-600 hover:text-indigo-600">
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