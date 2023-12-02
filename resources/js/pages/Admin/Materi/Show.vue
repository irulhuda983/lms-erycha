<script setup>
import { ref, defineAsyncComponent, reactive, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import loader from '@/assets/gif/loader.gif'
import { Modal } from 'flowbite-vue'
import { useNotification } from "@kyvg/vue3-notification"
const { notify } = useNotification()

const router = useRouter()
const route = useRoute()

const isLoading = ref(false)
const isShowModalImage = ref(false)
const isShowModalFile = ref(false)
const isShowModalVideo = ref(false)
const isLoadingModalDelete = ref(false)
const isShowModalDelete = ref(false)

const closeModalImage = () => {
    isShowModalImage.value = false
}

const closeModalFile = () => {
    isShowModalFile.value = false
}

const closeModalVideo = () => {
    isShowModalVideo.value = false
}

const payload = reactive({
    id: null,
    id_kelas: '',
    id_mapel: '',
    id_rombel: '',
    id_guru: '',
    kelas: '',
    mapel: '',
    rombel: '',
    guru: '',
    judul: '',
    slug: '',
    deskripsi: '',
    media_image: '',
    media_file: '',
    media_video: '',
})

const fetchData = async () => {
    isLoading.value = true
    try{
        const { data } = await instanceAdmin({
            url: `/admin/materi/${route.params.id}/detail`,
            method: 'GET',
        })
        
        const materi = data.data
        payload.id = materi.id
        payload.id_kelas = materi.id_kelas
        payload.id_mapel = materi.id_mapel
        payload.id_rombel = materi.id_rombel
        payload.id_guru = materi.id_guru
        payload.judul = materi.judul
        payload.kelas = materi.kelas
        payload.mapel = materi.mapel
        payload.guru = materi.guru
        payload.deskripsi = materi.deskripsi
        payload.rombel = materi.rombel
        payload.media_file = materi.media_file
        payload.media_image = materi.media_image
        payload.media_video = materi.media_video
        payload.slug = materi.slug
    }catch(e){
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally{
        isLoading.value = false
    }
}


const closeModalDelete = () => {
    isShowModalDelete.value = false
    resetPayloadAndError()
}

const deleteData = async () => {
    isLoading.value = true
    try{
        // const { data } = await axios.delete(`/admin/materi/${route.params.id}/delete`)

        const { data } = await instanceAdmin({
            url: `/admin/materi/${route.params.id}/delete`,
            method: 'DELETE',
        })

        notify({
            type: 'success',
            text: "Berhasil hapus data",
        });
        router.push({ name: 'materi' })
    }catch(e){
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally{
        isLoading.value = false
    }
}

onMounted(() => {
    fetchData()
})

</script>

<template>
    <div class="w-full box-border lg:p-5">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Detail Materi</h2>

                <div class="flex items-center">
                    <button @click.prevent="router.push({ name: 'materi' })" class="px-2 py-2 border border-gray-300 text-xs text-gray-600 font-semibold hover:border-blue-500 hover:bg-blue-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                    </button>
                    <button @click.prevent="router.push({ name: 'editMateri', params: { id: route.pa } })" class="px-2 py-2 border-y border-gray-300 text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </button>
                    <button @click.prevent="isShowModalDelete = true" class="px-2 py-2 border border-gray-300 text-xs text-gray-600 font-semibold hover:border-red-500 hover:bg-red-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full p-6 box-border bg-white flex flex-col lg:flex-row">
                <div class="w-full lg:w-2/3 lg:mr-5">
                    <div class="mb-6 w-full">
                        <label for="kelas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
                        <input type="text" v-model="payload.kelas" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>

                    <div class="mb-6 w-full">
                        <label for="mapel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata Pelajaran</label>
                        <input type="text" v-model="payload.mapel" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>

                    <div class="mb-6 w-full">
                        <label for="guru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guru Pengampu</label>
                        <input type="guru" v-model="payload.mapel" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>

                    <div class="mb-6 w-full">
                        <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul / Nama Materi</label>
                        <textarea id="judul" disabled v-model="payload.judul" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Theorema Phytagoras ..."></textarea>

                    </div>
                    <div class="mb-6 w-full">
                        <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Materi</label>
                        <textarea disabled id="deskripsi" v-model="payload.deskripsi" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="sebuah Rumus untuk menghitung sisi terpanjang segitiga ......"></textarea>

                    </div>
                </div>

                <div class="w-full lg:w-1/3 box-border">
                    <div class="mb-6 w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Image</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <div @click.prevent="isShowModalImage = true" class="flex flex-col items-center justify-center w-full h-64 overflow-hidden box-border rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Bold" viewBox="0 0 24 24" class="w-48 h-48 fill-current"><path d="M19.5,0H4.5A4.505,4.505,0,0,0,0,4.5v15A4.505,4.505,0,0,0,4.5,24h15A4.505,4.505,0,0,0,24,19.5V4.5A4.505,4.505,0,0,0,19.5,0ZM4.5,3h15A1.5,1.5,0,0,1,21,4.5v15a1.492,1.492,0,0,1-.44,1.06l-8.732-8.732a4,4,0,0,0-5.656,0L3,15V4.5A1.5,1.5,0,0,1,4.5,3Z"/><circle cx="15.5" cy="7.5" r="2.5"/>
                                    </svg>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <div class="block mb-6 w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media File</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <a @click.prevent="isShowModalFile = true" href="#" class="flex flex-col items-center justify-center w-full h-64 overflow-hidden box-border rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" class="w-48 fill-current"><path d="M7.98,16.11c0,.47-.41,.86-.89,.86h-.83s0-1.72,0-1.72h.84c.48,0,.89,.39,.89,.86Zm7.02-8.11h6.54c-.35-.91-.88-1.75-1.59-2.46l-3.48-3.49c-.71-.71-1.55-1.24-2.46-1.59V7c0,.55,.45,1,1,1Zm-2.91,7.25h-.84v3.5s.84,0,.84,0c.48,0,.89-.39,.89-.86v-1.78c0-.47-.41-.86-.89-.86Zm9.91-4.76v8.51c0,2.76-2.24,5-5,5H7c-2.76,0-5-2.24-5-5V5C2,2.24,4.24,0,7,0h4.51c.16,0,.32,.01,.49,.02V7c0,1.65,1.35,3,3,3h6.98c.01,.16,.02,.32,.02,.49Zm-12.77,5.62c0-1.16-.96-2.11-2.14-2.11h-1.09c-.55,0-1,.45-1,1v4.44c0,.35,.28,.62,.62,.62s.62-.28,.62-.62v-1.22h.84c1.18,0,2.14-.95,2.14-2.11Zm5,0c0-1.16-.96-2.11-2.14-2.11h-1.09c-.55,0-1,.45-1,1v4.44c0,.35,.28,.56,.62,.56s1.46,0,1.46,0c1.18,0,2.14-.95,2.14-2.11v-1.78Zm4.79-1.48c0-.35-.28-.62-.62-.62h-2.31c-.35,0-.62,.28-.62,.62v4.81c0,.35,.28,.62,.62,.62s.62-.28,.62-.62v-1.8h1.24c.35,0,.62-.28,.62-.62s-.28-.62-.62-.62h-1.24v-1.14h1.69c.35,0,.62-.28,.62-.62Z"/></svg>
                                </div>
                            </a>
                        </div> 
                    </div>

                    <div class="mb-6 w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Video</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <a @click.prevent="isShowModalVideo = true" href="#" class="flex flex-col items-center justify-center w-full h-64 overflow-hidden box-border rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve" class="w-48 fill-current">
                                        <g id="XMLID_184_">
                                            <path d="M23.498,6.186c-0.276-1.039-1.089-1.858-2.122-2.136C19.505,3.546,12,3.546,12,3.546s-7.505,0-9.377,0.504   C1.591,4.328,0.778,5.146,0.502,6.186C0,8.07,0,12,0,12s0,3.93,0.502,5.814c0.276,1.039,1.089,1.858,2.122,2.136   C4.495,20.454,12,20.454,12,20.454s7.505,0,9.377-0.504c1.032-0.278,1.845-1.096,2.122-2.136C24,15.93,24,12,24,12   S24,8.07,23.498,6.186z M9.546,15.569V8.431L15.818,12L9.546,15.569z"/>
                                        </g>
                                    </svg>
                                </div>
                            </a>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal add -->
    <Modal class="h-screen" size="5xl" v-if="isShowModalImage" @close="closeModalImage">
      <template #header>
        <div class="flex items-center text-lg">
            Media Image
        </div>
      </template>
      <template #body>
        <div v-if="payload.media_image" class="w-full h-full flex items-center justify-center">
            <img :src="payload.media_image" class="h-full" alt="">
        </div>
        <div v-else class="flex w-full items-center justify-center">
            Tidak ada media image
        </div>
      </template>
    </Modal>
    <!-- end modal add -->

    <!-- modal add -->
    <Modal class="h-screen" size="5xl" v-if="isShowModalFile" @close="closeModalFile">
      <template #header>
        <div class="flex items-center text-lg">
            Media File
        </div>
      </template>
      <template #body>
        <iframe v-if="payload.media_file" class="w-full" style="height: calc(100vh - 100px)" id="iframepdf" :src="payload.media_file"></iframe>
        <div v-else class="flex w-full items-center justify-center">
            Tidak ada media file
        </div>
      </template>
    </Modal>
    <!-- end modal add -->

    <!-- modal add -->
    <Modal size="5xl" v-if="isShowModalVideo" @close="closeModalVideo">
      <template #header>
        <div class="flex items-center text-lg">
            Media Video
        </div>
      </template>
      <template #body>
        <video v-if="payload.media_video" class="w-full" :src="payload.media_video" autoplay controls></video>
        <div v-else class="flex w-full items-center justify-center">
            Tidak ada media video
        </div>
      </template>
    </Modal>
    <!-- end modal add -->

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
                        Apakah Anda yakin ingin menghapus data ?
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