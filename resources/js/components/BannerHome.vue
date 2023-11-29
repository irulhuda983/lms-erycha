<script setup>
import Ilustrasi from '@/assets/img/ilustrasi.png'

const props = defineProps(['user'])
</script>

<template>
    <!-- bg-gradient-to-tr from-[#5072EE] to-purple-400 -->
    <div class="hidden lg:flex w-full h-[320px] rounded-3xl shadow-lg bg-[#5072EE] relative box-border py-12 shadow-xl px-6">
        <div id="svg" class="w-1/2 mr-2">
            <img :src="Ilustrasi" alt="">
        </div>
        <div class="text-white font-bold w-1/2">
            <p class="font-medium text-[20px] mb-1">Selamat Datang</p>
            <p class="font-semibold text-[28px] mb-4 capitalize">{{ user.nama }}</p>
            <p class="font-medium text-[13px] mb-2 text-gray-100">Mari kita mulai hari ini dengan mempelajari sesuatu sekarang. Jangan lupa memeriksa daftar materi yang tersedia. Semoga harimu menyenangkan.</p>
        </div>
    </div>

    <div class="block lg:hidden w-full h-[170px] rounded-xl shadow-lg bg-[#5072EE] relative box-border p-4 shadow-xl overflow-hidden relative">
        <div class="w-full text-white box-border">
            <p class="font-medium text-base mb-1">Selamat Datang</p>
            <p class="font-semibold text-lg mb-4 capitalize">{{ user.nama }}</p>
            <p class="font-medium text-[13px] mb-2 text-gray-100 pr-32 box-border">Mari kita mulai hari ini dengan mempelajari sesuatu sekarang.</p>
        </div>
        <div id="svg" class="w-32 h-32 absolute -bottom-12 right-0">
            <img :src="Ilustrasi" alt="" class="w-full">
        </div>
    </div>
</template>