<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import loader from '@/assets/gif/loader.gif'

const router = useRouter()
const route = useRoute()
const isLoading = ref(false)

const soal = ref([])
const soalPg = ref([])
const soalEssay = ref([])

const fetchData = async () => {
    isLoading.value = true
    try{
        const { data } = await instanceAdmin({
            url: `/admin/soal/${route.params.id}/detail`,
            method: 'GET',
        })
        soal.value = data.data
        soalPg.value = data.data.list_pg
        soalEssay.value = data.data.list_essay
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
                <h2 class="text-lg font-bold">Detail Soal</h2>

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
                <div v-if="soalPg.length != 0" class="w-full mb-10">
                    <div class="w-full flex justify-between items-center mb-5">
                        <div class="font-semibold mb-0 lg:mb-2">I. Pilihan Ganda</div>
                        <a href="#" @click.prevent="router.push({ name: 'listPgSoal', params: {id: route.params.id} })" class="block rounded px-3 py-2 border text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">Edit Pilihan Ganda</a>
                    </div>

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
                        </div>
                    </div>
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