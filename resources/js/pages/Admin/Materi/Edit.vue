<script setup>
import { ref, defineAsyncComponent, reactive, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import loader from '@/assets/gif/loader.gif'
import { useNotification } from "@kyvg/vue3-notification"
import Editor from '@tinymce/tinymce-vue'

const { notify } = useNotification()

const router = useRouter()
const route = useRoute()

const optKelas = ref([])
const optMapel = ref([])
const optRombel = ref([])
const optGuru = ref([])

const mediaImage = ref()
const mediaFile = ref()
const mediaVideo = ref()

const isLoading = ref(false)

const tinyKey = ref('zrsng3633x1bpntx7mrn4yx8efkpcyn3qt3r5sebh01ijff5') // no-api-key

const init = reactive({
    height: 400,
    menubar: true,
    plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste formula'
    ],
                                                
    toolbar: 'undo redo | bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | formula code | imagetools link image paste ',
    fontsize_formats: '8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt',
    paste_data_images: true,
                                                
    images_upload_handler: function (blobInfo, success, failure) {
        success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
    },
    image_class_list: [
        {title: 'Responsive', value: 'img-responsive'}
    ],
})

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

const getOptKelas = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/opt/kelas`,
            method: 'GET',
        })
        optKelas.value = data.data
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

const getOptMapel = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/opt/mapel`,
            method: 'GET',
        })
        optMapel.value = data.data
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

const getOptRombel = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/opt/rombel`,
            method: 'GET',
        })

        optRombel.value = data.data
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

const getOptGuru = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/opt/guru`,
            method: 'GET',
        })

        optGuru.value = data.data
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
        console.log(e)
        // if(e.response.status == 401) {
        //     localStorage.removeItem('TOKEN')
        //     location.reload()
        // }
    }finally{
        isLoading.value = false
    }
}

const readImage = () => {
    errors.media_image = null
    const files = mediaImage.value.files[0]
    const sizeFile = files.size
    const tipeFile = files.type

    const arrType = ['image/jpg', 'image/jpeg', 'image/svg+xml', 'image/gif', 'image/png']
    const maxFile = 2 * 1048576

    if(!arrType.includes(tipeFile)) {
        errors.media_image = 'Type File must be jpg, jpeg, png, svg or gif'
        return
    }

    if(sizeFile > maxFile) {
        errors.media_image = 'file size cannot be larger than 2 mb'
        return
    }
    payload.media_image = URL.createObjectURL(files)
}

const readFile = () => {
    errors.media_file = null
    const files = mediaFile.value.files[0]
    const sizeFile = files.size
    const tipeFile = files.type

    const arrType = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
    const maxFile = 5 * 1048576

    if(!arrType.includes(tipeFile)) {
        errors.media_file = 'Type File must be pdf or docx'
        return
    }

    if(sizeFile > maxFile) {
        errors.media_file = 'file size cannot be larger than 5 mb'
        return
    }

    payload.media_file = URL.createObjectURL(files)
}

const readVideo = () => {
    errors.media_video = null
    const files = mediaVideo.value.files[0]
    const sizeFile = files.size
    const tipeFile = files.type

    const arrType = ['video/mp4', 'video/mpeg', 'video/x-msvideo']
    const maxFile = 30 * 1048576

    if(!arrType.includes(tipeFile)) {
        errors.media_video = 'Type Video must be mp4, mpeg or avi'
        return
    }

    if(sizeFile > maxFile) {
        errors.media_video = 'file size cannot be larger than 30 mb'
        return
    }
    payload.media_video = URL.createObjectURL(mediaVideo.value.files[0]);
}

