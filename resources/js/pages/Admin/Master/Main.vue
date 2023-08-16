<script setup>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

// onMounted(() => {
//     console.log(route.meta.subMenu)
// })
</script>


<template>
    <div class="w-full box-border p-5">
        <nav class="bg-white border-gray-200 dark:bg-gray-900 border-b">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                    <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li>
                            <router-link
                                :to="{name: 'kelas'}"
                                class="block py-2 pl-3 pr-4 rounded hover:text-blue-700"
                                :class="route.meta.subMenu == 'kelas' ? 'text-blue-700' : 'text-gray-900 '"
                            >
                            Kelas</router-link>
                        </li>
                        <li>
                            <router-link
                                :to="{name: 'mapel'}"
                                class="block py-2 pl-3 pr-4 rounded hover:text-blue-700"
                                :class="route.meta.subMenu == 'mapel' ? 'text-blue-700' : ''"
                            >Mapel</router-link>
                        </li>
                        <li>
                            <router-link
                                :to="{name: 'rombel'}"
                                class="block py-2 pl-3 pr-4 rounded hover:text-blue-700"
                                :class="route.meta.subMenu == 'rombel' ? 'text-blue-700' : ''"
                            >Rombel</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div>
            <router-view></router-view>
        </div>
    </div>
</template>