<script setup>
const props = defineProps(['width'])
</script>


<template>
    <!-- container -->
    <div id="container" class="w-screen h-screen box-border fixed top-0 left-0 z-[9999999999] bg-black/10">
        <div id="progress-container" class="w-full h-[6px] box-border overflow-hidden">
            <div id="progress-bar" class="h-full bg-gradient-to-r from-lime-400 to-green-400" :style="`width: ${props.width}%`"></div>
        </div>
    </div>
</template>