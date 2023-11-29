<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from "vue-router";
// import { VuePdf } from 'vue3-pdfjs/esm';
import VuePdfEmbed from 'vue-pdf-embed'

const route = useRoute();
const materi = ref([]);
const pdfSrc = ref('https://raw.githubusercontent.com/mozilla/pdf.js/ba2edeae/web/compressed.tracemonkey-pldi-09.pdf')
const isLoading = ref(true)
const page = ref(1)
const pageCount = ref(1)
const showAllPages = ref(false)
const pdfRef = ref()

const contenType = ref('doc');

const fetchMateri = async () => {
    try{
        const { data } = await instanceSiswa({
            url: `peserta/materi/${route.params.id}/detail`,
            method: 'GET',
        })

        materi.value = data.data
    }catch(e) {
        console.log(e)
    }
}

const handleDocumentRender = (args) => {
    console.log(args)
    isLoading.value = false
    pageCount.value = pdfRef.value.pageCount
}

const changeMediaType = (type) => {
    contenType.value = type
}

const play = () => {
    console.log('ok')
}

watch(showAllPages, () => {
    page.value = showAllPages.value ? null : 1
})

onMounted(() => {
    fetchMateri()
})

</script>

<template>
    <div class="w-full box-border overflow-x-hidden h-full pt-[80px] px-4 mb-14 lg:mb-0">
        <div class="bg-white w-full box-border overflow-hidden p-4 rounded">
            <div class="w-full mb-3 border-b">
                <div class="flex items-center justify-between w-full pb-2">
                    <h4 class="font-medium text-gray-500">MATERI</h4>
                    <button @click.prevent="changeMediaType('doc')" :class="contenType == 'doc' ? 'text-green-500' : 'hover:text-green-500'">Dokumen</button>
                    <button @click.prevent="changeMediaType('video')" :class="contenType == 'video' ? 'text-green-500' : 'hover:text-green-500'">Video</button>
                    <router-link :to="{ name: 'siswaMateri'}" class="inline-block border rounded py-1.5 px-4 text-[12px] hover:border-red-400 hover:bg-red-400  hover:text-white">Kembali</router-link>
                </div>
            </div>

            <div v-if="materi.length != 0" class="w-full box-border mb-10 lg:flex lg:items-start">
                <div class="w-full lg:w-3/4 box-border mb-5 lg:mb-0 lg:mr-5 border-b border-gray-400 lg:border-none">
                    <vue3-video-player v-if="contenType == 'video'" @play="play" :src="materi.media_video"></vue3-video-player>
                    <div v-if="contenType == 'doc'" class="w-full">
                        <div class="app-header">
                            <template v-if="isLoading"> Loading... </template>

                            <template v-else>
                                <span v-if="showAllPages"> {{ pageCount }} page(s) </span>

                                <span v-else>
                                    <button :disabled="page <= 1" @click="page--">❮</button>

                                    {{ page }} / {{ pageCount }}

                                    <button :disabled="page >= pageCount" @click="page++">❯</button>
                                </span>

                                <!-- <label class="right">
                                    <input v-model="showAllPages" type="checkbox" />

                                    Show all pages
                                </label> -->
                            </template>
                        </div>

                        <div class="flex w-full items-center justify-center border mt-2 bg-gray-300">
                            <div class="hidden lg:block">
                                <vue-pdf-embed
                                    ref="pdfRef"
                                    :width="780"
                                    :source="materi.media_file"
                                    :page="page"
                                    @rendered="handleDocumentRender"
                                />
                            </div>

                            <div class="block lg:hidden">
                                <vue-pdf-embed
                                    ref="pdfRef"
                                    :width="340"
                                    :source="materi.media_file"
                                    :page="page"
                                    @rendered="handleDocumentRender"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/4">
                    <div class="w-full flex mb-5">
                        <div class="w-12 h-12 lg:mr-5 flex-none box-border overflow-hidden flex items-center justify-center">
                            <img src="https://w7.pngwing.com/pngs/803/467/png-transparent-school-learning-icon-hand-painted-cartoon-school-learning-materials-watercolor-painting-painted-text.png" alt="" class="h-full object-cover">
                        </div>
                        <div class="w-full flex-1 relative">
                            
                        </div>
                    </div>

                    <div class="w-full box-border">
                        <h1 class="text-sm font-medium mb-3 text-justify" v-html="materi.judul"></h1>
                        <div class="text-[12px] text-justify" v-html="materi.deskripsi"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>