const storeData = async () => {
    if(errors.media_file || errors.media_image || errors.media_video) {
        notify({
            text: "Anda memiliki input yang tidak sesuai, silahkan cek kembali input anda",
            type: 'error',
            duration: 2000
        })
        return
    }
    isLoading.value = true
    try{

        let dataPayload = new FormData()
        dataPayload.append("id_kelas", payload.id_kelas ?? '');
        dataPayload.append("id_mapel", payload.id_mapel ?? '');
        dataPayload.append("id_rombel", payload.id_rombel ?? '');
        dataPayload.append("id_guru", payload.id_guru ?? '');
        dataPayload.append("judul", payload.judul ?? '');
        dataPayload.append("slug", payload.slug ?? '');
        dataPayload.append("deskripsi", payload.deskripsi ?? '');

        if (mediaImage.value.files[0] !== undefined) {
            dataPayload.append("media_image", mediaImage.value.files[0]);
        }

        if (mediaFile.value.files[0] !== undefined) {
            dataPayload.append("media_file", mediaFile.value.files[0]);
        }

        if (mediaVideo.value.files[0] !== undefined) {
            dataPayload.append("media_video", mediaVideo.value.files[0]);
        }

        const { data } = await instanceAdmin({
            url: `/admin/materi/${route.params.id}/update`,
            method: 'POST',
            headers: {
                "Content-Type": "multipart/form-data"
            },
            data: dataPayload,
        })

        notify({
            text: "Berhasil ubah materi",
            type: 'success',
            duration: 2000
        })

        router.push({ name: 'showMateri', params: { id: route.params.id } })

    }catch(e) {
        console.log(e)
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }else if(e.response.status == 422) {
            const err = e.response.data.errors
            // errors.kode = err.kode ? err.kode[0] : null
            // errors.nama = err.nama ? err.nama[0] : null
        }else {
            notify({
                text: "Faliled to add, Server is Maintenent",
                type: 'error',
                duration: 2000
            })
        }
    }finally {
        isLoading.value = false
    }
}

