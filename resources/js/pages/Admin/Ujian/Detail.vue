<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import ListPesertaUjian from '@/pages/Admin/Ujian/ListPeserta.vue'
import loader from '@/assets/gif/loader.gif'

const router = useRouter()
const route = useRoute()
const isLoading = ref(false)

const ujian = ref([])

const fetchData = async () => {
    isLoading.value = true
    try{
        const { data } = await instanceAdmin({
            url: `/admin/ujian/${route.params.id}/detail`,
            method: 'GET',
        })
        console.log(data)
        ujian.value = data.data
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally {
        isLoading.value = false
    }
}

onMounted(() => {
    fetchData()
})

</script>

<template>
    <div class="w-full box-border p-5">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg bg-white">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Detail Ujian</h2>

                <div class="flex items-center">
                    <button @click.prevent="router.push({ name: 'soal' })" class="px-2 py-2 border border-gray-300 text-xs text-gray-600 font-semibold hover:border-blue-500 hover:bg-blue-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                    </button>
                    <button @click.prevent="router.push({ name: 'editSoal', params: { id: 1 } })" class="px-2 py-2 border-y border-gray-300 text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </button>
                    <button v-if="ujian.status != 'sedang_berlangsung'" @click.prevent="router.push({ name: 'hasilUjian', params: { id: route.params.id } })" class="px-2 py-2 border border-r-0 border-gray-300 text-xs text-gray-600 font-semibold hover:border-blue-500 hover:bg-blue-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                        </svg>
                    </button>
                    <button class="px-2 py-2 border border-gray-300 text-xs text-gray-600 font-semibold hover:border-red-500 hover:bg-red-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full p-6 box-border bg-white border-b text-gray-600 flex flex-col lg:flex-row lg:space-x-5">
                <div class="w-1/2">
                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Kode Ujian</div>
                        <div>:</div>
                        <div>{{ ujian.kode }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Nama Ujian</div>
                        <div>:</div>
                        <div>{{ ujian.nama }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Mata Pelajaran</div>
                        <div>:</div>
                        <div>{{ ujian.mapel }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Tutor</div>
                        <div>:</div>
                        <div>{{ ujian.guru }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Kelas</div>
                        <div>:</div>
                        <div>{{ ujian.kelas }}</div>
                    </div>

                </div>

                <div class="w-1/2">
                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Soal</div>
                        <div>:</div>
                        <div class="uppercase">{{ ujian.soal }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Jumlah Soal</div>
                        <div>:</div>
                        <div>{{ ujian?.dataSoal?.jml_pg }} Butir</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Lama Ujian</div>
                        <div>:</div>
                        <div>{{ ujian.lama_ujian }} Menit</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Waktu Ujian</div>
                        <div>:</div>
                        <div>{{ ujian.waktu_mulai_view }} s/d {{ ujian.w_akhir_view }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Status Ujian</div>
                        <div>:</div>
                        <div class="font-semibold capitalize" :class="ujian.status == 'sedang_berlangsung' ? 'text-green-500':'text-red-500'">{{ ujian.status ? ujian.status.replace("_", " ") : '-' }}</div>
                    </div>
                </div>
            </div>

            <ListPesertaUjian v-if="ujian.status == 'sedang_berlangsung'" />
            <div v-else class="w-full box-border bg-white border-b text-gray-600 bg-white">
                <div class="border-b px-6 py-3 text-black">
                    <h1 class="text-sm font-bold">List Peserta Ujian</h1>
                </div>

                <div class="w-full box-border p-5">
                    Tidak ada peserta yang masih ujian
                </div>
            </div>
        </div>
    </div>
</template>