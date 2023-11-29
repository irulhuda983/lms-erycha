<script setup>
import { onMounted } from "vue"
import { useAuthStore } from "@/stores/auth"

const { userSiswa } = useAuthStore()
const userData = JSON.parse(userSiswa)

onMounted(() => {
    console.log(userData)
})
</script>


<template>
    <!-- absolute top-0 z-[999] -->
    <div class="w-full h-[60px] bg-[#171F46] text-white flex items-center justify-between box-border px-4 lg:px-8">
        <div>
            <div class="font-semibold">DMZ LMS</div>
        </div>
        <div class="">
            <button
                class="flex justify-center items-center group"
            >
                <div class="w-8 h-8 rounded-full box-border overflow-hidden flex items-center justify-center mr-1">
                    <img class="w-full" src="https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-512.png" alt="User" />
                </div>

                <div class="flex flex-col items-center truncate">
                    <span class="truncate ml-2 text-xs font-semibold group-hover:text-gray-400 capitalize">{{ userData.nama}} .</span>
                    <!-- <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400" viewBox="0 0 12 12">
                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                    </svg> -->
                </div>
            </button>
        </div>
    </div>
</template>