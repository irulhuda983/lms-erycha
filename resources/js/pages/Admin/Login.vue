<script setup>
import { reactive, ref } from "vue"
import { useAuthStore } from "@/stores/auth"
import { useRouter } from "vue-router"
import { useNotification } from "@kyvg/vue3-notification"
import EyeIcon from '@/components/icons/EyeIcon.vue'
import EyeOffIcon from '@/components/icons/EyeOffIcon.vue'
import ImgIlustrasi from "@/assets/img/lms.svg"

const { login } = useAuthStore()
const router = useRouter()
const username = ref("")
const password = ref("")
const loading = ref(false)
const { notify } = useNotification()
const eyeVisible = ref(true)
const passwordType = ref('password')
const errors = reactive({
    username: null,
    password: null
})
const flashError = ref(false)

const onLoginHandler = async () => {
    loading.value = true
    try {
        await login({
            username: username.value,
            password: password.value,
            grant_type: 'password',
            client_id: clientId,
            client_secret: clientSecret,
        });

        // router.push({ path: "/admin" })
        loading.value = false
        location.reload()
    } catch (error) {
        loading.value = false
        if (error.status === 403) {
            notify({
                text: "Username atau password salah",
                type: 'error',
                duration: 2000
            })
            flashError.value = true
        }else if(error.status == 422){
            let err = error.data.errors
            console.log(error.data)

            errors.username = err.username ? err.username[0] : null
            errors.password = err.password ? err.password[0] : null
        }else{
            flashError.value = true
            notify({
                text: "Username atau password salah",
                type: 'error',
                duration: 2000
            })
        }
    } finally {
        loading.value = false
    }
}

const togglePasswordInputVisibility = () => {
    eyeVisible.value ? (passwordType.value = 'text') : (passwordType.value = 'password');

    eyeVisible.value = !eyeVisible.value;
}
</script>

<template>
    <div class="w-screen h-screen box-border overflow-x-hidden overflow-y-auto bg-gradient-to-b from-white via-[#4D79FF00] to-[#4D79FF25] text-sm 2xl:text-base">
        <!-- <div class="backdrop-blur-sm w-[100px] h-[170px] rounded-[20px] bg-[#4D79FF]/50 absolute -top-[55px] -left-[25px]">
            <img :src="appUrl+'/img/lantas.png'" alt="" class="w-[90px] absolute -right-[35px] top-[70px]">
        </div> -->

        <div class="w-full h-full flex flex-col lg:flex-row items-center justify-center bg-transparent">
            <div class="hidden lg:flex w-1/2 items-center flex-col justify-center">
                <img :src="ImgIlustrasi" alt="" class="w-[640px] 2xl:w-[720px]">
                <div>
                    <div class="mt-5 font-bold text-2xl text-[#0086DC]">Learning Manajement System</div>
                    <div class="text-center text-gray-500 italic">Powered By erycha</div>
                </div>
            </div>
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-0">
                <div class="w-[480px] 2xl:w-[720px]">
                    <div class="mb-10">
                        <div class="text-[#0086DC] font-bold text-2xl">Login</div>
                        <div class="text-[#8D8D8D]">Silahkan Login Menggunakan Username/NRP dan Password Anda!</div>
                    </div>

                    <div v-if="flashError" class="mb-6 rounded bg-red-200 text-red-600 font-bold box-border p-4 text-xs">
                        Username Atau Password salah
                    </div>
                    
                    <form method="post" @submit.prevent="onLoginHandler">
                        <div class="mb-7 w-full">
                            <div class="relative z-0 w-full group mb-2">
                                <input @focus="errors.username = null" type="text" v-model="username" id="username" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username</label>
                            </div>
                            <div class="text-red-500 text-xs italic">{{ errors.username }}</div>
                        </div>

                        <div class="mb-7 w-full">
                            <div class="relative z-0 w-full mb-2 group">
                                <input @focus="errors.password = null" :type="passwordType" v-model="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />

                                <button
                                    type="button"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 z-10"
                                    @click.prevent="togglePasswordInputVisibility()"
                                >
                                    <EyeIcon v-show="eyeVisible" class="h-5 w-5 text-gray-500" />
                                    <EyeOffIcon v-show="!eyeVisible" class="h-5 w-5 text-gray-500" />
                                </button>

                                <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                            </div>
                            <div class="text-red-500 text-xs italic">{{ errors.password }}</div>
                        </div>
                        
                        <button
                            type="submit"
                            class="mt-10 block w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 font-semibold"
                            :class="[
                                loading ? ' cursor-not-allowed' : '',
                                loading ? 'bg-blue-800' : 'bg-blue-700',
                            ]"
                            >
                                {{ loading ? 'Memuat...' : 'Login' }}
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>