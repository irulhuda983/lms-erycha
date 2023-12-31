<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import loader from '@/assets/gif/loader.gif'
import ProgressBar from '@/components/ProgressBar.vue'
import Editor from '@tinymce/tinymce-vue'
import { useNotification } from "@kyvg/vue3-notification"

const router = useRouter()
const route = useRoute()
const { notify } = useNotification()

const detailSoal = ref(null)
const isLoading = ref(false)
const isFullScreen = ref(false)
const itemSoalNo = ref(1)
const menuEditor = ref('soal')
const progressBarWidth = ref(80)
const tinyKey = ref('zrsng3633x1bpntx7mrn4yx8efkpcyn3qt3r5sebh01ijff5') // no-api-key

const payload = reactive({
    id_soal: route.params.id,
    jenis_soal: 'pg',
    no_urut: itemSoalNo.value,
    text_soal: '',
    pil_a: '',
    pil_b: '',
    pil_c: '',
    pil_d: '',
    kunci_jawaban: ''
})

const errors = ref(null)

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


const fetchDetailSoal = async () => {
    try{
        const { data } = await instanceAdmin({
            url: `/admin/soal/${route.params.id}/detail`,
            method: 'GET',
        })
        detailSoal.value = data.data
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }
}

const setNoSoal = async (no = 1) => {
    isLoading.value = true
    try{
        const { data } = await instanceAdmin({
            url: `/admin/soal-item/get-single-item`,
            method: 'GET',
            params: {
                id_soal: route.params.id,
                jenis_soal: 'pg',
                no_urut: no,
            }
        })

        const soalItem = data.data

        if(soalItem != null) {            
            payload.id_soal = soalItem.id_soal
            payload.jenis_soal = soalItem.jenis_soal
            payload.no_urut = soalItem.no_urut
            payload.text_soal = soalItem.text_soal
            payload.pil_a = soalItem.pil_a
            payload.pil_b = soalItem.pil_b
            payload.pil_c = soalItem.pil_c
            payload.pil_d = soalItem.pil_d
            payload.pil_e = soalItem.pil_e
            payload.kunci_jawaban = soalItem.kunci_jawaban
        }else{
            payload.id_soal = route.params.id
            payload.jenis_soal = 'pg'
            payload.no_urut = no
            payload.text_soal = ''
            payload.pil_a = ''
            payload.pil_b = ''
            payload.pil_c = ''
            payload.pil_d = ''
            payload.pil_e = ''
            payload.kunci_jawaban = ''
        }
        
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }
    }finally{
        itemSoalNo.value = no
        menuEditor.value = 'soal'
        progressBarWidth.value = 100
        isLoading.value = false
    }
}

const saveSoal = async (no) => {
    isLoading.value = true
    try{
        const { data } = await instanceAdmin({
            url: `/admin/soal-item`,
            method: 'POST',
            data: payload
        })
        notify({
            text: "Berhasil edit soal",
            type: 'success',
            duration: 2000
        })
        setNoSoal(no)
        // const soalItem = data.data
        
        // payload.id_soal = soalItem.id_soal
        // payload.jenis_soal = soalItem.jenis_soal
        // payload.no_urut = soalItem.no_urut
        // payload.text_soal = soalItem.text_soal
        // payload.pil_a = soalItem.pil_a
        // payload.pil_b = soalItem.pil_b
        // payload.pil_c = soalItem.pil_c
        // payload.pil_d = soalItem.pil_d
        // payload.pil_e = soalItem.pil_e
        // payload.kunci_jawaban = soalItem.kunci_jawaban
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKEN')
            location.reload()
        }

        if(e.response.status == 422) {
            notify({
                text: e.response.data.message,
                type: 'error',
                duration: 2000
            })

            errors.value = e.response.data.errors
        }
    }finally{
        itemSoalNo.value = no
        isLoading.value = false
    }
}

