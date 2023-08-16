<script setup>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

</script>


<template>
    <div class="w-full box-border p-5">
        <nav class="bg-white border-gray-200 dark:bg-gray-900 border-b">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                    <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li>
                            <router-link
                                :to="{name: 'guru'}"
                                class="block py-2 pl-3 pr-4 rounded hover:text-blue-700"
                                :class="route.meta.subMenu == 'guru' ? 'text-blue-700' : 'text-gray-900 '"
                            >
                            Guru</router-link>
                        </li>
                        <li>
                            <router-link
                                :to="{name: 'siswa'}"
                                class="block py-2 pl-3 pr-4 rounded hover:text-blue-700"
                                :class="route.meta.subMenu == 'siswa' ? 'text-blue-700' : ''"
                            >Siswa</router-link>
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