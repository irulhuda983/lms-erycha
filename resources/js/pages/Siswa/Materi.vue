<script setup>
import MateriImg from '@/assets/img/materi.png'
import { ref, defineAsyncComponent, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from "@/stores/auth"
import { useTesStore } from "@/stores/tes"
import { useNotification } from "@kyvg/vue3-notification"

const Pagination = defineAsyncComponent(() => import('@/components/Pagination.vue'))
const { tokenSiswa } = useAuthStore()
const router = useRouter()
const tesStore = useTesStore()
const { notify } = useNotification()
const dataset = ref([])
const isLoading = ref(false)
const isGrid = ref(false)

const cekIsRun = () => {
    if(tesStore.isRunningTest == 1) {
        router.push({ path: '/tes' })
    }
}

const pageInfo = ref({
    current_page: 1,
    from: null,
    last_page: 1,
    per_page: 10,
    to: null,
    total: 0
})

const params = reactive({
    search: "",
    page: 1,
    limit: 10,
    order: "judul:asc",
})

const fetchData = async () => {
    isLoading.value = true
    try{
        const { data } = await instanceSiswa({
            url: 'peserta/materi',
            method: 'GET',
            params: params,
        })

        dataset.value = data.data
        pageInfo.value = data.meta
    }catch(e) {
        if(e.response.status == 401) {
            localStorage.removeItem('TOKENSISWA')
            location.reload()
        }
    }finally {
        isLoading.value = false
    }
}

const changePage = (page) => {
    params.page = page
    fetchData()
}

onMounted(() => {
    cekIsRun()
    fetchData()
})
</script>


<template>
    <div class="w-full box-border overflow-x-hidden h-full pt-[80px] px-4">
        <div class="w-full box-border flex items-center justify-between border-b border-gray-400 pb-3 mb-5">
            <div class="w-full box-border flex items-center space-x-3 mb-2 lg:mb-0 pr-2">
                <input v-model="params.search" type="text" placeholder="Cari" class="w-full lg:w-96 rounded box-border px-4 py-2 bg-gray-50 text-gray-600 text-xs outline-none" @change.prevent="fetchData()">

                <!-- <select class="hidden lg:block rounded box-border px-4 py-2 text-xs font-semibold outline-none cursor-pointer">
                    <option value="">Kecamatan</option>
                </select> -->
            </div>
        </div>

        <div class="w-full box-border grid grid-cols-1 lg:grid-cols-4 gap-5 mb-5">

            <router-link
                class="w-full bg-white box-border pb-5 shadow-secondary rounded-[8px] overflow-hidden h-[350px] relative cursor-pointer"
                v-for="(item, i) in dataset" :key="i"
                :to="{ name: 'siswaDetailMateri', params: { id: item.id} }"
            >
                <div class="w-full h-[160px] box-border overflow-hidden flex items-center justify-center">
                    <img :src="item.media_image ?? MateriImg " alt="" class="w-full object-cover">
                </div>

                <div class="w-full p-3 box-border">
                    <p class="text-[#222222] text-[12px] lg:text-[16px] font-semibold mb-[8px] mt-2">{{ item.judul }}</p>
                    <div class="w-full flex items-center justify-between mb-px">
                        <p class="text-[10px] text-[#424242] uppercase">{{ item.mapel }}</p>
                        <p class="text-[#6D6D6D] text-[10px] italic">{{ item.date_created }}</p>
                    </div>
                    <p class="text-[#6D6D6D] text-[9px] italic mb-4">Created By : {{ item.guru  }}</p>
                    <p class="text-[#222222] text-[10px]" v-html="item.excerpt"></p>
                </div>
            </router-link>
        </div>
    </div>
</template>