onMounted(() => {
    fetchData()
    getOptKelas()
    getOptGuru()
    getOptMapel()
    getOptRombel()
})

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
                            <option value="">Pilih Kelas</option>
                            <option v-for="(item, i) in optKelas" :key="i" :value="item.id">{{ item.text }}</option>
                        </select>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="mapel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata Pelajaran</label>
                        <select id="mapel" v-model="payload.id_mapel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Pilih Mapel</option>
                            <option v-for="(item, i) in optMapel" :key="i" :value="item.id">{{ item.text }}</option>
                        </select>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label for="guru" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guru Pengampu</label>
                        <select id="guru" v-model="payload.id_guru" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Pilih Guru</option>
                            <option v-for="(item, i) in optGuru" :key="i" :value="item.id">{{ item.text }}</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6 w-full">
                    <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul / Nama Materi</label>
                    <textarea id="judul" v-model="payload.judul" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Theorema Phytagoras ..."></textarea>

                </div>
                <div class="mb-6 w-full">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Materi</label>
                    <editor v-model="payload.deskripsi" :api-key="tinyKey" :init="init" />
                    <!-- <textarea id="deskripsi" v-model="payload.deskripsi" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="sebuah Rumus untuk menghitung sisi terpanjang segitiga ......"></textarea> -->

                </div>

                <div class="w-full flex flex-col lg:flex-row lg:space-x-3">
                    <div class="mb-6 w-1/3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Image</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="media-image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 box-border overflow-hidden" :class="errors.media_image ? 'border-red-300':'border-gray-300'">
                                <div v-if="payload.media_image">
                                    <img
                                        :src="payload.media_image"
                                        alt=""
                                        loading="lazy"
                                        class="w-full object-cover object-center"
                                    />
                                </div>
                                <div v-else class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 2 mb)</p>
                                </div>
                                <input id="media-image" ref="mediaImage" type="file" class="sr-only" @change="readImage" />
                            </label>
                        </div> 
                        <div v-if="errors.media_image" class="text-red-500 italic text-xs mt-1">{{ errors.media_image }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media File</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="media-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50" :class="errors.media_file ? 'border-red-300':'border-gray-300'">
                                <div v-if="payload.media_file" class="flex flex-col items-center justify-center pt-5 pb-6 text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="file" data-name="Layer 1" viewBox="0 0 24 24" class="w-40 fill-current">
                                        <path d="M7.98,16.11c0,.47-.41,.86-.89,.86h-.83s0-1.72,0-1.72h.84c.48,0,.89,.39,.89,.86Zm7.02-8.11h6.54c-.35-.91-.88-1.75-1.59-2.46l-3.48-3.49c-.71-.71-1.55-1.24-2.46-1.59V7c0,.55,.45,1,1,1Zm-2.91,7.25h-.84v3.5s.84,0,.84,0c.48,0,.89-.39,.89-.86v-1.78c0-.47-.41-.86-.89-.86Zm9.91-4.76v8.51c0,2.76-2.24,5-5,5H7c-2.76,0-5-2.24-5-5V5C2,2.24,4.24,0,7,0h4.51c.16,0,.32,.01,.49,.02V7c0,1.65,1.35,3,3,3h6.98c.01,.16,.02,.32,.02,.49Zm-12.77,5.62c0-1.16-.96-2.11-2.14-2.11h-1.09c-.55,0-1,.45-1,1v4.44c0,.35,.28,.62,.62,.62s.62-.28,.62-.62v-1.22h.84c1.18,0,2.14-.95,2.14-2.11Zm5,0c0-1.16-.96-2.11-2.14-2.11h-1.09c-.55,0-1,.45-1,1v4.44c0,.35,.28,.56,.62,.56s1.46,0,1.46,0c1.18,0,2.14-.95,2.14-2.11v-1.78Zm4.79-1.48c0-.35-.28-.62-.62-.62h-2.31c-.35,0-.62,.28-.62,.62v4.81c0,.35,.28,.62,.62,.62s.62-.28,.62-.62v-1.8h1.24c.35,0,.62-.28,.62-.62s-.28-.62-.62-.62h-1.24v-1.14h1.69c.35,0,.62-.28,.62-.62Z"/>
                                        <!-- v-if="mediaFile.files[0]?.type == 'application/pdf'" -->
                                        <!-- <path v-else d="M21.98,10h-6.98c-1.65,0-3-1.35-3-3V.02c-.16-.01-.32-.02-.49-.02H7C4.24,0,2,2.24,2,5v14c0,2.76,2.24,5,5,5h10c2.76,0,5-2.24,5-5V10.49c0-.16-.01-.32-.02-.49Zm-5.26,4.24l-1.42,5.66c-.15,.61-.68,1.05-1.31,1.09-.63,.04-1.21-.32-1.44-.91l-.55-1.38-.55,1.38c-.22,.56-.75,.91-1.34,.91-.03,0-.07,0-.1,0-.63-.04-1.15-.48-1.31-1.1l-1.41-5.66c-.13-.54,.19-1.08,.73-1.21,.53-.13,1.08,.19,1.21,.73l1,4,.85-2.13c.15-.38,.52-.63,.93-.63h0c.41,0,.78,.25,.93,.63l.84,2.13,1.01-4c.13-.54,.68-.86,1.21-.73,.54,.13,.86,.68,.73,1.21Zm-2.72-7.24V.46c.91,.35,1.75,.88,2.46,1.59l3.48,3.49c.71,.71,1.24,1.55,1.59,2.46h-6.54c-.55,0-1-.45-1-1Z"/> -->
                                    </svg>
                                    <!-- mediaFile.files[0].type == 'application/pdf' -->
                                    <div class="mt-2 text-gray-500 font-semibold text-center">{{ mediaFile.files[0]?.name ?? 'Materi' }}</div>
                                </div>

                                <div v-else class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF or DOC (MAX. 5mb)</p>
                                </div>
                                <input id="media-file" ref="mediaFile" type="file" class="sr-only" @change="readFile" />
                            </label>
                        </div> 
                        <div v-if="errors.media_file" class="text-red-500 italic text-xs mt-1">{{ errors.media_file }}</div>
                    </div>

                    <div class="mb-6 w-1/3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Video</label>
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="media-video" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50" :class="errors.media_video ? 'border-red-300':'border-gray-300'">
                                <div v-if="payload.media_video" class="flex flex-col items-center justify-center pt-5 pb-6 text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="file" data-name="Layer 1" viewBox="0 0 24 24" class="w-40 fill-current">
                                        <g id="XMLID_184_">
                                            <path d="M23.498,6.186c-0.276-1.039-1.089-1.858-2.122-2.136C19.505,3.546,12,3.546,12,3.546s-7.505,0-9.377,0.504   C1.591,4.328,0.778,5.146,0.502,6.186C0,8.07,0,12,0,12s0,3.93,0.502,5.814c0.276,1.039,1.089,1.858,2.122,2.136   C4.495,20.454,12,20.454,12,20.454s7.505,0,9.377-0.504c1.032-0.278,1.845-1.096,2.122-2.136C24,15.93,24,12,24,12   S24,8.07,23.498,6.186z M9.546,15.569V8.431L15.818,12L9.546,15.569z"/>
                                        </g>
                                    </svg>
                                    <!-- mediaFile.files[0].type == 'application/pdf' -->
                                    <div class="mt-2 text-gray-500 font-semibold text-center">{{ mediaVideo.files[0] ? mediaVideo.files[0].name: payload.media_video }}</div>
                                </div>

                                <div v-else class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">MP4, MPEG or AVI (MAX. 30 mb)</p>
                                </div>
                                <input id="media-video" ref="mediaVideo" type="file" class="sr-only" @change="readVideo" />
                            </label>
                        </div>
                        <div v-if="errors.media_video" class="text-red-500 italic text-xs mt-1">{{ errors.media_video }}</div>
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