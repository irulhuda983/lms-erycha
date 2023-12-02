<script setup>
import { ref } from 'vue'
import DefaultUserImg from '@/assets/img/default_user.jpg'
import { useAuthStore } from "@/stores/auth"
import { useRoute, useRouter } from 'vue-router'

const store = useAuthStore()
const route = useRoute()
const router = useRouter()
const largeMenu = ref(false)

const showMobileMenu = ref(false)

const userData = localStorage.getItem('USER') ? JSON.parse(localStorage.getItem('USER')) : {}

const navigateMenu = (menu) => {
    showMobileMenu.value = false
    router.push({ name: menu })
}

const logout = () => {
    store.logout()
}

</script>

<template>
    <div class="z-[9] sticky w-full h-full box-border flex items-center justify-between px-5 py-3 bg-white shadow-md">
        <div class="flex items-center justify-center">
            <button @click.prevent="showMobileMenu = true" class="hover:text-gray-300 mr-3 block lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                </svg>
            </button>
            <div class="text-[#060144] font-semibold text-lg uppercase">{{ route.meta.title }}</div>
        </div>
        <!-- <a href="" class="font-semibold text-base text-white mt-10 mb-12">L M S</a> -->
        <div class="flex items-center justify-center space-x-3">
            <div class="cursor-pointer box-border w-auto flex items-center justify-center bg-white border rounded-lg p-2">
                <div class="rounded-full bg-blue-300 h-8 w-8 mr-2 overflow-hidden">
                    <img :src="userData.foto ?? DefaultUserImg" alt="">
                </div>
                <div>
                    <div class="text-xs">{{ userData.nama }}</div>
                    <div class="text-[10px] capitalize">{{ userData.role }}</div>
                </div>
            </div>

            <div class="w-px h-10 bg-gray-300"></div>

            <svg @click.prevent="logout()" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer text-gray-600 hover:text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
        </div>
    </div>

    <!-- menu -->
        <div v-if="showMobileMenu" class="block lg:hidden w-screen h-screen fixed top-0 z-[9999] bg-white">
        <div class="w-full h-full box-border bg-white text-[#0d1216] flex items-center flex-col">
            <div class="mt-5 mb-3 w-full box-border px-3 flex space-x-3 border-b pb-5 border-gray-400">
                <div class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center bg-[#171F46] text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 fill-current">
                        <path d="M12 8a3 3 0 003-3 3 3 0 00-3-3 3 3 0 00-3 3 3 3 0 003 3m0 3.54C9.64 9.35 6.5 8 3 8v11c3.5 0 6.64 1.35 9 3.54 2.36-2.19 5.5-3.54 9-3.54V8c-3.5 0-6.64 1.35-9 3.54z"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-base">DMC LMS</div>
                    <div class="text-[10px]">Digital Marketing.</div>
                </div>
            </div>

            <div @click.prevent="showMobileMenu = false" class="w-8 h-8 rounded-full bg-red-500 border border-red-500 text-white hover:bg-red-300 hover:border-red-300 absolute flex items-center justify-center top-6 right-3 text-gray-400 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <div class="w-full box-border px-3">
                <a href="#"
                    @click.prevent="navigateMenu('home')"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'home' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>

                    <div>Home</div>
                </a>

                <a href="#"
                    @click.prevent="navigateMenu('master')"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'master' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>

                    <div>Master Data</div>
                </a>

                <a href="#"
                    @click.prevent="navigateMenu('materi')"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'materi' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>

                    <div>Materi</div>
                </a>

                <a href="#"
                    @click.prevent="navigateMenu('soal')"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'soal' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                    </svg>

                    <div>Bank Soal</div>
                </a>

                <a href="#"
                    @click.prevent="navigateMenu('ujian')"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'ujian' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                    </svg>

                    <div>Ujian</div>
                </a>

                <a href="#"
                    @click.prevent="navigateMenu('users')"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'users' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    <div>Users</div>
                </a>

            </div>
        </div>
    </div>
</template>