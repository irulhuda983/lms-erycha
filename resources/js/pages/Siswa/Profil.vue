<script setup>
import { ref } from 'vue'
import DefaultUserImg from '@/assets/img/default_user.jpg'
import { useAuthStore } from "@/stores/auth"
import { useRoute } from 'vue-router'

const store = useAuthStore()
const route = useRoute()

const userData = store.userSiswa ? JSON.parse(store.userSiswa) : {}
const prevImage = ref(userData.foto)
const refFotoUser = ref()

const payload = ref({
    id: userData.id,
    nama: userData.nama,
})

const errors = {
    image: null,
}

const readImage = () => {
    errors.image = null
    const files = refFotoUser.value.files[0]
    const sizeFile = files.size
    const tipeFile = files.type

    const arrType = ['image/jpg', 'image/jpeg', 'image/svg+xml', 'image/gif', 'image/png']
    const maxFile = 2 * 1048576

    if(!arrType.includes(tipeFile)) {
        errors.image = 'Type File must be jpg, jpeg, png, svg or gif'
        return
    }

    if(sizeFile > maxFile) {
        errors.image = 'file size cannot be larger than 2 mb'
        return
    }

    prevImage.value = URL.createObjectURL(files)
}

</script>


<template>
    <div class="w-full box-border p-5 mt-14">
        <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="box-border px-6 py-6 border-b bg-white">
                <div class="w-full mb-3 border-b">
                    <div class="flex items-center justify-between w-full pb-2">
                        <h4 class="font-medium text-gray-700 text-lg">Public Profil</h4>
                        <div class="flex items-center justify-end">
                            <!-- <button class="inline-block border rounded py-1.5 px-4 text-[12px] hover:border-indigo-400 hover:bg-indigo-400  hover:text-white">Edit Profil</button> -->
                        </div>
                    </div>
                </div>

                <div class="w-full box-border mt-5 lg:mt-10 flex flex-col-reverse lg:flex-row items-start justify-between">
                    <div class="w-full lg:w-3/4 box-border overflow-hidden mr-0 lg:mr-5">
                        <div class="mb-3 w-full">
                            <label for="lama_ujian" class="block mb-px text-[12px] dark:text-white">Nama Lengkap</label>
                            <div class="w-full flex items-center">
                                <!-- <input v-model="payload.lama_ujian" type="number" id="lama_ujian"
                                    class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mr-2"
                                    :class="errors.lama_ujian ? 'border-red-400':'border-gray-300'"
                                    @focus="errors.lama_ujian = null"
                                > -->
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ userData.nama }}</div>
                            </div>
                            <!-- <div v-if="errors.lama_ujian" class="text-red-500 italic text-xs mt-1">{{ errors.lama_ujian }}</div> -->
                        </div>

                        <div class="mb-3 w-full">
                            <label for="lama_ujian" class="block mb-px text-[12px] dark:text-white">NIK/No. Identitas</label>
                            <div class="w-full flex items-center">
                                <!-- <input v-model="payload.lama_ujian" type="number" id="lama_ujian"
                                    class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mr-2"
                                    :class="errors.lama_ujian ? 'border-red-400':'border-gray-300'"
                                    @focus="errors.lama_ujian = null"
                                > -->
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ userData.nik ?? '-' }}</div>
                            </div>
                            <!-- <div v-if="errors.lama_ujian" class="text-red-500 italic text-xs mt-1">{{ errors.lama_ujian }}</div> -->
                        </div>

                        <div class="mb-3 w-full">
                            <label for="lama_ujian" class="block mb-px text-[12px] dark:text-white">Jenis Kelamin</label>
                            <div class="w-full flex items-center">
                                <!-- <input v-model="payload.lama_ujian" type="number" id="lama_ujian"
                                    class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mr-2"
                                    :class="errors.lama_ujian ? 'border-red-400':'border-gray-300'"
                                    @focus="errors.lama_ujian = null"
                                > -->
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ userData.gender == 'l' ? 'Laki-laki' : 'Perempuan' }}</div>
                            </div>
                            <!-- <div v-if="errors.lama_ujian" class="text-red-500 italic text-xs mt-1">{{ errors.lama_ujian }}</div> -->
                        </div>

                        <div class="mb-3 w-full">
                            <label for="lama_ujian" class="block mb-px text-[12px] dark:text-white">Tempat, Tanggal Lahir</label>
                            <div class="w-full flex items-center">
                                <!-- <input v-model="payload.lama_ujian" type="number" id="lama_ujian"
                                    class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mr-2"
                                    :class="errors.lama_ujian ? 'border-red-400':'border-gray-300'"
                                    @focus="errors.lama_ujian = null"
                                > -->
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ userData.tempat_lahir ?? '-' }}, {{ userData.tanggal_lahir ?? '-' }}</div>
                            </div>
                            <!-- <div v-if="errors.lama_ujian" class="text-red-500 italic text-xs mt-1">{{ errors.lama_ujian }}</div> -->
                        </div>

                        <div class="mb-3 w-full">
                            <label for="lama_ujian" class="block mb-px text-[12px] dark:text-white">Alamat/Domisili</label>
                            <div class="w-full flex items-center">
                                <!-- <input v-model="payload.lama_ujian" type="number" id="lama_ujian"
                                    class="bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mr-2"
                                    :class="errors.lama_ujian ? 'border-red-400':'border-gray-300'"
                                    @focus="errors.lama_ujian = null"
                                > -->
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ userData.alamat ?? '-' }}</div>
                            </div>
                            <!-- <div v-if="errors.lama_ujian" class="text-red-500 italic text-xs mt-1">{{ errors.lama_ujian }}</div> -->
                        </div>
                    </div>

                    <div class="w-full lg:w-1/4 box-border mb-5 lg:mb-0">
                        <div class="w-full box-border flex items-center justify-center">
                            <label for="foto-user" class="flex flex-col items-center justify-center h-32 lg:h-64 border border-gray-400 rounded-lg cursor-pointer bg-gray-400 overflow-hidden">
                                <img
                                    :src="prevImage ?? DefaultUserImg"
                                    alt=""
                                    loading="lazy"
                                    class="h-full object-cover object-center"
                                />

                                <input id="foto-user" ref="refFotoUser" type="file" class="sr-only" @change="readImage" />
                            </label>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>