<script setup>

import { useRouter, useRoute } from 'vue-router'

const route = useRoute()

</script>

<template>
    <div class="w-full h-full relative box-border flex items-center justify-center bg-white">
        <div class="w-full h-full box-border bg-white text-[#0d1216] flex items-center flex-col">
            <div class="mt-10 mb-3 w-full box-border px-3 flex space-x-3">
                <div class="w-10 h-10 rounded-full bg-gray-400"></div>
                <div>
                    <div class="font-semibold text-base">Erycha</div>
                    <div class="text-[10px]">Admin</div>
                </div>
            </div>

            <div class="w-full h-12 box-border relative cursor-pointer mb-5">
                <div class="w-8 h-8 rounded-full bg-white border border-gray-400 absolute flex items-center justify-center -right-3 text-gray-400 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
            <div class="w-full box-border px-3">
                <router-link
                    :to="{name: 'home'}"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'home' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>

                    <div>Home</div>
                </router-link >

                <router-link
                    :to="{name: 'master'}"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'master' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>

                    <div>Master Data</div>
                </router-link>

                <router-link
                    :to="{name: 'materi'}"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'materi' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>

                    <div>Materi</div>
                </router-link>

                <router-link
                    :to="{name: 'soal'}"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'soal' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                    </svg>

                    <div>Bank Soal</div>
                </router-link>

                <router-link
                    :to="{name: 'ujian'}"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'ujian' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                    </svg>

                    <div>Ujian</div>
                </router-link>

                <router-link
                    :to="{name: 'users'}"
                    class="mb-3 block w-full flex space-x-3 p-2 rounded hover:bg-zinc-100"
                    :class="route.meta.menu == 'users' ? 'bg-zinc-100' : ''"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    <div>Users</div>
                </router-link>

            </div>
        </div>
    </div>
</template>