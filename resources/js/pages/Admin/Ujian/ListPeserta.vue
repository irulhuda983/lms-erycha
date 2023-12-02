<template>
    <div class="w-full box-border bg-white border-b text-gray-600 bg-white">
        <div class="border-b px-6 py-3 text-black">
            <h1 class="text-sm font-bold">List Peserta Ujian</h1>
        </div>

        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b">
                <tr>
                    <th scope="col" class="px-6 py-3" style="width: 2%;">No</th>
                    <th scope="col" class="px-6 py-3">Nama Peserta</th>
                    <th scope="col" class="px-6 py-3">Waktu Ujian</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3"></th>
                </tr>
            </thead>

            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white" style="width: 1%;">1</td>
                    <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div>M. Khoirul Huda</div>
                        <div class="text-[8px] text-gray-500">NIK : -</div>
                    </td>
                    <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white text-[12px]">
                        <div class="flex items-center"><div class="w-14">Mulai</div> : 11-11-2023 08:00</div>
                        <div class="flex items-center"><div class="w-14">selesai</div> : 11-11-2024 09:00</div>
                    </td>
                    <td class="px-6 py-4 font-normal text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="flex items-center text-green-400">
                            <div class="mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 spin-invinite">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </div>
                            <div class="text-[10px] show-hide-animation">Sedang Mengerjakan</div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>