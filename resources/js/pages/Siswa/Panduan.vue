<script setup>
import CoverPanduan from '@/assets/img/cover-panduan.png'
import ManualBook from '@/assets/file/manual-book.pdf'
import axios from "axios"

const downloadItem = (url) => {
    axios.get(url, { responseType: 'blob' })
      .then(response => {
        const href = window.URL.createObjectURL(response.data);

        const anchorElement = document.createElement('a');

        anchorElement.href = href;
        anchorElement.download = 'manual-book.pdf';

        document.body.appendChild(anchorElement);
        anchorElement.click();

        document.body.removeChild(anchorElement);
        window.URL.revokeObjectURL(href);
      }).catch(console.error)
}
</script>

<template>
    <div class="w-full box-border p-5 mt-14">
        <div class="w-full relative overflow-x-auto sm:rounded-lg">
            <div class="w-full lg:w-1/4 bg-white box-border overflow-hidden rounded-lg">
                <div class="w-full box-border">
                    <img :src="CoverPanduan" alt="">
                </div>

                <div class="w-full box-border p-4">
                    <p class="font-semibold text-xs lg:text-sm mb-5">Buku Panduan Penggunaan Aplikasi (Manual Book) DMC LMS App.</p>
                    <button @click.prevent="downloadItem('/manual-book.pdf')" class="w-full bg-[#059BDD] text-white box-border p-2 rounded font-semibold">Download</button>
                </div>
            </div>
        </div>
    </div>
</template>