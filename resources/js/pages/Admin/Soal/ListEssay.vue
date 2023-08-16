<script setup>
import { ref, reactive } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import loader from '@/assets/gif/loader.gif'
import Editor from '@tinymce/tinymce-vue'

const router = useRouter()
const route = useRoute()

const isLoading = ref(false)
const isFullScreen = ref(false)
const itemSoalNo = ref(1)
const menuEditor = ref('soal')
const tinyKey = ref('zrsng3633x1bpntx7mrn4yx8efkpcyn3qt3r5sebh01ijff5') // no-api-key
const payload = reactive({
    id_soal: route.params.id,
    jenis_soal: 'essay',
    no_urut: itemSoalNo.value,
    text_soal: ''
})

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

const setNoSoal = (no) => {
    itemSoalNo.value = no
}

const saveSoal = (no) => {
    itemSoalNo.value = no
}
</script>

<template>
    <div
        class="w-full box-border p-5"
    >
        <div
            :class="isFullScreen ? 'fixed z-[999] top-0 left-0 overflow-x-hidden overflow-y-auto w-screen h-screen bg-white':'w-full relative overflow-x-auto shadow-md sm:rounded-lg bg-white'"
        >
            <div class="box-border px-6 py-6 border-b bg-white flex justify-between items-center">
                <h2 class="text-lg font-bold">Soal Essay Matematika Kelas 10</h2>

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
                        v-for="i in 5"
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
                        <div v-if="menuEditor == 'soal'">
                            <h2 class="w-full font-semibold mb-2">Soal</h2>
                            <editor v-model="payload.text_soal" :api-key="tinyKey" :init="init" />
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>