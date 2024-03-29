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

const contenType = ref('desc');

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
                    <button @click.prevent="changeMediaType('desc')" :class="contenType == 'desc' ? 'text-green-500' : 'hover:text-green-500'">Deskripsi</button>
                    <button @click.prevent="changeMediaType('doc')" :class="contenType == 'doc' ? 'text-green-500' : 'hover:text-green-500'">Dokumen</button>
                    <button @click.prevent="changeMediaType('video')" class="hidden" :class="contenType == 'video' ? 'text-green-500' : 'hover:text-green-500'">Video</button>
                    <router-link :to="{ name: 'siswaMateri'}" class="inline-block border rounded py-1.5 px-4 text-[12px] hover:border-red-400 hover:bg-red-400  hover:text-white">Kembali</router-link>
                </div>
            </div>

            <div v-if="materi.length != 0" class="w-full box-border mb-10 lg:flex lg:items-start">
                <div class="w-full box-border mb-5 lg:mb-0 lg:mr-5 border-b border-gray-400 lg:border-none">
                    <div v-if="contenType == 'desc'" class="w-full">
                        <div class="w-full flex items-center mb-2">
                            <div class="w-12 h-12 lg:mr-5 flex-none box-border overflow-hidden flex items-center justify-center">
                                <img :src="materi.media_image ?? 'https://w7.pngwing.com/pngs/803/467/png-transparent-school-learning-icon-hand-painted-cartoon-school-learning-materials-watercolor-painting-painted-text.png'" alt="" class="h-full object-cover">
                            </div>
                            <div class="w-full flex-1 relative">
                                <h1 class="text-sm font-medium mb-3 text-justify" v-html="materi.judul"></h1>
                            </div>
                        </div>

                        <div class="w-full box-border">
                            <div class="w-full flex flex-col lg:flex-row lg:items-center justify-between mb-7 pb-2 border-b">
                                <p class="text-[11px] text-[#424242]">Mata Pelajaran : <span class="uppercase">{{ materi.mapel }}</span></p>
                                <p class="text-[#6D6D6D] text-[11px]">Dibuat Oleh : {{ materi.guru  }}</p>
                                <p class="text-[#6D6D6D] text-[11px]">{{ materi.date_created }}</p>
                            </div>
                            <div id="box-desc" class="text-[12px] text-justify" v-html="materi.deskripsi"></div>
                        </div>
                    </div>
                    <vue3-video-player v-if="contenType == 'video'" @play="play" :src="materi.media_video"></vue3-video-player>
                    <div v-if="contenType == 'doc'" class="w-full">
                        <div class="flex w-full items-center justify-center border mt-2 bg-gray-300">
                            <div class="hidden lg:block">
                                <vue-pdf-embed
                                    ref="pdfRef"
                                    :width="890"
                                    :source="materi.media_file"
                                    :page="page"
                                    @rendered="handleDocumentRender"
                                />
                            </div>

                            <div class="block lg:hidden">
                                <vue-pdf-embed
                                    ref="pdfRef"
                                    :width="420"
                                    :source="materi.media_file"
                                    :page="page"
                                    @rendered="handleDocumentRender"
                                />
                            </div>
                        </div>

                        <div class="w-full mt-2">
                            <template v-if="isLoading"> Loading... </template>

                            <template v-else>
                                <span v-if="showAllPages"> {{ pageCount }} page(s) </span>
                                <div v-else class="w-full flex items-center justify-center space-x-3 mb-3">
                                    <button class="box-border px-3 py-1.5 rounded bg-gray-200" :disabled="page <= 1" @click="page--">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                        </svg>
                                    </button>

                                    <div class="box-border px-3 py-1 rounded bg-gray-200">{{ page }} / {{ pageCount }}</div>

                                    <button class="box-border px-3 py-1.5 rounded bg-gray-200" :disabled="page >= pageCount" @click="page++">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- <label class="right">
                                    <input v-model="showAllPages" type="checkbox" />

                                    Show all pages
                                </label> -->
                            </template>
                        </div>
                    </div>
                </div>
                <!-- <div class="w-full lg:w-1/4">
                    <div class="w-full flex mb-5">
                        <div class="w-12 h-12 lg:mr-5 flex-none box-border overflow-hidden flex items-center justify-center">
                            <img :src="materi.media_image ?? 'https://w7.pngwing.com/pngs/803/467/png-transparent-school-learning-icon-hand-painted-cartoon-school-learning-materials-watercolor-painting-painted-text.png'" alt="" class="h-full object-cover">
                        </div>
                        <div class="w-full flex-1 relative">
                            
                        </div>
                    </div>

                    <div class="w-full box-border">
                        <h1 class="text-sm font-medium mb-3 text-justify" v-html="materi.judul"></h1>
                        <div id="box-desc" class="text-[12px] text-justify" v-html="materi.deskripsi"></div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>

<style>
#box-desc ol {
    list-style-type: decimal;
    margin-left: 20px;
}
</style>