onMounted(() => {
    fetchDetailSoal()
    setNoSoal()
})

</script>

<template>
    <ProgressBar v-if="isLoading" :width="progressBarWidth"/>
    <div class="w-full box-border p-5">
        <div v-if="detailSoal != null" :class="isFullScreen ? 'fixed z-[999] top-0 left-0 overflow-x-hidden overflow-y-auto w-screen h-screen bg-white':'w-full relative overflow-x-auto shadow-md sm:rounded-lg bg-white'">
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">{{ detailSoal.nama }}</h2>

                <div class="flex items-center">
                    <button @click.prevent="router.push({ name: 'detailSoal', params: {id: route.params.id} })" class="px-2 py-2 border border-gray-300 text-xs text-gray-600 font-semibold hover:border-blue-500 hover:bg-blue-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                    </button>
                    <button @click.prevent="saveSoal(itemSoalNo)" class="px-2 py-2 border-y border-gray-300 text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M12,10a4,4,0,1,0,4,4A4,4,0,0,0,12,10Zm0,6a2,2,0,1,1,2-2A2,2,0,0,1,12,16Z"/><path d="M22.536,4.122,19.878,1.464A4.966,4.966,0,0,0,16.343,0H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H19a5.006,5.006,0,0,0,5-5V7.657A4.966,4.966,0,0,0,22.536,4.122ZM17,2.08V3a3,3,0,0,1-3,3H10A3,3,0,0,1,7,3V2h9.343A2.953,2.953,0,0,1,17,2.08ZM22,19a3,3,0,0,1-3,3H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2V3a5.006,5.006,0,0,0,5,5h4a4.991,4.991,0,0,0,4.962-4.624l2.16,2.16A3.02,3.02,0,0,1,22,7.657Z"/></svg>
                    </button>
                    <button @click.prevent="isFullScreen = !isFullScreen" class="px-2 py-2 border border-gray-300 text-xs text-gray-600 font-semibold hover:border-indigo-500 hover:bg-indigo-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" id="Filled" viewBox="0 0 24 24" class="w-5 h-5 fill-current"><path d="M23,16a1,1,0,0,0-1,1v2a3,3,0,0,1-3,3H17a1,1,0,0,0,0,2h2a5.006,5.006,0,0,0,5-5V17A1,1,0,0,0,23,16Z"/><path d="M7,0H5A5.006,5.006,0,0,0,0,5V7A1,1,0,0,0,2,7V5A3,3,0,0,1,5,2H7A1,1,0,0,0,7,0Z"/><path d="M7,22H5a3,3,0,0,1-3-3V17a1,1,0,0,0-2,0v2a5.006,5.006,0,0,0,5,5H7a1,1,0,0,0,0-2Z"/><path d="M19,0H17a1,1,0,0,0,0,2h2a3,3,0,0,1,3,3V7a1,1,0,0,0,2,0V5A5.006,5.006,0,0,0,19,0Z"/></svg>
                    </button>
                </div>
            </div>

            <div class="w-full px-6 py-2 box-border bg-white border-b text-gray-600 flex flex-col lg:flex-row lg:space-x-5">
                <div class="flex w-full overflow-x-auto">
                    <!-- :class="[item.status ? 'text-white bg-blue-400':'hover:bg-gray-600 hover:text-white', page == item.value ? 'text-red-400 bg-[#e8f0fe] font-semibold':'hover:bg-gray-600 hover:text-white']" -->
                    <div
                        v-for="i in parseInt(detailSoal.jml_pg)"
                        :key="i"
                        @click.prevent="setNoSoal(i)"
                        class="w-6 h-6 font-semibold cursor-pointer text-[10px] border flex items-center justify-center hover:bg-indigo-400 hover:text-white"
                        :class="itemSoalNo == i ? 'bg-indigo-400 text-white':''"
                    >{{ i }}</div>
                </div>
            </div>

            <div class="w-full box-border bg-white border-b text-gray-600 bg-white">
                <div class="flex">
                    <!-- editor -->
                    <div class="w-full p-6 box-border">
                        <div v-if="errors" class="bg-red-300 rounded box-border px-4 pr-8 py-2 text-xs text-red-600 relative">
                            <button class="absolute top-2 right-2" @click.prevent="errors = null">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                            <div class="w-full px-4">
                                <ul class="list-disc">
                                    <li v-for="(item, i) in errors" :key="i">{{ item[0] }}</li>
                                </ul>
                            </div>
                        </div>
                        <div v-if="menuEditor == 'soal'">
                            <h2 class="w-full font-semibold mb-2">Soal</h2>
                            <editor v-model="payload.text_soal" :api-key="tinyKey" :init="init" />
                        </div>

                        <div class="w-full mb-5" v-if="menuEditor == 'pil_a'">
                            <div class="w-full flex items-center justify-between mb-2">
                                <h2 class="w-full font-semibold">Pilihan A</h2>
                                <div>
                                    <label for="jawab_e"
                                        class="relative block w-5 h-5 border-2 rounded cursor-pointer flex items-center justify-center"
                                        :class="payload.kunci_jawaban == 'A' ? 'border-green-400 bg-green-400 text-white':'border-gray-400'"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" :class="payload.kunci_jawaban == 'A' ? 'visible':'invisible'" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="jawab_e" v-model="payload.kunci_jawaban" value="A" class="sr-only">

                                </div>
                            </div>
                            <editor v-model="payload.pil_a" :api-key="tinyKey" :init="init" />
                        </div>

                        <div class="w-full mb-5" v-if="menuEditor == 'pil_b'">
                            <div class="w-full flex items-center justify-between mb-2">
                                <h2 class="w-full font-semibold">Pilihan B</h2>
                                <div>
                                    <label for="jawab_b"
                                        class="relative block w-5 h-5 border-2 rounded cursor-pointer flex items-center justify-center"
                                        :class="payload.kunci_jawaban == 'B' ? 'border-green-400 bg-green-400 text-white':'border-gray-400'"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" :class="payload.kunci_jawaban == 'B' ? 'visible':'invisible'" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="jawab_b" v-model="payload.kunci_jawaban" value="B" class="sr-only">

                                </div>
                            </div>
                            <editor v-model="payload.pil_b" :api-key="tinyKey" :init="init" />
                        </div>

                        <div class="w-full mb-5" v-if="menuEditor == 'pil_c'">
                            <div class="w-full flex items-center justify-between mb-2">
                                <h2 class="w-full font-semibold">Pilihan C</h2>
                                <div>
                                    <label for="jawab_c"
                                        class="relative block w-5 h-5 border-2 rounded cursor-pointer flex items-center justify-center"
                                        :class="payload.kunci_jawaban == 'C' ? 'border-green-400 bg-green-400 text-white':'border-gray-400'"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" :class="payload.kunci_jawaban == 'C' ? 'visible':'invisible'" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="jawab_c" v-model="payload.kunci_jawaban" value="C" class="sr-only">

                                </div>
                            </div>
                            <editor v-model="payload.pil_c" :api-key="tinyKey" :init="init" />
                        </div>

                        <div class="w-full mb-5" v-if="menuEditor == 'pil_d'">
                            <div class="w-full flex items-center justify-between mb-2">
                                <h2 class="w-full font-semibold">Pilihan D</h2>
                                <div>
                                    <label for="jawab_d"
                                        class="relative block w-5 h-5 border-2 rounded cursor-pointer flex items-center justify-center"
                                        :class="payload.kunci_jawaban == 'D' ? 'border-green-400 bg-green-400 text-white':'border-gray-400'"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" :class="payload.kunci_jawaban == 'D' ? 'visible':'invisible'" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                    <input type="radio" id="jawab_d" v-model="payload.kunci_jawaban" value="D" class="sr-only">

                                </div>
                            </div>
                            <editor v-model="payload.pil_d" :api-key="tinyKey" :init="init" />
                        </div>

                    </div>

                    <!-- menu list -->
                    <div class="w-14 flex-none box-border py-6 border-x border-gray-200 flex flex-col items-center">
                        <button
                            class="border w-8 h-8 text-center rounded-full mb-5 flex items-center justify-center"
                            @click.prevent="menuEditor = 'soal'"
                            :class="menuEditor == 'soal' ? 'bg-gray-600 text-white':'hover:bg-gray-200'"
                        >
                            <svg id="Layer_1" class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"><path d="m10 10a3 3 0 0 0 0 6h4a3 3 0 0 0 0-6zm5 3a1 1 0 0 1 -1 1h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 1 1zm2 6a1 1 0 0 1 -1 1h-8a1 1 0 0 1 0-2h8a1 1 0 0 1 1 1zm2.536-15.879-1.658-1.656a4.968 4.968 0 0 0 -3.535-1.465h-6.343a5.006 5.006 0 0 0 -5 5v14a5.006 5.006 0 0 0 5 5h8a5.006 5.006 0 0 0 5-5v-12.343a4.968 4.968 0 0 0 -1.464-3.536zm-1.414 1.414a3.1 3.1 0 0 1 .378.465h-2.5v-2.5a2.932 2.932 0 0 1 .464.377zm.878 14.465a3 3 0 0 1 -3 3h-8a3 3 0 0 1 -3-3v-14a3 3 0 0 1 3-3h6v3a2 2 0 0 0 2 2h3z"/></svg>
                        </button>

                        <!-- menu a -->
                        <button class="relative border w-8 h-8 text-center rounded-full mb-5 font-bold"
                            @click.prevent="menuEditor = 'pil_a'"
                            :class="menuEditor == 'pil_a' ? 'bg-gray-600 text-white':'hover:bg-gray-200'"
                        >
                            <span>A</span>
                            <div :class="payload.kunci_jawaban == 'A' ? 'visible':'invisible'" class="bg-green-400 absolute text-white -top-1 -right-1 rounded-full w-4 h-4 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <!-- menu a -->

                        <!-- menu b -->
                        <button
                            class="relative border w-8 h-8 text-center rounded-full mb-5 font-bold"
                            @click.prevent="menuEditor = 'pil_b'"
                            :class="menuEditor == 'pil_b' ? 'bg-gray-600 text-white':'hover:bg-gray-200'"
                        >
                            <span>B</span>
                            <div :class="payload.kunci_jawaban == 'B' ? 'visible':'invisible'" class="bg-green-400 absolute text-white -top-1 -right-1 rounded-full w-4 h-4 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <!-- menu b -->

                        <!-- menu c -->
                        <button
                            class="relative border w-8 h-8 text-center rounded-full mb-5 font-bold"
                            @click.prevent="menuEditor = 'pil_c'"
                            :class="menuEditor == 'pil_c' ? 'bg-gray-600 text-white':'hover:bg-gray-200'"
                        >
                            <span>C</span>
                            <div :class="payload.kunci_jawaban == 'C' ? 'visible':'invisible'" class="bg-green-400 absolute text-white -top-1 -right-1 rounded-full w-4 h-4 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <!-- menu c -->

                        <!-- menu d -->
                        <button
                            class="relative border w-8 h-8 text-center rounded-full mb-5 font-bold"
                            @click.prevent="menuEditor = 'pil_d'"
                            :class="menuEditor == 'pil_d' ? 'bg-gray-600 text-white':'hover:bg-gray-200'"
                        >
                            <span>D</span>
                            <div :class="payload.kunci_jawaban == 'D' ? 'visible':'invisible'" class="bg-green-400 absolute text-white -top-1 -right-1 rounded-full w-4 h-4 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <!-- menu d -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>