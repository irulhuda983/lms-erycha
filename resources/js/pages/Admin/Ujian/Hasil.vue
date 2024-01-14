<script setup>
import { ref, defineAsyncComponent, reactive, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const Pagination = defineAsyncComponent(() => import('@/components/Pagination.vue'))
const router = useRouter()
const route = useRoute()
const dataset = ref([])
const isLoading = ref(false)
const modalLjk = ref()
const isOpenModalLjk = ref(false)
const soal = ref([])
const soalPg = ref([])
const soalEssay = ref([])
const listJawaban = ref([])

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
    limit: 30,
    order: "total:desc",
})

const fetchData = async () => {
    isLoading.value = true
    try{
        const { data } = await instanceAdmin({
            url: `/admin/ujian/${route.params.id}/hasil`,
            method: 'GET',
            params: params,
        })
        // console.log(data)
        const items = data.data

        const sorted = items.sort((a, b) => b.total - a.total);
        // nilaiTertinggi.value = sorted.slice(0,10)
        dataset.value = sorted
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally {
        isLoading.value = false
    }
}


const openModal = async (id) => {
    isLoading.value = true
    try{
        const { data } = await instanceAdmin({
            url: `/admin/ujian/${route.params.id}/hasil/${id}/detail`,
            method: 'GET',
        })

        // console.log(data.data)
        soal.value = data.data.soal
        soalPg.value = data.data.soalItem
        listJawaban.value = data.data.jawaban
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally {
        isLoading.value = false
        isOpenModalLjk.value = true;
    }
}

const closeModal = () => {
    soal.value = [];
    soalPg.value = [];
    listJawaban.value = [];
    isOpenModalLjk.value = false;
}

const findJawaban = (idSoal) => {
    const jwb = listJawaban.value.find(el => { return el.id_soal_item == idSoal });

    const jawaban =  jwb ? jwb.jawaban : '-';
    return jawaban;
}

// watch()

onMounted(() => {
    fetchData();
})

</script>


<template>
    <div class="w-full box-border p-5">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Hasil Ujian</h2>

                <div class="flex items-center">
                    <button @click.prevent="router.push({ name: 'detailUjian', params: { id: route.params.id } })" class="px-2 py-2 border border-gray-300 text-xs text-gray-600 font-semibold hover:border-blue-500 hover:bg-blue-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative overflow-x-auto w-full">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b">
                        <tr>
                            <th scope="col" class="px-6 py-3" style="width: 2%;">No</th>
                            <th scope="col" class="px-6 py-3">Nama Peserta</th>
                            <th scope="col" class="px-6 py-3">Waktu Ujian</th>
                            <th scope="col" class="px-6 py-3">Jml Soal</th>
                            <th scope="col" class="px-6 py-3">Jwb Benar</th>
                            <th scope="col" class="px-6 py-3">Jwb Salah</th>
                            <th scope="col" class="px-6 py-3">Nilai</th>
                            <th scope="col" class="px-6 py-3"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, i) in dataset" :key="i" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white" style="width: 1%;">{{ i + 1 }}</td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                <div>{{ item.siswa.nama }}</div>
                                <!-- <div class="text-[8px] text-gray-500">NIK : {{  }}</div> -->
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white text-[12px]">
                                <div class="flex items-center"><div class="w-14">Mulai</div> : {{ item.w_mulai }}</div>
                                <div class="flex items-center"><div class="w-14">selesai</div> : {{ item.w_selesai }}</div>
                            </td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ item.soal.jml_pg }}</td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ item.jml_pg_benar }}</td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ parseInt(item.total) - parseInt(item.jml_pg_benar) }}</td>
                            <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">{{ item.total }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="w-full flex justify-end space-x-2">
                                    <a href="#" @click.prevent="openModal(item.id)" class="rounded-lg overflow-hidden block font-normal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div v-if="isOpenModalLjk" class="w-screen h-screen fixed top-0 left-0 bottom-0 bg-white z-[9999] overflow-x-hidden overflow-y-auto">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg bg-white">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Hasil Ujian Siswa</h2>

                <div class="flex items-center">
                    <button @click.prevent="closeModal()" class="px-2 py-2 border border-gray-300 text-xs text-gray-600 font-semibold hover:border-red-500 hover:bg-red-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>

                    </button>
                </div>
            </div>

            <div class="w-full p-6 box-border bg-white border-b text-gray-600 flex flex-col lg:flex-row lg:space-x-5">
                <div class="w-1/2">
                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Kode Soal</div>
                        <div>:</div>
                        <div>{{ soal.kode }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Nama Soal</div>
                        <div>:</div>
                        <div>{{ soal.nama }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Mata Pelajaran</div>
                        <div>:</div>
                        <div>{{ soal.mapel }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Guru</div>
                        <div>:</div>
                        <div>{{ soal.guru }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Kelas</div>
                        <div>:</div>
                        <div>{{ soal.kelas }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Rombel</div>
                        <div>:</div>
                        <div>{{ soal.rombel }}</div>
                    </div>
                </div>

                <div class="w-1/2">
                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Tipe Soal</div>
                        <div>:</div>
                        <div class="uppercase">{{ soal.tipe_soal }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Jumlah PG</div>
                        <div>:</div>
                        <div>{{ soal.jml_pg }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Jumlah Essay</div>
                        <div>:</div>
                        <div>{{ soal.jml_essay }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Bobot PG</div>
                        <div>:</div>
                        <div>{{ soal.bobot_pg }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">Bobot Essay</div>
                        <div>:</div>
                        <div>{{ soal.bobot_essay }}</div>
                    </div>

                    <div class="flex space-x-3 mb-2">
                        <div class="w-52 font-semibold">KKM</div>
                        <div>:</div>
                        <div>{{ soal.kkm }}</div>
                    </div>
                </div>
            </div>

            <div class="w-full p-6 box-border bg-white border-b text-gray-600 bg-white">
                <div class="w-full mb-10">
                    <div class="w-full flex justify-between items-center mb-5">
                        <div class="font-semibold mb-0 lg:mb-2">I. Pilihan Ganda</div>
                    </div>

                    <!-- <div>{{ soalPg }}</div> -->

                    <template v-if="soalPg.length != 0">
                    <div v-for="(item, i) in soalPg" :key="i" class="w-full flex mb-5">
                        <div class="flex-none w-8">{{ item.no_urut }}.</div>
                        <div class="w-full">
                            <div class="mb-3" v-html="item.text_soal">
                            </div>
                            <div class="flex mb-2">
                                <div class="w-1/2">
                                    <div class="flex space-x-3 mb-1.5">
                                        <div>a.</div> <div v-html="item.pil_a"></div>
                                    </div>
                                    <div class="flex space-x-3 mb-1.5">
                                        <div>b.</div> <div v-html="item.pil_b"></div>
                                    </div>
                                </div>

                                <div class="w-1/2">
                                    <div class="flex space-x-3 mb-1.5">
                                        <div>c.</div> <div v-html="item.pil_c"></div>
                                    </div>
                                    <div class="flex space-x-3 mb-1.5">
                                        <div>d.</div> <div v-html="item.pil_d"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="font-semibold italic">Kunci Jawaban : {{ item.kunci_jawaban }}</div>
                            <div class="font-semibold italic" :class="findJawaban(item.id) == item.kunci_jawaban ? 'text-green-400':'text-red-400'">Jawaban : <span>{{ findJawaban(item.id) }}</span></div>
                        </div>
                    </div>
                    </template>
                </div>

                <div v-if="soalEssay.length != 0" class="w-full">
                    <div class="w-full flex justify-between items-center mb-5">
                        <div class="font-semibold mb-0 lg:mb-2">II. Essay</div>
                        <a href="#" @click.prevent="router.push({ name: 'listEssaySoal', params: {id: route.params.id} })" class="block rounded px-3 py-2 border text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">Edit Essay</a>
                    </div>

                    <div v-for="(item, i) in soalEssay" :key="i" class="w-full flex mb-5">
                        <div class="flex-none w-8">{{ i + 1 }}.</div>
                        <div class="w-full">
                            <div class="mb-3">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias modi odit ratione cumque eveniet enim nulla temporibus cupiditate minus explicabo a dicta eum, ipsum veniam! A odio consequuntur temporibus! Tenetur accusamus sit non sed eaque nobis vel laudantium molestias distinctio?
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>