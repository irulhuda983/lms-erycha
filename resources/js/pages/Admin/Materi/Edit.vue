<script setup>
import { ref, defineAsyncComponent, reactive } from 'vue'
import { useRouter } from 'vue-router'
import loader from '@/assets/gif/loader.gif'

const router = useRouter()

const isLoading = ref(false)

const payload = reactive({
    id: null,
    id_kelas: '',
    id_rombel: '',
    id_guru: '',
    judul: '',
    slug: '',
    deskripsi: '',
    media_image: '',
    media_file: '',
    media_video: '',
})

const errors = reactive({
    id_kelas: null,
    id_rombel: null,
    id_guru: null,
    judul: null,
    slug: null,
    deskripsi: null,
    media_image: null,
    media_file: null,
    media_video: null,
})

const resetPayloadAndError = () => {
    payload.id = null
    payload.id_kelas = ''
    payload.id_rombel = ''
    payload.id_guru = ''
    payload.judul = ''
    payload.slug = ''
    payload.deskripsi = ''
    payload.media_image = ''
    payload.media_file = ''
    payload.media_video = ''

    errors.id_kelas = null
    errors.id_rombel = null
    errors.id_guru = null
    errors.judul = null
    errors.slug = null
    errors.deskripsi = null
    errors.media_image = null
    errors.media_file = null
    errors.media_video = null
}

const storeData = () => {
    console.log('simpan')
    router.push({ name: 'showMateri', params: { id: 1 } })
}

</script>

<template>
    <div class="w-full box-border p-5">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Edit Materi</h2>
            </div>

            <div class="w-full p-6 box-border">
                <div class="w-full flex items-center flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-1/3">
                        <label for="kelas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                        <select id="kelas" v-model="payload.id_kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>United States</option>
                            <option>Canada</option>
                            <option>France</option>
                            <option>Germany</option>
                        </select>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="mapel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata Pelajaran</label>
                        <select id="mapel" v-model="payload.id_mapel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>United States</option>
                            <option>Canada</option>
                            <option>France</option>
                            <option>Germany</option>
                        </select>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="guru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guru Pengampu</label>
                        <select id="guru" v-model="payload.id_guru" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>United States</option>
                            <option>Canada</option>
                            <option>France</option>
                            <option>Germany</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6 w-full">
                    <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul / Nama Materi</label>
                    <textarea id="judul" v-model="payload.judul" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Theorema Phytagoras ..."></textarea>

                </div>
                <div class="mb-6 w-full">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Materi</label>
                    <textarea id="deskripsi" v-model="payload.deskripsi" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="sebuah Rumus untuk menghitung sisi terpanjang segitiga ......"></textarea>

                </div>

                <div class="w-full flex items-center flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-1/3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Image</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="media-image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                </div>
                                <input id="media-image" type="file" class="hidden" />
                            </label>
                        </div> 
                    </div>

                    <div class="mb-6 w-1/3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media File</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="media-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF or DOC (MAX. 2mb)</p>
                                </div>
                                <input id="media-file" type="file" class="hidden" />
                            </label>
                        </div> 
                    </div>

                    <div class="mb-6 w-1/3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Video</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="media-video" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">MP4 or AVI (MAX. 10mb)</p>
                                </div>
                                <input id="media-video" type="file" class="hidden" />
                            </label>
                        </div> 
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
                    <button @click="router.push({ name: 'showMateri', params: { id: 1 } })" type="button" class="mr-5 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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