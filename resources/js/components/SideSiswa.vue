<script setup>
import { useRouter, useRoute } from 'vue-router'

// import HomeIcon from '@/assets/icons/Home.vue'
// import InviteIcon from '@/assets/icons/Invite.vue'
// import TemplateIcon from '@/assets/icons/Template.vue'
// import SignoutIcon from '@/assets/icons/Signout.vue'

const route = useRoute()

</script>

<template>
    <!-- 8859FF -->
    <div class="hidden lg:flex w-full h-full box-boder flex-row lg:flex-col relative bg-[#171F46]">
        <!-- logo -->
        <div class="w-full mt-[32px] box-border w-full flex items-center justify-center flex-col mb-[65px]">
            <div class="w-[100px] h-[100px] bg-white rounded-full flex items-center justify-center mb-[8px]">
                <p class="text-[42px] text-[#171F46] font-bold">    
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 lg:w-16 lg:h-16 fill-current">
                        <path d="M12 8a3 3 0 003-3 3 3 0 00-3-3 3 3 0 00-3 3 3 3 0 003 3m0 3.54C9.64 9.35 6.5 8 3 8v11c3.5 0 6.64 1.35 9 3.54 2.36-2.19 5.5-3.54 9-3.54V8c-3.5 0-6.64 1.35-9 3.54z"></path>
                    </svg>
                </p>
            </div>
            <div class="font-medium text-white text-[18px]">DMC LMS App.</div>
        </div>
        <!-- end logo -->

        <div class="w-full h-full lg:flex-1 flex flex-row lg:flex-col px-[32px]">
            <div class="text-white text-[12px] font-medium mb-[12px]">Overview</div>
            <div class="w-full box-border flex flex-col lg:flex-col text-[13px]">
                <router-link
                    :to="{name: 'siswaHome'}"
                    class="mb-1 block w-full h-[45px] flex items-center space-x-3 px-[16px] rounded-[10px]"
                    :class="route.meta.menu == 'siswaHome' ? 'bg-[#FFFFFF] text-[#171F46] font-semibold' : 'text-white'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>

                    <div>Dashboard</div>
                </router-link>

                <router-link
                    :to="{name: 'siswaMateri'}"
                    class="mb-1 block w-full h-[45px] flex items-center space-x-3 px-[16px] rounded-[10px]"
                    :class="route.meta.menu == 'siswaMateri' ? 'bg-[#FFFFFF] text-[#171F46] font-semibold' : 'text-white'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>

                    <div>Materi</div>
                </router-link>

                <router-link
                    :to="{name: 'siswaUjian'}"
                    class="mb-1 block w-full h-[45px] flex items-center space-x-3 px-[16px] rounded-[10px]"
                    :class="route.meta.menu == 'siswaUjian' ? 'bg-[#FFFFFF] text-[#171F46] font-semibold' : 'text-white'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                    </svg>

                    <div>Ujian</div>
                </router-link>

                <router-link
                    :to="{name: 'siswaProfil'}"
                    class="mb-1 block w-full h-[45px] flex items-center space-x-3 px-[16px] rounded-[10px]"
                    :class="route.meta.menu == 'siswaProfil' ? 'bg-[#FFFFFF] text-[#171F46] font-semibold' : 'text-white'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>

                    <div>Profil</div>
                </router-link>
            </div>
        </div>

        <div class="w-full flex items-center justify-center py-6 box-border">
            <button
                class="flex items-center justify-center text-slate-400 hover:text-slate-300"
            >
                <div class="w-5 h-5">
                    <!-- <SignoutIcon/> -->
                </div>
            </button>
        </div>
    </div>

    <div class="lg:hidden w-full box-border overflow-hidden px-4 py-2 bg-[#171F46] flex items-center justify-between">
        <router-link
            :to="{name: 'siswaHome'}"
            class="w-16 box-border flex items-center justify-center flex-col p-2 pb-1 rounded"
            :class="route.meta.menu == 'siswaHome' ? 'bg-[#FFFFFF] text-[#171F46] font-semibold' : 'text-white'"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>

            <div class="text-[8px]">Dashboard</div>
        </router-link>

        <router-link
            :to="{name: 'siswaMateri'}"
            class="w-16 box-border flex items-center justify-center flex-col p-2 pb-1 rounded"
            :class="route.meta.menu == 'siswaMateri' ? 'bg-[#FFFFFF] text-[#171F46] font-semibold' : 'text-white'"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>

            <div class="text-[8px]">Materi</div>
        </router-link>

        <router-link
            :to="{name: 'siswaUjian'}"
            class="w-16 box-border flex items-center justify-center flex-col p-2 pb-1 rounded"
            :class="route.meta.menu == 'siswaUjian' ? 'bg-[#FFFFFF] text-[#171F46] font-semibold' : 'text-white'"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
            </svg>

            <div class="text-[8px]">Ujian</div>
        </router-link>

        <router-link
            :to="{name: 'siswaProfil'}"
            class="w-16 box-border flex items-center justify-center flex-col p-2 pb-1 rounded"
            :class="route.meta.menu == 'siswaProfil' ? 'bg-[#FFFFFF] text-[#171F46] font-semibold' : 'text-white'"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>

            <div class="text-[8px]">Profil</div>
        </router-link>
    </div>
</template>