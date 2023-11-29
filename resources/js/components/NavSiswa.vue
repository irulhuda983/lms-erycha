<script setup>
import DefaultUserImg from '@/assets/img/default_user.jpg'
import { useAuthStore } from "@/stores/auth"
import { useRoute } from 'vue-router'

const store = useAuthStore()
const route = useRoute()

const userData = localStorage.getItem('USERSISWA') ? JSON.parse(localStorage.getItem('USERSISWA')) : {}

const logout = () => {
    store.logoutSiswa()
}

</script>


<template>
    <div class="w-full h-14 bg-white border-b border-zinc-200 flex items-center justify-between box-border px-4 absolute top-0 z-20">
        <div>
            <div class="font-semibold">{{ route.meta.title }}</div>
        </div>
        <div class="">
            <button
                class="flex justify-center items-center group"
            >
                <div class="w-8 h-8 rounded-full box-border overflow-hidden flex items-center justify-center mr-3 lg:mr-1">
                    <img class="w-full" :src="userData.foto ?? DefaultUserImg" alt="User" />
                </div>

                <div class="flex items-center truncate">
                    <span class="hidden lg:block truncate ml-2 text-xs font-semibold group-hover:text-gray-800 mr-2 capitalize">{{ userData.nama }} .</span>

                    <div class="h-6 w-px bg-gray-400 mr-2"></div>
                    <!-- <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400" viewBox="0 0 12 12">
                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                    </svg> -->

                    <svg @click.prevent="logout()" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hover:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                </div>
            </button>
        </div>
    </div>
</template>